<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="" class="brand-link">
        <span class="brand-text font-weight-light">Admin Panel</span>
    </a>

    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{route('backend.dashboard')}}" class="nav-link {{ (request()->is('dashboard')) ? 'active' : '' }} ">
                        <i class="nav-icon fas fa-th"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                @if( Sentinel::getUser()->hasAnyAccess(['countries.*','states.*','cities.*','departments.*']) )
                <li class="nav-item {{ (request()->is('countries*')) || (request()->is('states*')) || (request()->is('cities*')) ? 'menu-is-opening menu-open' : '' }}">
                    <a href="#" class="nav-link {{ (request()->is('countries*')) || (request()->is('states*')) || (request()->is('cities*')) ? 'active' : '' }}">
                        <i class="nav-icon far fa-envelope"></i>
                        <p>
                            System Management
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" style="{{ (request()->is('countries*')) || (request()->is('states*')) || (request()->is('cities*')) ? 'display:block' : '' }}">
                        @if( Sentinel::getUser()->hasAccess('countries.view') )
                        <li class="nav-item">
                            <a href="{{route('countries.index')}}" class="nav-link {{ (request()->is('countries*')) ? 'active' : '' }} ">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Country</p>
                            </a>
                        </li>
                        @endif
                        @if( Sentinel::getUser()->hasAccess('states.view') )
                        <li class="nav-item">
                            <a href="{{route('states.index')}}" class="nav-link {{ (request()->is('states*')) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>State</p>
                            </a>
                        </li>
                        @endif
                        @if( Sentinel::getUser()->hasAccess('cities.view') )
                        <li class="nav-item">
                            <a href="{{route('cities.index')}}" class="nav-link {{ (request()->is('cities*')) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>City</p>
                            </a>
                        </li>
                        @endif
                        @if( Sentinel::getUser()->hasAccess('departments.view') )
                        <li class="nav-item">
                            <a href="{{route('departments.index')}}" class="nav-link {{ (request()->is('departments*')) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Department</p>
                            </a>
                        </li>
                        @endif
                    </ul>
                </li>
                @endif

                @if( Sentinel::getUser()->hasAnyAccess('employee.*') )
                <li class="nav-item">
                    <a href="{{ route('backend.employee.index') }}" class="nav-link {{ (request()->is('employee*')) ? 'active' : '' }}">
                        <i class="fa fa-th"></i> <span>Employee management</span>
                    </a>
                </li>
                @endif


                @if( Sentinel::getUser()->hasAnyAccess(['user.*','role.*','permission.*']) )
                <li class="nav-item {{ (request()->is('user*')) || (request()->is('role*')) || (request()->is('permission*')) ? 'menu-is-opening menu-open' : '' }}">
                    <a href="#" class="nav-link {{ (request()->is('user*')) || (request()->is('role*')) || (request()->is('permission*')) ? 'active' : '' }}">
                        <i class="nav-icon far fa-envelope"></i>
                        <p>
                            User Management
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" style="{{ (request()->is('user*')) || (request()->is('role*')) || (request()->is('permission*')) ? 'display:block' : '' }}">
                        @if( Sentinel::getUser()->hasAccess('user.view') )
                        <li class="nav-item ">
                            <a href="{{route('user.index')}}" class="nav-link {{ (request()->is('user*')) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>User</p>
                            </a>
                        </li>
                        @endif
                        @if( Sentinel::getUser()->hasAccess('role.view') )
                        <li class="nav-item ">
                            <a href="{{route('role.index')}}" class="nav-link {{ (request()->is('role*')) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Role</p>
                            </a>
                        </li>
                        @endif
                        @if( Sentinel::getUser()->hasAccess('permission.view') )
                        <li class="nav-item">
                            <a href="{{route('permission.index')}}" class="nav-link  {{ (request()->is('permission*')) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Permission</p>
                            </a>
                        </li>
                        @endif
                    </ul>
                </li>
                @endif

                <li class="nav-item">
                    <a href="{{ route('backend.user.change.password') }}" class="nav-link {{ (request()->is('change_password')) ? 'active' : '' }} ">
                        <i class="nav-icon fas fa-th"></i>
                        <p>Change Password</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
