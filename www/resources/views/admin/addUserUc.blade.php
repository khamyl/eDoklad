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
                        <td>Učtovník</td>
                        <td>Klienti</td>
                    </tr>
                    </thead>
                    @foreach($users as $user)
                        <tr>
                            <td class="name" data-id1="{{$user->id}}"
                                contenteditable>{{$user->name}} {{$user->surname}}</td>
                            <td class="client" data-id2="{{$user->id}}" contenteditable>
                                @for($index=0;$index<sizeof($clients);$index++)
                                    @if(sizeof($clients[$index])>1 && $clients[$index][0]->ucto_id==$user->id)
                                        @for ($index2=0;$index2<sizeof($clients[$index]);$index2++)
                                            {{$clients[$index][$index2]->user_id}}
                                            <button style="margin-bottom: 2px" value="{{$user->id}}" type="button"
                                                    name="delete_btn" data-id1="{{$clients[$index][$index2]->id}}"
                                                    class="btn btn-xs btn-danger btn_delete">x
                                            </button>
                                            <br>
                                        @endfor
                                    @else
                                        @if(isset($clients[$index][0]->ucto_id))
                                            @if($clients[$index][0]->ucto_id==$user->id)
                                                {{$clients[$index][0]->user_id}}
                                                <button style="margin-bottom: 2px" value="{{$user->id}}" type="button"
                                                        name="delete_btn" data-id1="{{$clients[$index][0]->id}}"
                                                        class="btn btn-xs btn-danger btn_delete">x
                                                </button>
                                            @endif
                                        @endif
                                    @endif

                                @endfor
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
        <h2>Pridanie uživatela učtovníkovy</h2>
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
            <form action="addUserToUc" method="post" class="form-actions">
                <div class="autocomplete ">
                    @csrf
                    <input style="float:left;display:inline !important;width: 40% !important;" class="form-control "
                           id="economy" type="text" name="economy" placeholder="Učtovník" required>

                    <input style="display:inline !important;float: left;width: 40% !important;" class="form-control"
                           id="client" type="text" name="client" placeholder="Klient" required>
                    <button style="margin-left: 5px" type="submit"
                            class="btn btn-icon btn-primary glyphicons circle_ok">
                        <i></i><span style="color: transparent">+</span>
                    </button>
                </div>
            </form>
        </div>
        @if(session()->has('toast'))
            @if(Session::get('toast')=='add')
                <script>
                    $.toast({
                        text: 'Uživatel bol priradený !',
                        showHideTransition: 'fade',
                        position: 'top-center',
                        icon: 'success'
                    });
                </script>
            @endif
            @if(Session::get('toast')=='delete')
                <script>
                    $.toast({
                        text: 'Uživatel bol odobraty !',
                        showHideTransition: 'fade',
                        position: 'top-center',
                        icon: 'error'
                    });
                </script>
            @endif
            <?php Session::forget('toast');
            ?>

        @endif


        <script>

            function autocomplete(inp, arr) {
                /*the autocomplete function takes two arguments,
                the text field element and an array of possible autocompleted values:*/
                var currentFocus;
                /*execute a function when someone writes in the text field:*/
                inp.addEventListener("input", function (e) {
                    var a, b, i, val = this.value;
                    /*close any already open lists of autocompleted values*/
                    closeAllLists();
                    if (!val) {
                        return false;
                    }
                    currentFocus = -1;
                    /*create a DIV element that will contain the items (values):*/
                    a = document.createElement("DIV");
                    a.setAttribute("id", this.id + "autocomplete-list");
                    a.setAttribute("class", "autocomplete-items");
                    /*append the DIV element as a child of the autocomplete container:*/
                    this.parentNode.appendChild(a);
                    /*for each item in the array...*/
                    for (i = 0; i < arr.length; i++) {
                        /*check if the item starts with the same letters as the text field value:*/
                        if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
                            /*create a DIV element for each matching element:*/
                            b = document.createElement("DIV");
                            /*make the matching letters bold:*/
                            b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
                            b.innerHTML += arr[i].substr(val.length);
                            /*insert a input field that will hold the current array item's value:*/
                            b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
                            /*execute a function when someone clicks on the item value (DIV element):*/
                            b.addEventListener("click", function (e) {
                                /*insert the value for the autocomplete text field:*/
                                inp.value = this.getElementsByTagName("input")[0].value;
                                /*close the list of autocompleted values,
                                (or any other open lists of autocompleted values:*/
                                closeAllLists();
                            });
                            a.appendChild(b);
                        }
                    }
                });
                /*execute a function presses a key on the keyboard:*/
                inp.addEventListener("keydown", function (e) {
                    var x = document.getElementById(this.id + "autocomplete-list");
                    if (x) x = x.getElementsByTagName("div");
                    if (e.keyCode == 40) {
                        /*If the arrow DOWN key is pressed,
                        increase the currentFocus variable:*/
                        currentFocus++;
                        /*and and make the current item more visible:*/
                        addActive(x);
                    } else if (e.keyCode == 38) { //up
                        /*If the arrow UP key is pressed,
                        decrease the currentFocus variable:*/
                        currentFocus--;
                        /*and and make the current item more visible:*/
                        addActive(x);
                    } else if (e.keyCode == 13) {
                        /*If the ENTER key is pressed, prevent the form from being submitted,*/
                        e.preventDefault();
                        if (currentFocus > -1) {
                            /*and simulate a click on the "active" item:*/
                            if (x) x[currentFocus].click();
                        }
                    }
                });

                function addActive(x) {
                    /*a function to classify an item as "active":*/
                    if (!x) return false;
                    /*start by removing the "active" class on all items:*/
                    removeActive(x);
                    if (currentFocus >= x.length) currentFocus = 0;
                    if (currentFocus < 0) currentFocus = (x.length - 1);
                    /*add class "autocomplete-active":*/
                    x[currentFocus].classList.add("autocomplete-active");
                }

                function removeActive(x) {
                    /*a function to remove the "active" class from all autocomplete items:*/
                    for (var i = 0; i < x.length; i++) {
                        x[i].classList.remove("autocomplete-active");
                    }
                }

                function closeAllLists(elmnt) {
                    /*close all autocomplete lists in the document,
                    except the one passed as an argument:*/
                    var x = document.getElementsByClassName("autocomplete-items");
                    for (var i = 0; i < x.length; i++) {
                        if (elmnt != x[i] && elmnt != inp) {
                            x[i].parentNode.removeChild(x[i]);
                        }
                    }
                }

                /*execute a function when someone clicks in the document:*/
                document.addEventListener("click", function (e) {
                    closeAllLists(e.target);
                });
            }

            /*An array containing all the country names in the world:*/
            var economy = [<?php echo $name?>];
            var client = [<?php echo $nameClients?>];
            /*initiate the autocomplete function on the "myInput" element, and pass along the countries array as possible autocomplete values:*/
            autocomplete(document.getElementById("economy"), economy);
            autocomplete(document.getElementById("client"), client);
        </script>


        <script>
            $(document).ready(function () {
                var token = $("input[name='_token']").attr('value');
                /*delete from table*/
                $(document).on('click', '.btn_delete', function () {
                    var id = $(this).data("id1");
                    var user = $(this).attr("value");
                    if (confirm("Naozaj chcete vymazať data?")) {

                        $.ajax({
                            url: "deleteUctoClient",
                            method: "POST",
                            data: {idClient: id, idUcto: user, '_token': token},
                            dataType: "text",
                            success: function (data) {
                                location.reload();
                            },
                            error: function () {
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