@extends('../home')

@section('content')
    <div class="container">
        <div class="col-md-12">
            <h2>Uživatelia</h2>
            <br/>
            <div class="table-responsive">
                <table style="width: 100%" id="user_data" class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <td>Meno</td>
                        <td>Priezvisko</td>
                        <td>Email</td>
                        <td>Heslo</td>
                        <td>Práva</td>

                        <td></td>
                    </tr>
                    </thead>

                    <tr>

                        <td id="name" contenteditable></td>
                        <td id="surname" contenteditable></td>
                        <td id="email" contenteditable></td>
                        <td id="pass" contenteditable></td>
                        <td id="rights" contenteditable></td>
                        {{--<select>--}}
                        {{--<option value="admin">admin</option>--}}
                        {{--<option value="user">user</option>--}}
                        {{--</select></td>--}}

                        <td style="text-align:center">
                            <button type="button" name="btn_add" id="btn_add" class="btn btn-xs btn-success">+</button>
                        </td>
                    </tr>

                    @foreach($user as $users)
                        <tr>
                            <td class="name" data-id1="{{$users->id}}" contenteditable>{{$users->name}}</td>
                            <td class="surname" data-id2="{{$users->id}}" contenteditable>{{$users->surname}}</td>
                            <td class="email" data-id3="{{$users->id}}" contenteditable>{{$users->email}}</td>
                            <td class="password" data-id4="{{$users->id}}'"contenteditable>{{$users->password}}</td>
                            <td class="rights" data-id5="{{$users->id}}" contenteditable>{{$users->rights}}</td>
                            <td style="text-align:center">
                                <button type="button" name="delete_btn" data-id4="{{$users->id}}"
                                        class="btn btn-xs btn-danger btn_delete">x
                                </button>
                            </td>
                        </tr>
                    @endforeach


                </table>
            </div>
        </div>
        @if(session()->has('toast'))
            @if(Session::get('toast')=='add')
                <script>
                    $.toast({
                        text: 'Uživatel bol vytvorený !',
                        showHideTransition: 'fade',
                        position: 'top-center',
                        icon: 'success'
                    });
                </script>
            @endif
            @if(Session::get('toast')=='delete')
                <script>
                    $.toast({
                        text: 'Uživatel bol vymazaný !',
                        showHideTransition: 'fade',
                        position: 'top-center',
                        icon: 'error'
                    });
                </script>
            @endif
            @if(Session::get('toast')=='change')
                <script>
                    $.toast({
                        text: 'Data boli úspešne zmenené !',
                        showHideTransition: 'fade',
                        position: 'top-center',
                        icon: 'warning'
                    });
                </script>
            @endif
            <?php Session::forget('toast');
            ?>

        @endif

        <script>
            $(document).ready(function () {

                var token=$('meta[name=csrf-token]').attr('content');


                /*insert into table*/

                $(document).on('click', '#btn_add', function () {
                    var name = $('#name').text();
                    var surname = $('#surname').text();
                    var password = $('#pass').text();
                    var rights = $('#rights').text();
                    var email = $('#email').text();

                    if (name == '') {
                        alert("Vložte meno");
                        return false;
                    }
                    else if (surname == '') {
                        alert("Vložte priezvisko");
                        return false;
                    }
                    else if (email == '') {
                        alert("Vložte e-mail");
                        return false;
                    }
                    else if (password == '') {
                        alert("Vložte heslo");
                        return false;
                    }
                    else if (rights == '') {
                        alert("Vložte práva");
                        return false;
                    }

                    $.ajax({
                        url: "createUser",
                        method: "POST",
                        data: {name: name, surname: surname, pass: password, email: email, rights: rights, '_token': token},
                        dataType: "text",
                        success: function (data) {
                            location.reload();
                        },
                        error: function (data) {
                            alert(data);
                        }

                    })
                });

                /*edit table*/
                function edit_data(id, text, column_name) {
                    $.ajax({
                        url: "editUser",
                        method: "POST",
                        data: {id: id, text: text, colum: column_name, '_token': token},
                        dataType: "text",
                        success: function (data) {
                            location.reload();
                        }
                    });
                }


                $(document).on('blur', '.name', function () {
                    var id = $(this).data("id1");
                    var text_change = $(this).text();
                    edit_data(id, text_change, "name");
                });
                $(document).on('blur', '.surname', function () {
                    var id = $(this).data("id2");
                    var text_change = $(this).text();
                    edit_data(id, text_change, "surname");
                });
                $(document).on('blur', '.email', function () {
                    var id = $(this).data("id3");
                    var text_change = $(this).text();
                    edit_data(id, text_change, "email");
                });
                $(document).on('blur', '.password', function () {
                    var id = $(this).data("id4");
                    var text_change = $(this).text();
                    edit_data(id, text_change, "password");
                });
                $(document).on('blur', '.rights', function () {
                    var id = $(this).data("id5");
                    var text_change = $(this).text();
                    edit_data(id, text_change, "rights");
                });


                /*delete from table*/
                $(document).on('click', '.btn_delete', function () {
                    var id = $(this).data("id4");

                    if (confirm("Naozaj chcete vymazať data?")) {

                        $.ajax({
                            url: "deleteUser",
                            method: "POST",
                            data: {id: id, '_token': token},
                            dataType: "text",
                            success: function (data) {
                                location.reload();
                            }
                        });
                    }

                });
            });


        </script>
    </div>

    <script src="datatables/datatables/js/jquery.dataTables.min.js"></script>
    <script src="datatables/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="datatables/datatables-responsive/dataTables.responsive.js"></script>

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->

    <script>
        $(document).ready(function () {
            $('#user_data').DataTable();
        });
    </script>

@endsection