<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Messages Dropdown Menu -->
        <li class="nav-item">
            <a href="#" class="">
                <span class="hidden-xs">{{ Sentinel::getUser()->first_name }}</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('backend.user.logout') }}" class="">
                <span class="hidden-xs">Logout</span>
            </a>
        </li>

    </ul>
</nav>
