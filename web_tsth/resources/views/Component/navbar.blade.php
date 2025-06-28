<div class="navbar navbar-dark navbar-expand-lg navbar-static border-bottom border-bottom-white border-opacity-10">
    <div class="container-fluid">
        <div class="d-flex d-lg-none me-2">
            <button type="button" class="navbar-toggler sidebar-mobile-main-toggle rounded-pill">
                <i class="ph-list"></i>
            </button>
        </div>

        <div class="navbar-brand flex-1 flex-lg-0">
            <a href="{{ route('home') }}" class="d-inline-flex align-items-center" style="padding-left: 20%;">
                <img src="{{ asset('images/logoweb-removebg.png') }}" style="height: 40px; width: auto;" alt="">
            </a>
        </div>

        <ul class="nav flex-row">
            <li class="nav-item d-lg-none">
                <a href="#navbar_search" class="navbar-nav-link navbar-nav-link-icon rounded-pill"
                    data-bs-toggle="collapse">
                    <i class="ph-magnifying-glass"></i>
                </a>
            </li>
        </ul>



        <ul class="nav flex-row justify-content-end order-1 order-lg-2">
            {{-- <li class="nav-item ms-lg-2">
                <a href="#" class="navbar-nav-link navbar-nav-link-icon rounded-pill" data-bs-toggle="offcanvas"
                    data-bs-target="#notifications">
                    <i class="ph-bell"></i>
                    <span
                        class="badge bg-yellow text-black position-absolute top-0 end-0 translate-middle-top zindex-1 rounded-pill mt-1 me-1">12</span>
                </a>
            </li> --}}

            <li class="nav-item nav-item-dropdown-lg dropdown ms-lg-2">
                <a href="#" class="navbar-nav-link align-items-center rounded-pill p-1" data-bs-toggle="dropdown">
                    <div class="status-indicator-container">
                        <img src="https://toowoombaautoservices.com.au/wp-content/uploads/2020/01/person-1824144_1280-1080x1080.png"
                            class="w-32px h-32px rounded-pill" alt="">
                        <span class="status-indicator bg-success"></span>
                    </div>
                    <span class="d-none d-lg-inline-block mx-lg-2">{{ $data->username }}</span>
                </a>

                <div class="dropdown-menu dropdown-menu-end">
                    <a href="#" class="dropdown-item">
                        <i class="ph-user-circle me-2"></i>
                        My profile
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="ph-gear me-2"></i>
                        Account settings
                    </a>
                    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="dropdown-item">
                            <i class="ph-sign-out me-2"></i>
                            Logout
                        </button>
                    </form>
                </div>
            </li>
        </ul>
    </div>
</div>


{{-- <div class="offcanvas offcanvas-end" tabindex="-1" id="notifications">
    <div class="offcanvas-header py-0">
        <h5 class="offcanvas-title py-3">Activity</h5>
        <button type="button" class="btn btn-light btn-sm btn-icon border-transparent rounded-pill"
            data-bs-dismiss="offcanvas">
            <i class="ph-x"></i>
        </button>
    </div>

    <div class="offcanvas-body p-0">
        <div class="bg-light fw-medium py-2 px-3">New notifications</div>
        <div class="p-3">
            <div class="d-flex align-items-start mb-3">
                <a href="#" class="status-indicator-container me-3">
                    <img src="{{ asset('/admin/assets/images/demo/users/face1.jpg') }}"
                        class="w-40px h-40px rounded-pill" alt="">
                    <span class="status-indicator bg-success"></span>
                </a>
                <div class="flex-fill">
                    <a href="#" class="fw-semibold">James</a> has completed the task <a href="#">Submit
                        documents</a> from <a href="#">Onboarding</a> list

                    <div class="bg-light rounded p-2 my-2">
                        <label class="form-check ms-1">
                            <input type="checkbox" class="form-check-input" checked disabled>
                            <del class="form-check-label">Submit personal documents</del>
                        </label>
                    </div>

                    <div class="fs-sm text-muted mt-1">2 hours ago</div>
                </div>
            </div>
        </div>

        <div class="bg-light fw-medium py-2 px-3">Older notifications</div>
        <div class="p-3">
            <div class="d-flex align-items-start mb-3">
                <a href="#" class="status-indicator-container me-3">
                    <img src="{{ asset('/admin/assets/images/demo/users/face25.jpg') }}"
                        class="w-40px h-40px rounded-pill" alt="">
                    <span class="status-indicator bg-success"></span>
                </a>
                <div class="flex-fill">
                    <a href="#" class="fw-semibold">Nick</a> requested your feedback and approval in support
                    request
                    <a href="#">#458</a>

                    <div class="my-2">
                        <a href="#" class="btn btn-success btn-sm me-1">
                            <i class="ph-checks ph-sm me-1"></i>
                            Approve
                        </a>
                        <a href="#" class="btn btn-light btn-sm">
                            Review
                        </a>
                    </div>

                    <div class="fs-sm text-muted mt-1">3 days ago</div>
                </div>
            </div>

            <div class="d-flex align-items-start mb-3">
                <a href="#" class="status-indicator-container me-3">
                    <img src="{{ asset('/admin/assets/images/demo/users/face24.jpg') }}"
                        class="w-40px h-40px rounded-pill" alt="">
                    <span class="status-indicator bg-grey"></span>
                </a>
                <div class="flex-fill">
                    <a href="#" class="fw-semibold">Mike</a> added 1 new file(s) to <a href="#">Product
                        management</a> project

                    <div class="bg-light rounded p-2 my-2">
                        <div class="d-flex align-items-center">
                            <div class="me-2">
                                <img src="{{ asset('/admin/assets/images/icons/pdf.svg') }}" width="34"
                                    height="34" alt="">
                            </div>
                            <div class="flex-fill">
                                new_contract.pdf
                                <div class="fs-sm text-muted">112KB</div>
                            </div>
                            <div class="ms-2">
                                <button type="button"
                                    class="btn btn-flat-dark text-body btn-icon btn-sm border-transparent rounded-pill">
                                    <i class="ph-arrow-down"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="fs-sm text-muted mt-1">1 day ago</div>
                </div>
            </div>
        </div>
    </div>
</div> --}}
