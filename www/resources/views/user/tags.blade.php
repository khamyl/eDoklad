@extends('../home')
@section('style')
    <style>
        input {
            border: 1px solid;
            border-color: #CCCCCC !important;
            width: 100%;
            color: black !important;
            padding-left: 2px;
            border-radius: 3px !important;

        }

        .colorLabel {

            background-color: #fafafa !important;
            font-weight: bold
        }

        .colorLabelTwo {
            background-color: #ffffff !important;
        }
    </style>
@endsection
@section('content')
    <div class="container">
        <div class="col-md-8">
            <script src="js/jscolor.js"></script>
            <form method="post" action="{{url('createTag')}}">
                @csrf
                <table class="footable table table-striped table-bordered table-white table-primary">
                    <tbody>
                    <tr>
                        <td class="colorLabel" colspan="3">
                            <span style="text-align: left !important;">Pridať Tag</span>
                            <button style="float:right;padding:5px;border-radius: 4px" type="submit"
                                    class="btn btn-xs btn-primary">Pridať
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <th class="colorLabel" style="width: 60%">Názov</th>
                        <th class="colorLabel" style="text-align: center">Popis</th>
                        <th class="colorLabel" style="text-align: center">Farba</th>

                    </tr>


                    <tr>
                        <td class="colorLabelTwo" style="width: 60%"><input name="tag" required type="text"></td>
                        <td class="colorLabelTwo"><input name="description" style="text-align: center" required
                                                         type="text">
                        </td>
                        <td class="colorLabelTwo"><input required name="color" class="jscolor" value="000000">
                        </td>

                    </tr>

                    </tbody>
                </table>
            </form>

            <table class="footable table table-striped table-bordered table-white table-primary">
                <tbody>
                <thead>
                <tr>
                    @if($countTags>1)
                        <td class="colorLabel" colspan="3">{{$countTags}} Tagy</td>
                    @endif
                    @if($countTags<2)
                        <td class="colorLabel" colspan="3">{{$countTags}} Tag</td>
                    @endif
                </tr>
                </thead>

                @foreach($tags as $tag)
                    <tr>
                        <td class="colorLabelTwo">
                            <div style="color:black;float:left;text-align:center;background-color: #{{$tag->color}};padding: 5px; border-radius: 5px">{{$tag->tag}}</div>
                            <div style="float:left;padding-top: 5px;padding-left: 5%"> {{$tag->description}}</div>

                            <div style="float: right; padding-left: 5px;padding-top: 5px;">
                                <a href="deleteTag/{{$tag->id}}" style="font-size: 14px;color: #666666"
                                   class="glyphicon glyphicon-remove"><i></i>
                                </a>
                            </div>
                            <div style="float: right;padding-top: 5px;">
                                <a href="deleteTag/{{$tag->id}}" style="font-size: 14px;color: #666666"
                                   class="glyphicon glyphicon-edit"><i></i>
                                </a>
                            </div>
                            <div>
                                @foreach($document as $doc)
                                    @if($doc['name']==$tag->tag)
                                        <div style="float: right;padding-top: 5px;padding-right: 20%;">
                                            @if($doc['count']<2)
                                            {{$doc['count']}} Dokument
                                            @else {{$doc['count']}} Dokumentov
                                            @endif
                                       </div>
                                    @endif
                                @endforeach
                            </div>

                        </td>

                    </tr>
                    @endforeach

                    </tbody>
            </table>


        </div>
        @if(session()->has('toast'))
            @if(Session::get('toast')=='add')
                <script>
                    $.toast({
                        text: 'Tag bol vytvorený !',
                        showHideTransition: 'fade',
                        position: 'top-center',
                        icon: 'success'
                    });
                </script>
            @endif
            @if(Session::get('toast')=='delete')
                <script>
                    $.toast({
                        text: 'Tag bol vymazaný !',
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

        {{--<script>--}}
        {{--$(document).ready(function () {--}}

        {{--/*insert into table*/--}}
        {{--var token = $("input[name='_token']").attr('value');--}}
        {{--$(document).on('click', '#btn_add', function () {--}}
        {{--var tag = $('#tag').text();--}}
        {{--var color = $('.jscolor').attr('value');--}}

        {{--if (tag == '') {--}}
        {{--alert("Vložte názov tagu");--}}
        {{--return false;--}}
        {{--}--}}
        {{--else if (color == '') {--}}
        {{--alert("Vložte farbu tagu");--}}
        {{--return false;--}}
        {{--}--}}

        {{--$.ajax({--}}
        {{--url: "createTag",--}}
        {{--method: "POST",--}}
        {{--data: {tag: tag, color: color, '_token': token},--}}
        {{--dataType: "text",--}}
        {{--success: function (data) {--}}
        {{--location.reload();--}}
        {{--},--}}
        {{--error: function () {--}}
        {{--location.reload();--}}
        {{--}--}}

        {{--})--}}
        {{--});--}}

        {{--/*edit table*/--}}
        {{--function edit_data(id, text, column_name) {--}}
        {{--$.ajax({--}}
        {{--url: "editTag",--}}
        {{--method: "POST",--}}
        {{--data: {id: id, text: text, colum: column_name,'_token': token},--}}
        {{--dataType: "text",--}}
        {{--success: function (data) {--}}
        {{--location.reload();--}}
        {{--},--}}
        {{--error: function () {--}}
        {{--alert("Chyba");--}}
        {{--}--}}
        {{--});--}}
        {{--}--}}


        {{--$(document).on('blur', '.tag', function () {--}}
        {{--var id = $(this).data("id1");--}}
        {{--var text_change = $(this).text();--}}
        {{--edit_data(id, text_change, "tag");--}}
        {{--});--}}
        {{--$(document).on('blur', '.jscolor', function () {--}}
        {{--var id = $(this).data("id2");--}}
        {{--var text_change = $(this).attr('value');--}}
        {{--edit_data(id, text_change, "color");--}}
        {{--});--}}


        {{--/*delete from table*/--}}
        {{--$(document).on('click', '.btn_delete', function () {--}}
        {{--var id = $(this).data("id4");--}}

        {{--if (confirm("Naozaj chcete vymazať data?")) {--}}

        {{--$.ajax({--}}
        {{--url: "deleteTag",--}}
        {{--method: "POST",--}}
        {{--data: {id: id, '_token': token},--}}
        {{--dataType: "text",--}}
        {{--success: function (data) {--}}
        {{--location.reload();--}}
        {{--},--}}
        {{--error: function () {--}}
        {{--location.reload();--}}
        {{--}--}}
        {{--});--}}
        {{--}--}}

        {{--});--}}
        {{--});--}}


        {{--</script>--}}
    </div>

    <script src="datatables/datatables/js/jquery.dataTables.min.js"></script>
    <script src="datatables/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="datatables/datatables-responsive/dataTables.responsive.js"></script>

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->

    <script>
        $(document).ready(function () {
            $('#user_color').DataTable();
        });
    </script>



    </div>
@endsection