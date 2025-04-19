<div class="sidebar sidebar-dark sidebar-main sidebar-expand-lg">

    <!-- Sidebar content -->
    <div class="sidebar-content">

        <!-- Sidebar header -->
        <div class="sidebar-section">
            <div class="sidebar-section-body d-flex justify-content-center">
                <h5 class="sidebar-resize-hide flex-grow-1 my-auto">TSTH 2 Pollung</h5>

                <div>
                    <button type="button"
                        class="btn btn-flat-white btn-icon btn-sm rounded-pill border-transparent sidebar-control sidebar-main-resize d-none d-lg-inline-flex">
                        <i class="ph-arrows-left-right"></i>
                    </button>

                    <button type="button"
                        class="btn btn-flat-white btn-icon btn-sm rounded-pill border-transparent sidebar-mobile-main-toggle d-lg-none">
                        <i class="ph-x"></i>
                    </button>
                </div>
            </div>
        </div>
        <!-- /sidebar header -->


        <!-- Main navigation -->
        <div class="sidebar-section">
            <ul class="nav nav-sidebar" data-nav-type="accordion">

                <!-- Main -->
                <li class="nav-item-header pt-0">
                    <div class="text-uppercase fs-sm lh-sm opacity-50 sidebar-resize-hide">Main</div>
                    <i class="ph-dots-three sidebar-resize-show"></i>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link">
                        <i class="ph-house"></i>
                        <span>
                            Dashboard
                        </span>
                    </a>
                </li>
                <li class="nav-item nav-item-submenu">
                    <a href="#" class="nav-link">
                        <i class="ph-layout"></i>
                        <span>Habitus Manage</span>
                    </a>
                    <ul class="nav-group-sub collapse">
                </li>
                <li class="nav-item"><a href="{{ route('habitus.index') }}" class="nav-link">List
                        Habitus Data</a></li>
            </ul>
            <li class="nav-item nav-item-submenu">
                <a href="#" class="nav-link">
                    <i class="ph ph-user-list"></i>
                    <span>Staff Manage</span>
                </a>
                <ul class="nav-group-sub collapse">
                    <li class="nav-item"><a href="{{ route('staff.index') }}" class="nav-link">List Staff Data</a></li>
                </ul>
            </li>
            <li class="nav-item nav-item-submenu">
                <a href="#" class="nav-link">
                    <i class="ph ph-leaf"></i>
                    <span>Plant Manage</span>
                </a>
                <ul class="nav-group-sub collapse">
                    <li class="nav-item"><a href="{{ route('plant.index') }}" class="nav-link">List Plant Data</a></li>
                </ul>
            </li>
            <li class="nav-item nav-item-submenu">
                <a href="#" class="nav-link">
                    <i class="ph-browser"></i>
                    <span>Land Manage</span>
                </a>
                <ul class="nav-group-sub collapse">
                    <li class="nav-item"><a href="{{ route('land.index') }}" class="nav-link">List Land Data</a></li>
                </ul>
            </li>
            <li class="nav-item nav-item-submenu">
                <a href="#" class="nav-link">
                    <i class="ph-users-three"></i>
                    <span>Visitor Manage</span>
                </a>
                <ul class="nav-group-sub collapse">
                    <li class="nav-item"><a href="{{ route('visitor.index') }}" class="nav-link">List Visitor Data</a>
                    </li>
                    <li class="nav-item"><a href="{{ route('visitor.category.index') }}" class="nav-link">List Visitor
                            Category Data</a></li>
                </ul>
            </li>
            <li class="nav-item nav-item-submenu">
                <a href="#" class="nav-link">
                    <i class="ph ph-newspaper"></i>
                    <span>News Manage</span>
                </a>
                <ul class="nav-group-sub collapse">
                    <li class="nav-item"><a href="{{ route('news.index') }}" class="nav-link">List News Data</a></li>
                </ul>
            </li>

            <li class="nav-item nav-item-submenu">
                <a href="#" class="nav-link">
                    <i class="ph-article"></i>
                    <span>Content Manage</span>
                </a>
                <ul class="nav-group-sub collapse">
                    <li class="nav-item"><a href="{{ route('content.index') }}" class="nav-link">List Content Data</a>
                    </li>
                    <li class="nav-item"><a href="{{ route('contact.index') }}" class="nav-link">Contact Us
                            Data</a>
                    </li>
                </ul>
            </li>

            <li class="nav-item nav-item-submenu">
                <a href="#" class="nav-link">
                    <i class="ph-globe"></i>
                    <span>Language Manage</span>
                </a>
                <ul class="nav-group-sub collapse">
                    <li class="nav-item"><a href="{{ route('language.index') }}" class="nav-link">List Language
                            Data</a>
                    </li>
                </ul>
            </li>
        </div>
        <!-- /main navigation -->

    </div>
    <!-- /sidebar content -->

</div>
