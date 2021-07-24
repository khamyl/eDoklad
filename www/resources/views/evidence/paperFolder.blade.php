@extends('../home')
@section('style')
    <style>
        #footer{position: absolute;bottom: 0px;left: 0px;width: 100%}
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

        <div class="col col-md-8" style="margin-bottom: 5px;">
            <div style="margin-bottom: 5px">
                <form method="post" action="searchFolder">
                    @csrf
                    <?php $years = range(strftime("%Y", time()), 1980); ?>
                    <select class="form-control"
                            style="margin-top:5px;min-width: 150px;max-width: 250px;display: initial!important;"
                            name="year">
                        <option>Vyber Rok:</option>
                        <?php foreach($years as $year) : ?>
                        <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <button style="padding:10px;margin-top: 4px;margin-left: 5px;border-radius: 4px"
                            type="submit"
                            class="btn btn-xs btn-success btn_delete glyphicon glyphicon-search"><i class="fa fa-pencil"></i>
                    </button>
                </form>
            </div>
        </div>

        <div class="col-md-8">
            <div class="table-responsive">
                <table style="width: 100%" id="user_data" class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <td style="background-color:#efefef;border-color:#efefef;">Dokumenty podľa roka a mesiaca</td>

                    </tr>
                    </thead>
                    @foreach($document as $doc)
                        <tr>
                            <td style="background-color:white;border-right: none!important;">
                                <a style="font-size: 20px;margin-left: 10px;" class="glyphicon glyphicon-folder-close"
                                   href={{url('showPaperDate/'.$doc['mounth'])}}>
                                    <i class="fas fa-folder"></i><span>{{$doc['mounth']}}</span>
                                </a>
                                <div style="color: black;float: right;padding-top: 5px;">
                                    Počet dokuemtov: {{$doc['count']}}
                                </div></td>

                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>

    <script src="datatables/datatables/js/jquery.dataTables.min.js"></script>
    <script src="datatables/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="datatables/datatables-responsive/dataTables.responsive.js"></script>

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->

    <script>
        $(document).ready(function () {
            $('#user_data').DataTable({
                "order": [[ 0, "desc" ]]
            });
        });
    </script>

@endsection