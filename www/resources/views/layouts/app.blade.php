<!DOCTYPE html>
<!--[if lt IE 7]> <html class="ie lt-ie9 lt-ie8 lt-ie7 fluid top-full menuh-top sticky-top sidebar sidebar-full sidebar-collapsible sidebar-width-mini sticky-sidebar sidebar-hat"> <![endif]-->
<!--[if IE 7]>    <html class="ie lt-ie9 lt-ie8 fluid top-full menuh-top sticky-top sidebar sidebar-full sidebar-collapsible sidebar-width-mini sticky-sidebar sidebar-hat"> <![endif]-->
<!--[if IE 8]>    <html class="ie lt-ie9 fluid top-full menuh-top sticky-top sidebar sidebar-full sidebar-collapsible sidebar-width-mini sticky-sidebar sidebar-hat"> <![endif]-->
<!--[if gt IE 8]> <html class="animations ie gt-ie8 fluid top-full menuh-top sticky-top sidebar sidebar-full sidebar-collapsible sidebar-width-mini sticky-sidebar sidebar-hat"> <![endif]-->
<!--[if !IE]><!--><html class="animations fluid top-full menuh-top sticky-top sidebar sidebar-full sidebar-collapsible sidebar-width-mini sticky-sidebar sidebar-hat"><!-- <![endif]-->
<head>
    <title>{{config('app.name')}}</title>

    <!-- Meta -->
    <meta charset="UTF-8"/>
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap -->
    <link href="{{ asset('bootstrap/css/bootstrap.css')}}" rel="stylesheet" type="text/css"/>

    <!-- Glyphicons Font Icons -->
    <link href="{{ asset('theme/fonts/glyphicons/css/glyphicons_regular.css')}}" rel="stylesheet"/>
    <link href="{{ asset('theme/fonts/glyphicons/css/glyphicons_social.css')}}" rel="stylesheet"/>
    <link href="{{ asset('theme/fonts/glyphicons/css/glyphicons_filetypes.css')}}" rel="stylesheet"/>

    <link rel="stylesheet" href="{{ asset('theme/fonts/font-awesome/css/font-awesome.min.css')}}">
    <!--[if IE 7]><link rel="stylesheet" href="{{ asset('theme/fonts/font-awesome/css/font-awesome-ie7.min.css')}}"><![endif]-->

    <!-- Uniform Pretty Checkboxes -->
    <link href="{{ asset('theme/scripts/plugins/forms/pixelmatrix-uniform/css/uniform.default.css')}}" rel="stylesheet"/>

    <!-- PrettyPhoto -->
    <link href="{{ asset('theme/scripts/plugins/gallery/prettyphoto/css/prettyPhoto.css')}}" rel="stylesheet"/>

    <!-- JQuery -->
    <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
    <script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="{{ asset('theme/scripts/plugins/system/html5shiv.js')}}"></script>
    <![endif]-->

    <!--[if IE]><!--><script src="theme/scripts/plugins/other/excanvas/excanvas.js"></script><!--<![endif]-->
	<!--[if lt IE 8]><script src="theme/scripts/plugins/other/json2.js"></script><![endif]-->
    
    <!-- Toasty --> <!--TODO: do we need toasty?-->
    <link rel="stylesheet" href="{{ asset('js/toasty/jquery.toast.min.css')}}">
    <script type="text/javascript" src="{{ asset('js/toasty/jquery.toast.min.js')}}"></script>
    
    <!-- Bootstrap Extended -->
    <link href="{{ asset('bootstrap/extend/jasny-fileupload/css/fileupload.css')}}" rel="stylesheet">
    <link href="{{ asset('bootstrap/extend/bootstrap-wysihtml5/css/bootstrap-wysihtml5-0.0.2.css')}}" rel="stylesheet">
    <link href="{{ asset('bootstrap/extend/bootstrap-select/bootstrap-select.css')}}" rel="stylesheet"/>
    <link href="{{ asset('bootstrap/extend/bootstrap-switch/static/stylesheets/bootstrap-switch.css')}}" rel="stylesheet"/>
    <link href="{{ asset('bootstrap/extend/bootstrap-spinner/bootstrap-spinner.css')}}" rel="stylesheet"/>

    <!-- DateTimePicker Plugin -->
    <link href="{{ asset('theme/scripts/plugins/forms/bootstrap-datetimepicker/css/datetimepicker.css')}}" rel="stylesheet"/>

    <!-- JQueryUI -->
    <link href="{{ asset('theme/scripts/plugins/system/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.min.css')}}" rel="stylesheet"/>

    <!-- MiniColors ColorPicker Plugin -->
    <link href="{{ asset('theme/scripts/plugins/color/jquery-miniColors/jquery.miniColors.css')}}" rel="stylesheet"/>

    <!-- Notyfy Notifications Plugin -->
    <link href="{{ asset('theme/scripts/plugins/notifications/notyfy/jquery.notyfy.css')}}" rel="stylesheet"/>
    <link href="{{ asset('theme/scripts/plugins/notifications/notyfy/themes/default.css')}}" rel="stylesheet"/>

    <!-- Gritter Notifications Plugin -->
    <link href="{{ asset('theme/scripts/plugins/notifications/Gritter/css/jquery.gritter.css')}}" rel="stylesheet"/>

    <!-- Easy-pie Plugin -->
    <link href="theme/scripts/plugins/charts/easy-pie/jquery.easy-pie-chart.css" rel="stylesheet" />

    <!-- Google Code Prettify Plugin -->
    <link href="{{ asset('theme/scripts/plugins/other/google-code-prettify/prettify.css')}}" rel="stylesheet"/>

    <!-- Select2 Plugin -->
    <link href="{{ asset('theme/scripts/plugins/forms/select2/select2.css')}}" rel="stylesheet"/>

    <!-- Pageguide Guided Tour Plugin -->
    <!--[if gt IE 8]><!-->
    <link media="screen" href="{{ asset('theme/scripts/plugins/other/pageguide/css/pageguide.css')}}" rel="stylesheet"/>
    <!--<![endif]-->

    <!-- FooTable Plugin -->
	<link href="{{ asset('theme/scripts/plugins/tables/FooTable/css/footable-0.1.css')}}" rel="stylesheet" />

    <!-- Bootstrap Image Gallery -->
    <link href="{{ asset('bootstrap/extend/bootstrap-image-gallery/css/bootstrap-image-gallery.min.css')}}"
          rel="stylesheet"/>

    <!-- Main Theme Stylesheet :: CSS -->
    <link href="{{ asset('theme/css/style-default-menus-dark.css?1382019475')}}" rel="stylesheet" type="text/css"/>

    <!-- Custom css -->
    <link href="{{ asset('theme/css/custom.css')}}" rel="stylesheet" type="text/css"/>

    <!-- FireBug Lite -->
    <!-- <script src="https://getfirebug.com/firebug-lite-debug.js"></script> -->

    <!-- LESS.js Library -->
    <script src="{{ asset('theme/scripts/plugins/system/less.min.js')}}"></script>

    <!-- Global -->
    <script>
        //<![CDATA[
        var basePath = '',
            commonPath = '';

        // colors
        var primaryColor = '#e5412d',
            dangerColor =  '#b55151',
            successColor = '#609450',
            warningColor = '#ab7a4b',
            inverseColor = '#45484d';

        var themerPrimaryColor = primaryColor;
        //]]>
    </script>
    @yield('style')

