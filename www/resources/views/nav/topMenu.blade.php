<!-- Top navbar -->
<div class="navbar main hidden-print">

    <!-- Menu Toggle Button -->
    <button type="button" class="btn btn-navbar pull-left visible-xs">
        <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span>
    </button>


    <!-- Top Menu Left --> 
    <ul class="topnav pull-left">
        <li class="{{ Request::is('/') ? 'active' : '' }}">
            <a href="/" class="glyphicons dashboard">
                <i></i>Dashboard
            </a>
        </li>
        @role('super_admin')
        <li class="dropdown dd-1">
            <a href="" data-toggle="dropdown" class="glyphicons settings">
                <i></i>Administration <span class="caret"></span>
            </a>
            <ul class="dropdown-menu pull-left">                            
                <li class=""><a href="#" class="glyphicons group"><i></i>Users</a></li>
                <li class=""><a href="/role" class="glyphicons nameplate"><i></i>Roles</a></li>                
                
                <!-- Submenu Demo -->
                <li class="dropdown submenu">
                    <a data-toggle="dropdown" class="dropdown-toggle">APIs (Submenu Demo)</a>
                    <ul class="dropdown-menu submenu-show submenu-hide pull-right">
                        <li class=""><a href="twitter.html?lang=en&amp;layout_type=fluid&amp;menu_position=menu-left&amp;style=style-default-menus-dark&amp;sidebar_type=collapsible">Twitter API</a></li>
                        <li class=""><a href="google_analytics.html?lang=en&amp;layout_type=fluid&amp;menu_position=menu-left&amp;style=style-default-menus-dark&amp;sidebar_type=collapsible">Google Analytics API</a></li>
                    </ul>
                </li>
                
                <!-- 4 level menu demo -->    
                <li class="dropdown submenu">
                    <a data-toggle="dropdown" class="dropdown-toggle glyphicons circle_info"><i></i>4 Level Menu</a>
                    <ul class="dropdown-menu submenu-show submenu-hide pull-right">
                        <li class="dropdown submenu">
                            <a data-toggle="dropdown" href="#" class="dropdown-toggle">Menu item sub 1</a>
                            <ul class="dropdown-menu submenu-show submenu-hide pull-right">
                                <li><a href="#">Menu item sub 2</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>

            </ul>
        </li> 
        @endrole
        <li class="dropdown dd-1">
            <a href="" data-toggle="dropdown" class="glyphicons notes">
                <i></i>Documents <span class="caret"></span>
            </a>
            <ul class="dropdown-menu pull-left">
                <li><a href="social.html?lang=en&amp;layout_type=fluid&amp;menu_position=menu-left&amp;style=style-default-menus-dark&amp;sidebar_type=collapsible" class="glyphicons star"><i></i>Social</a></li>
                
                <li><a href="timeline.html?lang=en&amp;layout_type=fluid&amp;menu_position=menu-left&amp;style=style-default-menus-dark&amp;sidebar_type=collapsible" class="glyphicons history"><i></i>Timeline</a></li>
                <li><a href="employees.html?lang=en&amp;layout_type=fluid&amp;menu_position=menu-left&amp;style=style-default-menus-dark&amp;sidebar_type=collapsible" class="glyphicons group"><i></i>Employees</a></li>
                
                                        <li class="dropdown submenu">
                    <a data-toggle="dropdown" class="dropdown-toggle glyphicons user"><i></i>Front</a>
                    <ul class="dropdown-menu submenu-show submenu-hide pull-right">
                        <li><a class="no-ajaxify" href="../front/index_slider.html?lang=en&amp;layout_type=fluid&amp;menu_position=menu-left&amp;style=style-default-menus-dark&amp;sidebar_type=collapsible">Revolution Slider Fixed</a></li>
                        <li><a class="no-ajaxify" href="../front/index_slider_fullwidth.html?lang=en&amp;layout_type=fluid&amp;menu_position=menu-left&amp;style=style-default-menus-dark&amp;sidebar_type=collapsible">Revolution Slider Wide</a></li>
                        <li><a class="no-ajaxify" href="../front/index.html?lang=en&amp;layout_type=fluid&amp;menu_position=menu-left&amp;style=style-default-menus-dark&amp;sidebar_type=collapsible">Home page #1</a></li>
                        <li><a class="no-ajaxify" href="../front/index_2.html?lang=en&amp;layout_type=fluid&amp;menu_position=menu-left&amp;style=style-default-menus-dark&amp;sidebar_type=collapsible">Home page #2</a></li>
                        <li><a class="no-ajaxify" href="../front/about.html?lang=en&amp;layout_type=fluid&amp;menu_position=menu-left&amp;style=style-default-menus-dark&amp;sidebar_type=collapsible">About us</a></li>
                        <li><a class="no-ajaxify" href="../front/pricing.html?lang=en&amp;layout_type=fluid&amp;menu_position=menu-left&amp;style=style-default-menus-dark&amp;sidebar_type=collapsible">Pricing</a></li>
                        <li><a class="no-ajaxify" href="../front/blog.html?lang=en&amp;layout_type=fluid&amp;menu_position=menu-left&amp;style=style-default-menus-dark&amp;sidebar_type=collapsible">Blog</a></li>
                        <li><a class="no-ajaxify" href="../front/blog_timeline.html?lang=en&amp;layout_type=fluid&amp;menu_position=menu-left&amp;style=style-default-menus-dark&amp;sidebar_type=collapsible">Blog Timeline</a></li>
                        <li><a class="no-ajaxify" href="../front/shop.html?lang=en&amp;layout_type=fluid&amp;menu_position=menu-left&amp;style=style-default-menus-dark&amp;sidebar_type=collapsible">Shop Catalog</a></li>
                        <li><a class="no-ajaxify" href="../front/shop_product.html?lang=en&amp;layout_type=fluid&amp;menu_position=menu-left&amp;style=style-default-menus-dark&amp;sidebar_type=collapsible">Shop Product</a></li>
                        <li><a class="no-ajaxify" href="../front/shop_cart.html?lang=en&amp;layout_type=fluid&amp;menu_position=menu-left&amp;style=style-default-menus-dark&amp;sidebar_type=collapsible">Shopping Cart</a></li>
                        <li><a class="no-ajaxify" href="../front/contact.html?lang=en&amp;layout_type=fluid&amp;menu_position=menu-left&amp;style=style-default-menus-dark&amp;sidebar_type=collapsible">Contact</a></li>
                        <li><a class="no-ajaxify" href="../front/login.html?lang=en&amp;layout_type=fluid&amp;menu_position=menu-left&amp;style=style-default-menus-dark&amp;sidebar_type=collapsible">Login</a></li>
                        <li><a class="no-ajaxify" href="../front/signup.html?lang=en&amp;layout_type=fluid&amp;menu_position=menu-left&amp;style=style-default-menus-dark&amp;sidebar_type=collapsible">Sign up</a></li>
                        <li><a class="no-ajaxify" href="../front/error.html?lang=en&amp;layout_type=fluid&amp;menu_position=menu-left&amp;style=style-default-menus-dark&amp;sidebar_type=collapsible">Error page</a></li>
                    </ul>
                </li>
                                        
                <li><a href="invoice.html?lang=en&amp;layout_type=fluid&amp;menu_position=menu-left&amp;style=style-default-menus-dark&amp;sidebar_type=collapsible" class="glyphicons credit_card"><i></i>Invoice</a></li>
                <li><a href="faq.html?lang=en&amp;layout_type=fluid&amp;menu_position=menu-left&amp;style=style-default-menus-dark&amp;sidebar_type=collapsible" class="glyphicons circle_question_mark"><i></i>FAQ</a></li>
                <li><a href="search.html?lang=en&amp;layout_type=fluid&amp;menu_position=menu-left&amp;style=style-default-menus-dark&amp;sidebar_type=collapsible" class="glyphicons search"><i></i>Search</a></li>
                <li><a href="ratings.html?lang=en&amp;layout_type=fluid&amp;menu_position=menu-left&amp;style=style-default-menus-dark&amp;sidebar_type=collapsible" class="glyphicons star"><i></i>Ratings</a></li>
                
                <li class="dropdown submenu">
                    <a data-toggle="dropdown" class="dropdown-toggle glyphicons user"><i></i>Account</a>
                    <ul class="dropdown-menu submenu-show submenu-hide pull-right">
                        <li class=""><a href="my_account_advanced.html?lang=en&amp;layout_type=fluid&amp;menu_position=menu-left&amp;style=style-default-menus-dark&amp;sidebar_type=collapsible">Advanced profile</a></li>
                        <li class=""><a href="my_account.html?lang=en&amp;layout_type=fluid&amp;menu_position=menu-left&amp;style=style-default-menus-dark&amp;sidebar_type=collapsible">My Account</a></li>
                        <li><a href="login.html?lang=en&amp;layout_type=fluid&amp;menu_position=menu-left&amp;style=style-default-menus-dark&amp;sidebar_type=collapsible"><i></i>Login</a></li>
                        <li><a href="signup.html?lang=en&amp;layout_type=fluid&amp;menu_position=menu-left&amp;style=style-default-menus-dark&amp;sidebar_type=collapsible"><i></i>Register</a></li>
                    </ul>
                </li>
                <li class="dropdown submenu">
                    <a data-toggle="dropdown" class="dropdown-toggle glyphicons google_maps"><i></i>Maps</a>
                    <ul class="dropdown-menu submenu-show submenu-hide pull-right">
                        <li class=""><a class="no-ajaxify" href="maps_vector.html?lang=en&amp;layout_type=fluid&amp;menu_position=menu-left&amp;style=style-default-menus-dark&amp;sidebar_type=collapsible">Vector maps</a></li>
                        <li class=""><a class="no-ajaxify" href="maps_google.html?lang=en&amp;layout_type=fluid&amp;menu_position=menu-left&amp;style=style-default-menus-dark&amp;sidebar_type=collapsible">Google maps</a></li>
                    </ul>
                </li>
                <li class="dropdown submenu">
                    <a data-toggle="dropdown" class="dropdown-toggle glyphicons shopping_cart"><i></i>Online Shop</a>
                    <ul class="dropdown-menu submenu-show submenu-hide pull-right">
                        <li class=""><a href="shop_products.html?lang=en&amp;layout_type=fluid&amp;menu_position=menu-left&amp;style=style-default-menus-dark&amp;sidebar_type=collapsible">Products</a></li>
                        <li class=""><a href="shop_edit_product.html?lang=en&amp;layout_type=fluid&amp;menu_position=menu-left&amp;style=style-default-menus-dark&amp;sidebar_type=collapsible">Add product</a></li>
                        <li class=""><a href="shop_orders_timeline.html?lang=en&amp;layout_type=fluid&amp;menu_position=menu-left&amp;style=style-default-menus-dark&amp;sidebar_type=collapsible">Orders Timeline</a></li>
                    </ul>
                </li>
                <li><a href="typography.html?lang=en&amp;layout_type=fluid&amp;menu_position=menu-left&amp;style=style-default-menus-dark&amp;sidebar_type=collapsible" class="glyphicons font"><i></i>Typography</a></li>
                <li><a href="gallery.html?lang=en&amp;layout_type=fluid&amp;menu_position=menu-left&amp;style=style-default-menus-dark&amp;sidebar_type=collapsible" class="glyphicons picture"><i></i>Photo Gallery</a></li>
                <li><a href="calendar.html?lang=en&amp;layout_type=fluid&amp;menu_position=menu-left&amp;style=style-default-menus-dark&amp;sidebar_type=collapsible" class="glyphicons calendar"><i></i>Calendar</a></li>
                <li><a href="bookings.html?lang=en&amp;layout_type=fluid&amp;menu_position=menu-left&amp;style=style-default-menus-dark&amp;sidebar_type=collapsible" class="glyphicons user_add"><i></i>Bookings</a></li>
                <li><a href="finances.html?lang=en&amp;layout_type=fluid&amp;menu_position=menu-left&amp;style=style-default-menus-dark&amp;sidebar_type=collapsible" class="glyphicons coins"><i></i>Finances</a></li>
                <li><a href="error.html?lang=en&amp;layout_type=fluid&amp;menu_position=menu-left&amp;style=style-default-menus-dark&amp;sidebar_type=collapsible" class="glyphicons warning_sign"><i></i>Error page</a></li>
                <li><a href="blank.html?lang=en&amp;layout_type=fluid&amp;menu_position=menu-left&amp;style=style-default-menus-dark&amp;sidebar_type=collapsible" class="glyphicons magic"><i></i>Blank page</a></li>
            </ul>
        </li>               
    </ul>

    

    <!-- Top Menu Right -->
    <ul class="topnav pull-right hidden-sm">

        <!-- Profile / Logout menu -->
        <li class="account dropdown dd-1">
            <a data-toggle="dropdown"
               href="my_account_advanced.html?lang=en&amp;layout_type=fluid&amp;menu_position=menu-left&amp;style=style-default-menus-dark&amp;sidebar_type=collapsible"
               class="glyphicons logout lock">
                <span class="hidden-md hidden-sm hidden-desktop-1">{{Auth::user()->name}}</span>
              <i></i>
            </a>
            <ul class="dropdown-menu pull-right">
                <li class="profile">
                <span>
                    <span class="heading">Profil</span>
                    <a href="my_account_advanced.html?lang=en&amp;layout_type=fluid&amp;menu_position=menu-left&amp;style=style-default-menus-dark&amp;sidebar_type=collapsible"
                       class="img thumb">
                        <img src="{{asset('theme/images/avatar-51x51.jpg')}}" alt="Avatar"/>
                    </a>
                    <span class="clearfix"></span>
                </span>
                </li>
                <li><a href="{{url('option')}}">Nastavenie<i></i></a></li>
                <li><a href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('Odhlásiť sa') }}
                        <i></i></a></li>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
                <li>

                </li>
            </ul>
        </li>
        <!-- // Profile / Logout menu END -->

    </ul>
    <!-- // Top Menu Right END -->

    <div class="clearfix"></div>

</div>
<!-- Top navbar END -->