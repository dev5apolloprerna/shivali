<?php
if (auth()->user()) {
    $roleid = auth()->user()->role_id;
} else {
    $roleid = Auth::guard('web_employees')->user()->role_id;
}
?>
<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu">
    <div id="scrollbar">
        <div class="container-fluid">
            <div id="two-column-menu"></div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span data-key="t-menu"></span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link @if (request()->routeIs('home')) {{ 'active' }} @endif"
                        href="{{ route('home') }}">
                        <i class="mdi mdi-speedometer"></i>
                        <span data-key="t-dashboards">Dashboards</span>
                    </a>
                </li>
                @if ($roleid == '1' && $roleid != '2')
                    <!-- Category -->
                    <li class="nav-item">
                        <a class="nav-link menu-link @if (request()->routeIs('admin.category.*')) active @endif"
                            href="{{ route('admin.category.index') }}">
                            <i class="fas fa-folder"></i>
                            <span data-key="t-category">Category</span>
                        </a>
                    </li>

                    <!-- Sub Category -->
                    <li class="nav-item">
                        <a class="nav-link menu-link @if (request()->routeIs('admin.sub-category.*')) active @endif"
                            href="{{ route('admin.sub-category.index') }}">
                            <i class="fas fa-folder-open"></i>
                            <span data-key="t-sub-category">Sub Category</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link menu-link @if (request()->routeIs('admin.products.index')) {{ 'active' }} @endif"
                            href="{{ route('admin.products.index') }}">
                            <i class="fa-solid fa-box"></i>
                            <span data-key="t-dashboards">Product</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link menu-link @if (request()->routeIs('Inquiry.index')) {{ 'active' }} @endif"
                            href="{{ route('Inquiry.index') }}">
                            <i class="fa-solid fa-circle-question"></i>
                            <span data-key="t-dashboards">Inquiry</span>
                        </a>
                    </li>
                    {{-- <li class="nav-item">
                        <a class="nav-link menu-link @if (request()->routeIs('TopVideo.index')) {{ 'active' }} @endif"
                            href="{{ route('TopVideo.index') }}">
                            <i class="fa-solid fa-play-circle"></i>
                            <span data-key="t-dashboards">Top Video</span>
                        </a>
                    </li> --}}
                    {{-- <li class="nav-item">
                        <a class="nav-link menu-link @if (request()->routeIs('BottomVideo.index')) {{ 'active' }} @endif"
                            href="{{ route('BottomVideo.index') }}">
                            <i class="fa-solid fa-play-circle"></i>
                            <span data-key="t-dashboards">Bottom Video</span>
                        </a>
                    </li> --}}
                    <li class="nav-item">
                        <a class="nav-link menu-link @if (request()->routeIs('Banner.index')) {{ 'active' }} @endif"
                            href="{{ route('Banner.index') }}">
                            <i class="fa-solid fa-play-circle"></i>
                            <span data-key="t-dashboards">Banner</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link menu-link @if (request()->routeIs('Celebrity_Designer.index')) {{ 'active' }} @endif"
                            href="{{ route('Celebrity_Designer.index') }}">
                            <i class="fa-solid fa-play-circle"></i>
                            <span data-key="t-dashboards">Celebrity or Designer</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link menu-link @if (request()->routeIs('TageMaster.index')) {{ 'active' }} @endif"
                            href="{{ route('TageMaster.index') }}">
                            <i class="fa-solid fa-tag"></i>
                            <span data-key="t-dashboards">TagMaster</span>
                        </a>
                    </li>
                    {{-- <li class="nav-item">
                        <a class="nav-link menu-link @if (request()->routeIs('admin.image-settings.index')) active @endif"
                            href="{{ route('admin.image-settings.index') }}">
                            <i class="fa-solid fa-sliders"></i>
                            <span>Image Settings</span>
                        </a>
                    </li> --}}
                @endif
            </ul>
        </div>
        <!-- Sidebar -->
    </div>

    <div class="sidebar-background"></div>
</div>