</head>

<body class="document-body">

<!-- Main Container Fluid -->
<div id='app' class="container-fluid menu-hidden sidebar-hidden-phone fluid menu-left">

    <!-- Sidebar menu & content sdfsdfsdfwrapper -->
    <div id="wrapper">

        @include('nav.sideMenu')

        <!-- Content -->
        <div id="content">
            
            @include('nav.topMenu')   
            @include('nav.breadcrumb')         

            @yield('content')

        </div>        
        <!-- // Content END -->
    </div>    
    <div class="clearfix"></div>
    <!-- // Sidebar menu & content wrapper END -->

    @include('footer')
    
</div>
<!-- // Main Container Fluid END -->   

<!-- Themer -->
<div id="themer" class="collapse">
    <div class="wrapper">
        <span class="close2">&times; close</span>
        <h4>Themer <span>color options</span></h4>
        <ul>
            <li>Theme: <select id="themer-theme" class="pull-right"></select>
                <div class="clearfix"></div>
            </li>
            <li>Primary Color: <input type="text" data-type="minicolors" data-default="#ffffff" data-slider="hue"
                                      data-textfield="false" data-position="left" id="themer-primary-cp"/>
                <div class="clearfix"></div>
            </li>
            <li>
                <span class="link" id="themer-custom-reset">reset theme</span>
                <span class="pull-right"><label>advanced <input type="checkbox" value="1" id="themer-advanced-toggle"/></label></span>
            </li>
        </ul>
        <div id="themer-getcode" class="hide">
            <hr class="separator"/>
            <button class="btn btn-primary btn-small pull-right btn-icon glyphicons download" id="themer-getcode-less">
                <i></i>Get LESS
            </button>
            <button class="btn btn-inverse btn-small pull-right btn-icon glyphicons download" id="themer-getcode-css">
                <i></i>Get CSS
            </button>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<!-- // Themer END -->

