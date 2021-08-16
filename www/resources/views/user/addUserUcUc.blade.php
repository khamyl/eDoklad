@extends('../home')
@section('style')
    <style>
        .autocomplete-items {
            position: relative;
            border-bottom: none;
            border-top: none;
            z-index: 9999;
            /*position the autocomplete items to be the same width as the container:*/
            top: 100%;
            left: 0;
            right: 0;
        }

        .autocomplete-items div {
            padding: 10px;
            cursor: pointer;
            background-color: #fff;
            border: 1px solid #d4d4d4;
            width: 93%;
        }

        .autocomplete-items div:hover {
            /*when hovering an item:*/
            background-color: #e9e9e9;
        }

        .autocomplete-active {
            /*when navigating through the items using the arrow keys:*/
            background-color: DodgerBlue !important;
            color: #ffffff;
        }
    </style>
    @endsection
@section('content')
    <div class="container">
        <div class="col-md-12">
            <div class="table-responsive">
                <table style="width: 100%" id="user_data" class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <td contenteditable style="border-right: none!important;background-color: rgb(239, 239, 239);font-weight: bold">Klienti</td>
                        <td contenteditable style="border-left: none!important;border-right: none!important;background-color: rgb(239, 239, 239)"></td>
                        <td contenteditable style="border-left: none!important;background-color: rgb(239, 239, 239)"></td>
                    </tr>
                    </thead>
                    @foreach($users as $user)
                        <tr>
                            <td style="border-right: none!important;background-color:white">{{$user['name']}}</td>
                            <td  style="border-left: none!important;border-right: none!important;background-color:white">{{$user['email']}}</td>
                            <td  style="border-left: none!important;background-color:white">
                                <a href="delUSerUcUc/{{$user['id']}}" style="font-size: 14px;color: #666666" class="glyphicon glyphicon-remove"><i></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
        <h4>Pridanie uživatela</h4>
        <br/>
        <style>
            .autocomplete-items {
                position: relative;
                border-bottom: none;
                border-top: none;
                z-index: 9999;
                /*position the autocomplete items to be the same width as the container:*/
                top: 100%;
                left: 0;
                right: 0;
            }

            .autocomplete-items div {
                padding: 10px;
                cursor: pointer;
                background-color: #fff;
                border: 1px solid #d4d4d4;
                width: 93%;
            }

            .autocomplete-items div:hover {
                /*when hovering an item:*/
                background-color: #e9e9e9;
            }

            .autocomplete-active {
                /*when navigating through the items using the arrow keys:*/
                background-color: DodgerBlue !important;
                color: #ffffff;
            }
        </style>
        <div class="col-md-6">
            <form action="addUSerUcUc" method="post" class="form-actions">
                <div class="autocomplete ">
                    @csrf

                    <input style="display:inline !important;float: left;width: 40% !important;" class="form-control"
                           id="code" type="text" name="code" placeholder="Kód" required>
                    <button style="margin-left: 5px" type="submit"
                            class="btn btn-icon btn-primary glyphicons circle_ok">
                        <i></i><span style="color: transparent">+</span>
                    </button>
                </div>
            </form>
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
        @if(Session::get('toast')=='wrong')
            <script>
                $.toast({
                    text: 'Zle zadaný kód uživatela !',
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

            /*delete from table*/
            $(document).on('click', '.btn_delete', function () {
                var id = $(this).data("id1");

                if (confirm("Naozaj chcete vymazať data?")) {

                    $.ajax({
                        url: "delUSerUcUc",
                        method: "POST",
                        data: {id: id, '_token': token},
                        dataType: "text",
                        success: function (data) {
                            location.reload();
                        },
                        error: function (data) {
                            alert(data);
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