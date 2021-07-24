<!-- Top navbar -->
<div class="navbar main hidden-print">

    <!-- Menu Toggle Button -->
    <button type="button" class="btn btn-navbar pull-left visible-xs">
        <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span>
    </button>

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