<!-- Modal Gallery -->
<div id="modal-gallery" class="modal modal-gallery hide fade hidden-print" tabindex="-1">
    <div class="modal-header">
        <a class="close" data-dismiss="modal">&times;</a>
        <h3 class="modal-title"></h3>
    </div>
    <div class="modal-body">
        <div class="modal-image"></div>
    </div>
    <div class="modal-footer">
        <a class="btn btn-primary modal-next">Next <i class="icon-arrow-right icon-white"></i></a>
        <a class="btn btn-info modal-prev"><i class="icon-arrow-left icon-white"></i> Previous</a>
        <a class="btn btn-success modal-play modal-slideshow" data-slideshow="5000">
            <i class="icon-play icon-white"></i> Slideshow
        </a>
        <a class="btn modal-download" target="_blank"><i class="icon-download"></i> Download</a>
    </div>
</div>



<!-- // Modal Gallery END -->


<!-- jQuery Event Move -->
<script src="{{ asset('theme/scripts/plugins/system/jquery.event.move/js/jquery.event.move.js')}}"></script>

<!-- jQuery Event Swipe -->
<script src="{{ asset('theme/scripts/plugins/system/jquery.event.swipe/js/jquery.event.swipe.js')}}"></script>


<!-- Code Beautify -->
<script src="{{ asset('theme/scripts/plugins/other/js-beautify/beautify.js')}}"></script>
<script src="{{ asset('theme/scripts/plugins/other/js-beautify/beautify-html.js')}}"></script>

<!-- PrettyPhoto -->
<script src="{{ asset('theme/scripts/plugins/gallery/prettyphoto/js/jquery.prettyPhoto.js')}}"></script>

<!-- JQueryUI -->
<script src="{{ asset('theme/scripts/plugins/system/jquery-ui/js/jquery-ui-1.9.2.custom.min.js')}}"></script>

<!-- JQueryUI Touch Punch -->
<!-- small hack that enables the use of touch events on sites using the jQuery UI user interface library -->
<script src="{{ asset('theme/scripts/plugins/system/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js')}}"></script>


<!-- Modernizr -->
<script src="{{ asset('theme/scripts/plugins/system/modernizr.js')}}"></script>

<!-- Bootstrap -->
<script src="{{ asset('bootstrap/js/bootstrap.min.js')}}"></script>

<!-- SlimScroll Plugin -->
<script src="{{ asset('theme/scripts/plugins/other/jquery-slimScroll/old/jquery.slimscroll.js')}}"></script>

<!-- Holder Plugin -->
<script src="{{ asset('theme/scripts/plugins/other/holder/holder.js?1382019475')}}"></script>

