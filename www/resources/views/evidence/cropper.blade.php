@extends('../home')
@section('style')
    <style>
        .pure-material-progress-circular {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            box-sizing: border-box;
            border: none;
            border-radius: 50%;
            padding: 0.25em;
            width: 3em;
            height: 3em;
            color:#e5412d;
            background-color: transparent;
            font-size: 150px;
            overflow: hidden;
            z-index: 99999999;position: absolute; top:15%;left: 40%;
            display: none;
        }

        .pure-material-progress-circular::-webkit-progress-bar {
            background-color: transparent;
        }

        /* Indeterminate */
        .pure-material-progress-circular:indeterminate {
            -webkit-mask-image: linear-gradient(transparent 50%, black 50%), linear-gradient(to right, transparent 50%, black 50%);
            mask-image: linear-gradient(transparent 50%, black 50%), linear-gradient(to right, transparent 50%, black 50%);
            animation: pure-material-progress-circular 6s infinite cubic-bezier(0.3, 0.6, 1, 1);
        }

        :-ms-lang(x), .pure-material-progress-circular:indeterminate {
            animation: none;
        }

        .pure-material-progress-circular:indeterminate::before,
        .pure-material-progress-circular:indeterminate::-webkit-progress-value {
            content: "";
            display: block;
            box-sizing: border-box;
            margin-bottom: 0.25em;
            border: solid 0.25em transparent;
            border-top-color: currentColor;
            border-radius: 50%;
            width: 100% !important;
            height: 100%;
            background-color: transparent;
            animation: pure-material-progress-circular-pseudo 0.75s infinite linear alternate;
        }

        .pure-material-progress-circular:indeterminate::-moz-progress-bar {
            box-sizing: border-box;
            border: solid 0.25em transparent;
            border-top-color: currentColor;
            border-radius: 50%;
            width: 100%;
            height: 100%;
            background-color: transparent;
            animation: pure-material-progress-circular-pseudo 0.75s infinite linear alternate;
        }

        .pure-material-progress-circular:indeterminate::-ms-fill {
            animation-name: -ms-ring;
        }

        @keyframes pure-material-progress-circular {
            0% {
                transform: rotate(0deg);
            }
            12.5% {
                transform: rotate(180deg);
                animation-timing-function: linear;
            }
            25% {
                transform: rotate(630deg);
            }
            37.5% {
                transform: rotate(810deg);
                animation-timing-function: linear;
            }
            50% {
                transform: rotate(1260deg);
            }
            62.5% {
                transform: rotate(1440deg);
                animation-timing-function: linear;
            }
            75% {
                transform: rotate(1890deg);
            }
            87.5% {
                transform: rotate(2070deg);
                animation-timing-function: linear;
            }
            100% {
                transform: rotate(2520deg);
            }
        }

        @keyframes pure-material-progress-circular-pseudo {
            0% {
                transform: rotate(-30deg);
            }
            29.4% {
                border-left-color: transparent;
            }
            29.41% {
                border-left-color: currentColor;
            }
            64.7% {
                border-bottom-color: transparent;
            }
            64.71% {
                border-bottom-color: currentColor;
            }
            100% {
                border-left-color: currentColor;
                border-bottom-color: currentColor;
                transform: rotate(225deg);
            }
        }
    </style>
    @endsection
@section('content')


    <title>Cropper</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="{{ asset('css/cropper.css')}}" rel="stylesheet" type="text/css"/>

<![endif]-->

