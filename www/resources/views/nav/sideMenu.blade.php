        <!-- Sidebar Menu -->
        <div id="menu" class="hidden-print">

            <!-- Brand -->
            <a href="index.html?lang=en&amp;layout_type=fluid&amp;menu_position=menu-left&amp;style=style-default-menus-dark&amp;sidebar_type=collapsible"
               class="appbrand"><span class="text-primary">e</span> <span>Doklad</span></a>

            <!-- Scrollable menu wrapper with Maximum height -->
            <div class="slim-scroll" data-scroll-height="800px">

                <!-- Menu Toggle Button -->
                <button type="button" class="btn btn-navbar">
                    <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span>
                </button>
                <!-- // Menu Toggle Button END -->

                <!-- Sidebar Profile -->
                <span class="profile center">
					<a href="/option">
                        <img src="{{asset('theme/images/avatar-51x51.jpg')}}" alt="Avatar"/>
                    </a>
				</span>
                <!-- // Sidebar Profile END -->

                <!-- Menu -->
                <ul>
                    <li class="active">
                        <a href="{{url('home')}}" class="glyphicons dashboard">
                            <i></i>
                            <span>Dashboard</span>
                        </a>
                   </li>
                    @role('super_admin')
                    <li class="hasSubmenu">

                        <a href="#userAdmin" data-toggle="collapse" class="glyphicons settings">     
                            <i></i>                       
                            <span>Admin</span>
                            <span class="icon-chevron-down"></span>
                        </a>
                        <ul class="collapse" id="userAdmin">
                            <li class=""><a class="glyphicons user" href="{{url('userAdmin')}}">Používatelia</a></li>
                            <li class=""><a class="glyphicons user" href="{{url('userAddUc')}}">Učtovnici</a></li>
                            <!-- // Components Submenu Regular Items END -->
                        </ul>
                    </li>
                    @endrole

                    @role('main_accountant')
                        <li class="hasSubmenu">
                            <a href="#userAdmin" data-toggle="collapse" class="glyphicons settings">
                                <i></i>
                                <span>Klienti</span>
                                <span class="icon-chevron-down"></span>
                            </a>
                            <ul class="collapse" id="userAdmin">
                                <li class="">
                                    <a class="glyphicons user" href="{{url('showUserUcUc')}}">Správa</a>
                                </li>
                                <!-- // Components Submenu Regular Items END -->
                            </ul>
                        </li>
                    @endrole
                    
                    <li class="hasSubmenu">
                        <a href="#menu_pages" data-toggle="collapse" class="glyphicons notes">
                            <i></i>
                            <span>Dokumenty</span>
                            <span class="icon-chevron-down"></span>
                        </a>
                        <ul class="collapse" id="menu_pages">
                            <li><a href="{{url('paperShow')}}">Bločky</a></li>
                            <li><a href="{{url('tags')}}">Tagy</a></li>
                            @role('company_owner') 
                            <li><a href="{{url('addDoc')}}">Pridať dokument</a></li>
                            @endrole
                        </ul>
                    </li>
                </ul>
                <div class="clearfix"></div>
                <!-- // Menu END -->

                {{--<div class="menu-hidden-element alert alert-primary">--}}
                    {{--<a class="close" data-dismiss="alert">&times;</a>--}}
                    {{--<p>Integer quis tempor mi. Donec venenatis dui in neque fringilla at iaculis libero ullamcorper. In--}}
                        {{--velit sem, sodales id hendrerit ac, fringilla et est.</p>--}}
                {{--</div>--}}

            </div>
            <!-- // Scrollable Menu wrapper with Maximum Height END -->

        </div>
        <!-- // Sidebar Menu END -->