<!-- Uniform Forms Plugin -->
<script src="{{ asset('theme/scripts/plugins/forms/pixelmatrix-uniform/jquery.uniform.min.js')}}"></script>

<!-- MegaMenu -->
<script src="{{ asset('theme/scripts/demo/megamenu.js?1382019475')}}"></script>


<!-- Bootstrap Extended -->
<script src="{{ asset('bootstrap/extend/bootstrap-select/bootstrap-select.js')}}"></script>
<script src="{{ asset('bootstrap/extend/bootstrap-switch/static/js/bootstrap-switch.js')}}"></script>
<script src="{{ asset('bootstrap/extend/jasny-fileupload/js/bootstrap-fileupload.js')}}"></script>
<script src="{{ asset('bootstrap/extend/bootbox.js')}}"></script>
<script src="{{ asset('bootstrap/extend/bootstrap-wysihtml5/js/wysihtml5-0.3.0_rc2.min.js')}}"></script>
<script src="{{ asset('bootstrap/extend/bootstrap-wysihtml5/js/bootstrap-wysihtml5-0.0.2.js')}}"></script>

<!-- Google Code Prettify -->
<script src="{{ asset('theme/scripts/plugins/other/google-code-prettify/prettify.js')}}"></script>

<!-- Gritter Notifications Plugin -->
<script src="{{ asset('theme/scripts/plugins/notifications/Gritter/js/jquery.gritter.min.js')}}"></script>

<!-- Notyfy Notifications Plugin -->
<script src="{{ asset('theme/scripts/plugins/notifications/notyfy/jquery.notyfy.js')}}"></script>

<!-- MiniColors Plugin -->
<script src="{{ asset('theme/scripts/plugins/color/jquery-miniColors/jquery.miniColors.js')}}"></script>

<!-- DateTimePicker Plugin -->
<script src="{{ asset('theme/scripts/plugins/forms/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>

<!-- Cookie Plugin -->
<script src="{{ asset('theme/scripts/plugins/system/jquery.cookie.js')}}"></script>

<!-- Select2 Plugin -->
<script src="{{ asset('theme/scripts/plugins/forms/select2/select2.js')}}"></script>

<!-- Themer -->
{{--<script src="{{ asset('theme/scripts/demo/themer.js')}}"></script>--}}

<!-- Twitter Feed -->
{{-- <script src="{{ asset('theme/scripts/demo/twitter.js')}}"></script> --}}

<!-- Ba-Resize Plugin -->
<script src="{{ asset('theme/scripts/plugins/other/jquery.ba-resize.js')}}"></script>

<!-- Responsive table --> 
<script src="{{ asset('theme/scripts/plugins/tables/FooTable/js/footable.js')}}"></script>
<script src="{{ asset('theme/scripts/demo/tables_responsive.js')}}"></script>

<!-- Common Function Script -->
{{-- <script type="text/javascript" src="{{ asset('js/common.js') }}"></script> --}}

<!-- Bootstrap Image Gallery -->
<script src="{{ asset('theme/scripts/plugins/gallery/load-image/js/load-image.min.js')}}"></script>
<script src="{{ asset('bootstrap/extend/bootstrap-image-gallery/js/bootstrap-image-gallery.min.js')}}"
        type="text/javascript"></script>

{{-- 
<!-- Dashboard Demo Script -->
<script src="{{ asset('theme/scripts/demo/index.js?1382019475')}}"></script>
--}}


<!-- Common Demo Script -->
<script src="{{ asset('theme/scripts/demo/common.js?1382019475')}}"></script> 


<!-- VUE -->
<script type="text/javascript" src="{{ asset('js/app.js') }}" defer></script>

<script type="text/javascript">  
    @if (Session::get('status'))        
        @foreach(Session::get('status') as $key => $msg)
            notyfy({
                force: true,
                text: '{{$msg}}',
                type: '{{$key}}', //success | information | warning | error | alert
                dismissQueue: true,
                layout: 'top'
            });
        @endforeach    
    @endif
</script>

</body>
</html>