<!-- Content -->
<div class="container">
    <div class="row">
        <div class="col-md-9">
            <!-- <h3>Demo:</h3> -->
            <div class="img-container">
                <img src="{{asset('/image/upload.png')}}" id="image" alt="Picture">
            </div>
        </div>
        <div class="col-md-3">
            <!-- <h3>Preview:</h3> -->
            <div class="docs-preview clearfix">
                <div class="img-preview preview-lg"></div>
                <div class="img-preview preview-md"></div>
                <div class="img-preview preview-sm"></div>
                <div class="img-preview preview-xs"></div>
            </div>

        </div>
    </div>
    <div class="row">
        <div style="margin-top: 5px;" class="col-md-9 docs-buttons">
            <!-- <h3>Toolbar:</h3> -->
            <div class="btn-group">
                <button type="button" class="btn btn-primary" data-method="setDragMode" data-option="move" title="Move">
            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false">
              <span class="fa fa-arrows"></span>
            </span>
                </button>
                <button type="button" class="btn btn-primary" data-method="setDragMode" data-option="crop" title="Crop">
            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false">
              <span class="fa fa-crop"></span>
            </span>
                </button>
            </div>

            <div class="btn-group">
                <button type="button" class="btn btn-primary" data-method="zoom" data-option="0.1" title="Zoom In">
            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" >
              <span class="fa fa-search-plus"></span>
            </span>
                </button>
                <button type="button" class="btn btn-primary" data-method="zoom" data-option="-0.1" title="Zoom Out">
            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false">
              <span class="fa fa-search-minus"></span>
            </span>
                </button>
            </div>

            <div class="btn-group">
                <button type="button" class="btn btn-primary" data-method="move" data-option="-10" data-second-option="0" title="Move Left">
            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" >
              <span class="fa fa-arrow-left"></span>
            </span>
                </button>
                <button type="button" class="btn btn-primary" data-method="move" data-option="10" data-second-option="0" title="Move Right">
            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" >
              <span class="fa fa-arrow-right"></span>
            </span>
                </button>
                <button type="button" class="btn btn-primary" data-method="move" data-option="0" data-second-option="-10" title="Move Up">
            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false">
              <span class="fa fa-arrow-up"></span>
            </span>
                </button>
                <button type="button" class="btn btn-primary" data-method="move" data-option="0" data-second-option="10" title="Move Down">
            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false">
              <span class="fa fa-arrow-down"></span>
            </span>
                </button>
            </div>

            <div class="btn-group">
                <button type="button" class="btn btn-primary" data-method="rotate" data-option="-45" title="Rotate Left">
            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false">
              <span class="fa fa-rotate-left"></span>
            </span>
                </button>
                <button type="button" class="btn btn-primary" data-method="rotate" data-option="45" title="Rotate Right">
            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" >
              <span class="fa fa-rotate-right"></span>
            </span>
                </button>
            </div>

            <div class="btn-group">
                <button type="button" class="btn btn-primary" data-method="scaleX" data-option="-1" title="Flip Horizontal">
            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false">
              <span class="fa fa-arrows-h"></span>
            </span>
                </button>
                <button type="button" class="btn btn-primary" data-method="scaleY" data-option="-1" title="Flip Vertical">
            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false">
              <span class="fa fa-arrows-v"></span>
            </span>
                </button>
            </div>

            <div class="btn-group">
                <button type="button" class="btn btn-primary" data-method="crop" title="Crop">
            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false">
              <span class="fa fa-check"></span>
            </span>
                </button>
                <button type="button" class="btn btn-primary" data-method="clear" title="Clear">
            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false">
              <span class="fa fa-remove"></span>
            </span>
                </button>
            </div>

            <div class="btn-group">
                <button type="button" class="btn btn-primary" data-method="reset" title="Reset">
            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false">
              <span class="fa fa-refresh"></span>
            </span>
                </button>
                <label class="btn btn-primary btn-upload" for="inputImage" title="Upload image file">
                    <input type="file" class="sr-only" id="inputImage" name="file" accept=".jpg,.jpeg,.png,.gif,.bmp,.tiff">
                    <span class="docs-tooltip" data-toggle="tooltip" data-animation="false">
              <span class="fa fa-upload"></span>
            </span>
                </label>
                <button type="button" class="btn btn-primary" data-method="destroy" title="Destroy">
            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false">
              <span class="fa fa-power-off"></span>
            </span>
                </button>
            </div>

            <div class="btn-group btn-group-crop">
                <button type="button" class="btn btn-success" data-method="getCroppedCanvas" data-option="{ &quot;maxWidth&quot;: 4096, &quot;maxHeight&quot;: 4096 }">
            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false">
              Orezať
            </span>
                </button>
            </div>

            <!-- Show the cropped image in modal -->
            <div class="modal fade docs-cropped" id="getCroppedCanvasModal" aria-hidden="true" aria-labelledby="getCroppedCanvasTitle" role="dialog" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="getCroppedCanvasTitle">Cropped</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Zatvoriť</button>
                            <a class="btn btn-primary" id="download" href="javascript:void(0);" download="cropped.jpg">Vytvoriť</a>
                        </div>
                    </div>
                </div>
                <progress class="pure-material-progress-circular"/>
            </div><!-- /.modal -->
        </div><!-- /.docs-buttons -->

        <div class="col-md-3 docs-toggles">
            <!-- <h3>Toggles:</h3> -->
            <div style="margin-top:5px; " class="btn-group d-flex flex-nowrap" data-toggle="buttons">
                <label class="btn btn-primary">
                    <input type="radio" class="sr-only" id="aspectRatio0" name="aspectRatio" value="1.7777777777777777">
                    <span class="docs-tooltip" data-toggle="tooltip" data-animation="false">
              16:9
            </span>
                </label>
                <label class="btn btn-primary">
                    <input type="radio" class="sr-only" id="aspectRatio1" name="aspectRatio" value="1.3333333333333333">
                    <span class="docs-tooltip" data-toggle="tooltip" data-animation="false">
              4:3
            </span>
                </label>
                <label class="btn btn-primary">
                    <input type="radio" class="sr-only" id="aspectRatio2" name="aspectRatio" value="1">
                    <span class="docs-tooltip" data-toggle="tooltip" data-animation="false">
              1:1
            </span>
                </label>
                <label class="btn btn-primary">
                    <input type="radio" class="sr-only" id="aspectRatio3" name="aspectRatio" value="0.6666666666666666">
                    <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" >
              2:3
            </span>
                </label>
                <label class="btn btn-primary">
                    <input type="radio" class="sr-only" id="aspectRatio4" name="aspectRatio" value="NaN">
                    <span class="docs-tooltip" data-toggle="tooltip" data-animation="false">
              Volné strany
            </span>
                </label>
            </div>


            <div class="dropdown dropup docs-options">
                <ul class="dropdown-menu" aria-labelledby="toggleOptions" role="menu">
                    <li class="dropdown-item">
                        <div class="form-check">
                            <input class="form-check-input" id="responsive" type="checkbox" name="responsive" checked>
                            <label class="form-check-label" for="responsive">responsive</label>
                        </div>
                    </li>
                    <li class="dropdown-item">
                        <div class="form-check">
                            <input class="form-check-input" id="restore" type="checkbox" name="restore" checked>
                            <label class="form-check-label" for="restore">restore</label>
                        </div>
                    </li>
                    <li class="dropdown-item">
                        <div class="form-check">
                            <input class="form-check-input" id="checkCrossOrigin" type="checkbox" name="checkCrossOrigin" checked>
                            <label class="form-check-label" for="checkCrossOrigin">checkCrossOrigin</label>
                        </div>
                    </li>
                    <li class="dropdown-item">
                        <div class="form-check">
                            <input class="form-check-input" id="checkOrientation" type="checkbox" name="checkOrientation" checked>
                            <label class="form-check-label" for="checkOrientation">checkOrientation</label>
                        </div>
                    </li>
                    <li class="dropdown-item">
                        <div class="form-check">

                            <svg class="progress-circle indefinite" width="100" height="100">
                                <g transform="rotate(-90,50,50)">
                                    <circle class="bg" r="40" cx="50" cy="50" fill="none"></circle>
                                    <circle class="progress" r="40" cx="50" cy="50" fill="none"></circle>
                                </g>
                            </svg>

                            <input class="form-check-input" id="modal" type="checkbox" name="modal" checked>
                            <label class="form-check-label" for="modal">modal</label>
                        </div>
                    </li>
                    <li class="dropdown-item">
                        <div class="form-check">
                            <input class="form-check-input" id="guides" type="checkbox" name="guides" checked>
                            <label class="form-check-label" for="guides">guides</label>
                        </div>
                    </li>
                    <li class="dropdown-item">
                        <div class="form-check">
                            <input class="form-check-input" id="center" type="checkbox" name="center" checked>
                            <label class="form-check-label" for="center">center</label>
                        </div>
                    </li>
                    <li class="dropdown-item">
                        <div class="form-check">
                            <input class="form-check-input" id="highlight" type="checkbox" name="highlight" checked>
                            <label class="form-check-label" for="highlight">highlight</label>
                        </div>
                    </li>
                    <li class="dropdown-item">
                        <div class="form-check">
                            <input class="form-check-input" id="background" type="checkbox" name="background" checked>
                            <label class="form-check-label" for="background">background</label>
                        </div>
                    </li>
                    <li class="dropdown-item">
                        <div class="form-check">
                            <input class="form-check-input" id="autoCrop" type="checkbox" name="autoCrop" checked>
                            <label class="form-check-label" for="autoCrop">autoCrop</label>
                        </div>
                    </li>
                    <li class="dropdown-item">
                        <div class="form-check">
                            <input class="form-check-input" id="movable" type="checkbox" name="movable" checked>
                            <label class="form-check-label" for="movable">movable</label>
                        </div>
                    </li>
                    <li class="dropdown-item">
                        <div class="form-check">
                            <input class="form-check-input" id="rotatable" type="checkbox" name="rotatable" checked>
                            <label class="form-check-label" for="rotatable">rotatable</label>
                        </div>
                    </li>
                    <li class="dropdown-item">
                        <div class="form-check">
                            <input class="form-check-input" id="scalable" type="checkbox" name="scalable" checked>
                            <label class="form-check-label" for="scalable">scalable</label>
                        </div>
                    </li>
                    <li class="dropdown-item">
                        <div class="form-check">
                            <input class="form-check-input" id="zoomable" type="checkbox" name="zoomable" checked>
                            <label class="form-check-label" for="zoomable">zoomable</label>
                        </div>
                    </li>
                    <li class="dropdown-item">
                        <div class="form-check">
                            <input class="form-check-input" id="zoomOnTouch" type="checkbox" name="zoomOnTouch" checked>
                            <label class="form-check-label" for="zoomOnTouch">zoomOnTouch</label>
                        </div>
                    </li>
                    <li class="dropdown-item">
                        <div class="form-check">
                            <input class="form-check-input" id="zoomOnWheel" type="checkbox" name="zoomOnWheel" checked>
                            <label class="form-check-label" for="zoomOnWheel">zoomOnWheel</label>
                        </div>
                    </li>
                    <li class="dropdown-item">
                        <div class="form-check">
                            <input class="form-check-input" id="cropBoxMovable" type="checkbox" name="cropBoxMovable" checked>
                            <label class="form-check-label" for="cropBoxMovable">cropBoxMovable</label>
                        </div>
                    </li>
                    <li class="dropdown-item">
                        <div class="form-check">
                            <input class="form-check-input" id="cropBoxResizable" type="checkbox" name="cropBoxResizable" checked>
                            <label class="form-check-label" for="cropBoxResizable">cropBoxResizable</label>
                        </div>
                    </li>
                    <li class="dropdown-item">
                        <div class="form-check">
                            <input class="form-check-input" id="toggleDragModeOnDblclick" type="checkbox" name="toggleDragModeOnDblclick" checked>
                            <label class="form-check-label" for="toggleDragModeOnDblclick">toggleDragModeOnDblclick</label>
                        </div>
                    </li>
                </ul>
            </div><!-- /.dropdown -->

        </div><!-- /.docs-toggles -->
    </div>
</div>

<!-- Footer -->


<!-- Scripts -->
    {{--cropper--}}


<script>
    var token=$('meta[name=csrf-token]').attr('content');
    var arraySrc=[];
    $("#download").click(function () {

        $(".pure-material-progress-circular").css('display','block');
        $.each($("img"), function() {
            console.log($(this).attr("src")!="");
            if($(this).attr("src")!=""){
            arraySrc.push($(this).attr("src"));
            }
        });
        $.ajax({
            url: "{{url('safeImg')}}",
            method: "POST",
            data: {img: arraySrc[9],'_token': token},
            dataType: "text",
            success: function (data) {
                window.location.replace('{{url("startOcr")}}');
                },
            error: function (data) {
                alert('');
            }
        });
    });
</script>
    <script src="{{ asset('js/cropper.js')}}"></script>
    <script src="{{ asset('js/main.js')}}"></script>
@endsection
