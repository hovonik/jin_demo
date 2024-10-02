<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <div class="dropdown show ml-2 notif-container">
        <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown"
           aria-haspopup="true" aria-expanded="false">
            Ծանուցումներ
            <i data-count="0" class="glyphicon glyphicon-bell notification-icon"></i>
        </a>
        <ul class="dropdown-menu dropdown-notifications" aria-labelledby="dropdownMenuLink" style="width: 300px">
        </ul>
    </div>
    <ul class="navbar-nav ml-auto">
        <!-- Navbar Search -->
        <li class="nav-item">
            <a class="nav-link" href="{{route('logout')}}" role="button">
                <i class="fas fa-sign-out-alt"></i>
                Դուրս գալ
            </a>
        </li>
    </ul>
</nav>

