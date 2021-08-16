@extends('../home')
@section('style')
    <style>
        body {
            overflow-y: hidden !important;
        }
    </style>
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
        <div class="col-md-8">
            <div class="table-responsive">
                <table style="width: 100%" id="user_data" class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <td
                            style="color:black;font-weight:bold;background-color:#efefef;width: 20px;border-color:#efefef;">
                            @if(Auth::user()->getRights(Auth::user()->id)==2)  <i class="glyphicon glyphicon-share"></i> @endif
                        </td>
                        <td contenteditable
                            style="color:black;font-weight:bold;background-color:#efefef;border-color:#efefef;">
                            @if(Auth::user()->getRights(Auth::user()->id)==2)
                            Neaktívne pre učtovníka: {{$deactive}}
                          <span style="padding-left:5px;font-weight: normal">  Aktívne pre učtovníka: {{$active}}</span>
                                @endif
                        </td>
                        <td contenteditable style="background-color:#efefef;border-color:#efefef;width: 20px"></td>
                        <td contenteditable style="background-color:#efefef;border-color:#efefef;width: 20px"></td>

                    </tr>
                    </thead>
                    @foreach($document as $documents)
                        <tr>
                            <td style="background-color:white;border-right: none!important;">
                                @if(Auth::user()->getRights(Auth::user()->id)==2)

                                @if($documents->active==1)
                                <a href="{{url('deactive/'.$documents->id)}}" style="border-radius:50px;font-size: 14px;background: deepskyblue;    display: inline-block;width: 12px;height: 12px;">
                                </a>
                                @endif
                                @if($documents->active==0)
                                    <a href="{{url('active/'.$documents->id)}}" style="border-radius:50px;font-size: 14px;background: darkslategrey;    display: inline-block;width: 12px;height: 12px;">
                                    </a>
                                @endif
                                    @endif
                            </td>
                            <td style="border-left: none!important;border-right: none!important;background-color: white">
                                <div style="float: left;padding-right: 5px;font-weight: bold;color: black">{{$documents->name}}</div>
                                @if(Auth::user()->getRights(Auth::user()->id)==3)
                                    <div style="float: left;padding-right: 5px;font-weight: bold;">{{$documents->owner}}</div>
                                @endif
                                <div style="float: left; color:black;padding: 1px 7px 1px 7px;border-radius: 4px; background:#{{$documents->tag_color}}">{{$documents->tag}}</div>
                                <div style="float: right;color: black">{{$documents->date}}</div>

                            </td>
                            <td style="border-left: none!important;border-right: none!important;text-align:center;background-color: white">
                                <a href="paper/{{$documents->id}}" style="font-size: 14px;color: #666666"
                                   class="glyphicon glyphicon-edit"><i></i>
                                </a>
                            </td>
                            <td style=" border-left: none!important;border-right: none!important; text-align:center;background-color: white">
                                <a href="delete/{{$documents->id}}" style="font-size: 14px;color: #666666" class="glyphicon glyphicon-remove"><i></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
        <br/>
    </div>
    @if(session()->has('toast'))
        @if(Session::get('toast')=='add')
            <script>
                $.toast({
                    text: 'Dokument bol vytvorený !',
                    showHideTransition: 'fade',
                    position: 'top-center',
                    icon: 'success'
                });
            </script>
        @endif
        @if(Session::get('toast')=='delete')
            <script>
                $.toast({
                    text: 'Dokument bol vymazaný !',
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

            var token = $('meta[name=csrf-token]').attr('content');

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

    <script src="{{asset('datatables/datatables/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('datatables/datatables-plugins/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{asset('datatables/datatables-responsive/dataTables.responsive.js')}}"></script>

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->

    <script>
        $(document).ready(function() {
            $('#user_data').DataTable( {
                "order": [[ 1, "asc" ]]
            } );
        } );
    </script>
    <div class="container">

    @if(Auth::user()->getRights(Auth::user()->id)==3)

    @endif
    </div>

    <script>
        $('#client').on('change', function () {
            var token = $('meta[name=csrf-token]').attr('content');
            var value = $(this).val();
            $.ajax({
                url: "tagUserShow",
                method: "POST",
                data: {id: value, '_token': token},
                dataType: "text",
                success: function (data) {
                    var arrayTags = [];
                    var help = 0;
                    while (data.indexOf(',') != "" && help == 0) {
                        if (data.length < 25) {
                            help = 1;
                            var value = data.substring(8, data.length - 3);
                            arrayTags.push(value);
                        }
                        else if (help == 0) {
                            var value = data.substring(data.indexOf(':') + 2, data.indexOf(',') - 2);
                            data = data.substring(data.indexOf(',') + 1, data.length);
                            arrayTags.push(value);
                        }

                    }
                    var index = 0;
                    for (index; index < arrayTags.length; index++) {
                        $('#tagShow').append("<option value=" + arrayTags[index] + ">" + arrayTags[index] + "</option>")
                    }

                },
                error: function (data) {
//                    alert(data);
                }
            });
        });

    </script>

@endsection
