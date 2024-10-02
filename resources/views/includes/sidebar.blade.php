<!-- Brand Logo -->
<a href="{{route('home')}}" class="brand-link">
    <span class="brand-text font-weight-light">JIN MOBILE</span>
</a>

<!-- Sidebar -->
<div class="sidebar">
    <!-- Sidebar user panel (optional) -->
{{--    <div class="user-panel mt-3 pb-3 mb-3 d-flex">--}}
{{--        <div class="image">--}}
{{--            <img src="{{asset('dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">--}}
{{--        </div>--}}
{{--        <div class="info">--}}
{{--            <a href="#" class="d-block">Акоп Арутюнян</a>--}}
{{--        </div>--}}
{{--    </div>--}}

    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
            data-accordion="false">
            <li class="nav-item">
                <a class="nav-link" href="{{route('products.index')}}">
                    <i class="nav-icon fas fa-tasks"></i>
                    <p>Ապրանքներ</p>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('shops.index')}}">
                    <i class="nav-icon fas fa-tasks"></i>
                    <p>Խանութներ</p>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('categories.index')}}">
                    <i class="nav-icon fas fa-tasks"></i>
                    <p>Կատեգորիաներ</p>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('master-verification-requests.index')}}">
                    <i class="nav-icon fas fa-tasks"></i>
                    <p>Վարպետների դիմումներ</p>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('professions.index')}}">
                    <i class="nav-icon fas fa-tasks"></i>
                    <p>Մասնագիտություններ</p>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('services.index')}}">
                    <i class="nav-icon fas fa-tasks"></i>
                    <p>Ծառայություններ</p>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('pages.index')}}">
                    <i class="nav-icon fas fa-tasks"></i>
                    <p>Էջեր</p>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('orders.index')}}">
                    <i class="nav-icon fas fa-tasks"></i>
                    <p>Պատվերներ</p>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('users.index')}}">
                    <i class="nav-icon fas fa-tasks"></i>
                    <p>Օգտվողներ</p>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('custom-fields.index')}}">
                    <i class="nav-icon fas fa-tasks"></i>
                    <p>Custom Fields</p>
                </a>
            </li>
        </ul>
    </nav>
</div>
