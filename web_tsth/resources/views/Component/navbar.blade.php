<div class="navbar navbar-dark navbar-expand-lg navbar-static border-bottom border-bottom-white border-opacity-10">
    <div class="container-fluid">
        <div class="d-flex d-lg-none me-2">
            <button type="button" class="navbar-toggler sidebar-mobile-main-toggle rounded-pill">
                <i class="ph-list"></i>
            </button>
        </div>

        <div class="navbar-brand flex-1 flex-lg-0">
            <a href="index.html" class="d-inline-flex align-items-center" style="padding-left: 20%;">
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

            {{-- <li class="nav-item nav-item-dropdown-lg dropdown">
                <a href="#" class="navbar-nav-link navbar-nav-link-icon rounded-pill" data-bs-toggle="dropdown">
                    <i class="ph-squares-four"></i>
                </a>

                <div class="dropdown-menu dropdown-menu-scrollable-sm wmin-lg-600 p-0">
                    <div class="d-flex align-items-center border-bottom p-3">
                        <h6 class="mb-0">Browse apps</h6>
                        <a href="#" class="ms-auto">
                            View all
                            <i class="ph-arrow-circle-right ms-1"></i>
                        </a>
                    </div>

                    <div class="row row-cols-1 row-cols-sm-2 g-0">
                        <div class="col">
                            <button type="button"
                                class="dropdown-item text-wrap h-100 align-items-start border-end-sm border-bottom p-3">
                                <div>
                                    <img src="{{asset('/admin/assets/images/demo/logos/1.svg')}}"
                                        class="h-40px mb-2" alt="">
                                    <div class="fw-semibold my-1">Customer data platform</div>
                                    <div class="text-muted">Unify customer data from multiple sources</div>
                                </div>
                            </button>
                        </div>

                        <div class="col">
                            <button type="button"
                                class="dropdown-item text-wrap h-100 align-items-start border-bottom p-3">
                                <div>
                                    <img src="{{asset('/admin/assets/images/demo/logos/2.svg')}}"
                                        class="h-40px mb-2" alt="">
                                    <div class="fw-semibold my-1">Data catalog</div>
                                    <div class="text-muted">Discover, inventory, and organize data assets</div>
                                </div>
                            </button>
                        </div>

                        <div class="col">
                            <button type="button"
                                class="dropdown-item text-wrap h-100 align-items-start border-end-sm border-bottom border-bottom-sm-0 rounded-bottom-start p-3">
                                <div>
                                    <img src="{{asset('/admin/assets/images/demo/logos/3.svg')}}"
                                        class="h-40px mb-2" alt="">
                                    <div class="fw-semibold my-1">Data governance</div>
                                    <div class="text-muted">The collaboration hub and data marketplace</div>
                                </div>
                            </button>
                        </div>

                        <div class="col">
                            <button type="button"
                                class="dropdown-item text-wrap h-100 align-items-start rounded-bottom-end p-3">
                                <div>
                                    <img src="{{asset('/admin/assets/images/demo/logos/4.svg')}}"
                                        class="h-40px mb-2" alt="">
                                    <div class="fw-semibold my-1">Data privacy</div>
                                    <div class="text-muted">Automated provisioning of non-production datasets</div>
                                </div>
                            </button>
                        </div>
                    </div>
                </div>
            </li> --}}

            {{-- <li class="nav-item nav-item-dropdown-lg dropdown ms-lg-2">
                <a href="#" class="navbar-nav-link navbar-nav-link-icon rounded-pill" data-bs-toggle="dropdown"
                    data-bs-auto-close="outside">
                    <i class="ph-chats"></i>
                    <span
                        class="badge bg-yellow text-black position-absolute top-0 end-0 translate-middle-top zindex-1 rounded-pill mt-1 me-1">8</span>
                </a>

                <div class="dropdown-menu wmin-lg-400 p-0">
                    <div class="d-flex align-items-center p-3">
                        <h6 class="mb-0">Messages</h6>
                        <div class="ms-auto">
                            <a href="#" class="text-body">
                                <i class="ph-plus-circle"></i>
                            </a>
                            <a href="#search_messages" class="collapsed text-body ms-2" data-bs-toggle="collapse">
                                <i class="ph-magnifying-glass"></i>
                            </a>
                        </div>
                    </div>

                    <div class="collapse" id="search_messages">
                        <div class="px-3 mb-2">
                            <div class="form-control-feedback form-control-feedback-start">
                                <input type="text" class="form-control" placeholder="Search messages">
                                <div class="form-control-feedback-icon">
                                    <i class="ph-magnifying-glass"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="dropdown-menu-scrollable pb-2">
                        <a href="#" class="dropdown-item align-items-start text-wrap py-2">
                            <div class="status-indicator-container me-3">
                                <img src="{{asset('/admin/assets/images/demo/users/face10.jpg')}}"
                                    class="w-40px h-40px rounded-pill" alt="">
                                <span class="status-indicator bg-warning"></span>
                            </div>

                            <div class="flex-1">
                                <span class="fw-semibold">James Alexander</span>
                                <span class="text-muted float-end fs-sm">04:58</span>
                                <div class="text-muted">who knows, maybe that would be the best thing for me...
                                </div>
                            </div>
                        </a>

                        <a href="#" class="dropdown-item align-items-start text-wrap py-2">
                            <div class="status-indicator-container me-3">
                                <img src="{{asset('/admin/assets/images/demo/users/face3.jpg')}}"
                                    class="w-40px h-40px rounded-pill" alt="">
                                <span class="status-indicator bg-success"></span>
                            </div>

                            <div class="flex-1">
                                <span class="fw-semibold">Margo Baker</span>
                                <span class="text-muted float-end fs-sm">12:16</span>
                                <div class="text-muted">That was something he was unable to do because...</div>
                            </div>
                        </a>

                        <a href="#" class="dropdown-item align-items-start text-wrap py-2">
                            <div class="status-indicator-container me-3">
                                <img src="{{asset('/admin/assets/images/demo/users/face24.jpg')}}"
                                    class="w-40px h-40px rounded-pill" alt="">
                                <span class="status-indicator bg-success"></span>
                            </div>
                            <div class="flex-1">
                                <span class="fw-semibold">Jeremy Victorino</span>
                                <span class="text-muted float-end fs-sm">22:48</span>
                                <div class="text-muted">But that would be extremely strained and suspicious...</div>
                            </div>
                        </a>

                        <a href="#" class="dropdown-item align-items-start text-wrap py-2">
                            <div class="status-indicator-container me-3">
                                <img src="{{asset('/admin/assets/images/demo/users/face4.jpg')}}"
                                    class="w-40px h-40px rounded-pill" alt="">
                                <span class="status-indicator bg-grey"></span>
                            </div>
                            <div class="flex-1">
                                <span class="fw-semibold">Beatrix Diaz</span>
                                <span class="text-muted float-end fs-sm">Tue</span>
                                <div class="text-muted">What a strenuous career it is that I've chosen...</div>
                            </div>
                        </a>

                        <a href="#" class="dropdown-item align-items-start text-wrap py-2">
                            <div class="status-indicator-container me-3">
                                <img src="{{asset('/admin/assets/images/demo/users/face25.jpg')}}"
                                    class="w-40px h-40px rounded-pill" alt="">
                                <span class="status-indicator bg-danger"></span>
                            </div>
                            <div class="flex-1">
                                <span class="fw-semibold">Richard Vango</span>
                                <span class="text-muted float-end fs-sm">Mon</span>
                                <div class="text-muted">Other travelling salesmen live a life of luxury...</div>
                            </div>
                        </a>
                    </div>

                    <div class="d-flex border-top py-2 px-3">
                        <a href="#" class="text-body">
                            <i class="ph-checks me-1"></i>
                            Dismiss all
                        </a>
                        <a href="#" class="text-body ms-auto">
                            View all
                            <i class="ph-arrow-circle-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </li> --}}
        </ul>

        <div class="navbar-collapse justify-content-center flex-lg-1 order-2 order-lg-1 collapse" id="navbar_search">
            <div class="navbar-search flex-fill position-relative mt-2 mt-lg-0 mx-lg-3">
                <div class="form-control-feedback form-control-feedback-start flex-grow-1" data-color-theme="dark">
                    <input type="text" class="form-control bg-transparent rounded-pill" placeholder="Search"
                        data-bs-toggle="dropdown">
                    <div class="form-control-feedback-icon">
                        <i class="ph-magnifying-glass"></i>
                    </div>
                    <div class="dropdown-menu w-100" data-color-theme="light">
                        {{-- <button type="button" class="dropdown-item">
                            <div class="text-center w-32px me-3">
                                <i class="ph-magnifying-glass"></i>
                            </div>
                            <span>Search <span class="fw-bold">"in"</span> everywhere</span>
                        </button> --}}

                        <div class="dropdown-divider"></div>

                        <div class="dropdown-menu-scrollable-lg">
                            <div class="dropdown-header">
                                Contacts
                                <a href="#" class="float-end">
                                    See all
                                    <i class="ph-arrow-circle-right ms-1"></i>
                                </a>
                            </div>

                            <div class="dropdown-item cursor-pointer">
                                <div class="me-3">
                                    <img src="{{ asset('/admin/assets/images/demo/users/face3.jpg') }}"
                                        class="w-32px h-32px rounded-pill" alt="">
                                </div>

                                <div class="d-flex flex-column flex-grow-1">
                                    <div class="fw-semibold">Christ<mark>in</mark>e Johnson</div>
                                    <span class="fs-sm text-muted">c.johnson@awesomecorp.com</span>
                                </div>

                                <div class="d-inline-flex">
                                    <a href="#" class="text-body ms-2">
                                        <i class="ph-user-circle"></i>
                                    </a>
                                </div>
                            </div>

                            <div class="dropdown-item cursor-pointer">
                                <div class="me-3">
                                    <img src="{{ asset('/admin/assets/images/demo/users/face24.jpg') }}"
                                        class="w-32px h-32px rounded-pill" alt="">
                                </div>

                                <div class="d-flex flex-column flex-grow-1">
                                    <div class="fw-semibold">Cl<mark>in</mark>ton Sparks</div>
                                    <span class="fs-sm text-muted">c.sparks@awesomecorp.com</span>
                                </div>

                                <div class="d-inline-flex">
                                    <a href="#" class="text-body ms-2">
                                        <i class="ph-user-circle"></i>
                                    </a>
                                </div>
                            </div>

                            <div class="dropdown-divider"></div>

                            <div class="dropdown-header">
                                Clients
                                <a href="#" class="float-end">
                                    See all
                                    <i class="ph-arrow-circle-right ms-1"></i>
                                </a>
                            </div>

                            <div class="dropdown-item cursor-pointer">
                                <div class="me-3">
                                    <img src="{{ asset('/admin/assets/images/brands/adobe.svg') }}"
                                        class="w-32px h-32px rounded-pill" alt="">
                                </div>

                                <div class="d-flex flex-column flex-grow-1">
                                    <div class="fw-semibold">Adobe <mark>In</mark>c.</div>
                                    <span class="fs-sm text-muted">Enterprise license</span>
                                </div>

                                <div class="d-inline-flex">
                                    <a href="#" class="text-body ms-2">
                                        <i class="ph-briefcase"></i>
                                    </a>
                                </div>
                            </div>

                            <div class="dropdown-item cursor-pointer">
                                <div class="me-3">
                                    <img src="{{ asset('/admin/assets/images/brands/holiday-inn.svg') }}"
                                        class="w-32px h-32px rounded-pill" alt="">
                                </div>

                                <div class="d-flex flex-column flex-grow-1">
                                    <div class="fw-semibold">Holiday-<mark>In</mark>n</div>
                                    <span class="fs-sm text-muted">On-premise license</span>
                                </div>

                                <div class="d-inline-flex">
                                    <a href="#" class="text-body ms-2">
                                        <i class="ph-briefcase"></i>
                                    </a>
                                </div>
                            </div>

                            <div class="dropdown-item cursor-pointer">
                                <div class="me-3">
                                    <img src="{{ asset('/admin/assets/images/brands/ing.svg') }}"
                                        class="w-32px h-32px rounded-pill" alt="">
                                </div>

                                <div class="d-flex flex-column flex-grow-1">
                                    <div class="fw-semibold"><mark>IN</mark>G Group</div>
                                    <span class="fs-sm text-muted">Perpetual license</span>
                                </div>

                                <div class="d-inline-flex">
                                    <a href="#" class="text-body ms-2">
                                        <i class="ph-briefcase"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- <a href="#"
                    class="navbar-nav-link align-items-center justify-content-center w-40px h-32px rounded-pill position-absolute end-0 top-50 translate-middle-y p-0 me-1"
                    data-bs-toggle="dropdown" data-bs-auto-close="outside">
                    <i class="ph-faders-horizontal"></i>
                </a>

                <div class="dropdown-menu w-100 p-3">
                    <div class="d-flex align-items-center mb-3">
                        <h6 class="mb-0">Search options</h6>
                        <a href="#" class="text-body rounded-pill ms-auto">
                            <i class="ph-clock-counter-clockwise"></i>
                        </a>
                    </div>

                    <div class="mb-3">
                        <label class="d-block form-label">Category</label>
                        <label class="form-check form-check-inline">
                            <input type="checkbox" class="form-check-input" checked>
                            <span class="form-check-label">Invoices</span>
                        </label>
                        <label class="form-check form-check-inline">
                            <input type="checkbox" class="form-check-input">
                            <span class="form-check-label">Files</span>
                        </label>
                        <label class="form-check form-check-inline">
                            <input type="checkbox" class="form-check-input">
                            <span class="form-check-label">Users</span>
                        </label>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Addition</label>
                        <div class="input-group">
                            <select class="form-select w-auto flex-grow-0">
                                <option value="1" selected>has</option>
                                <option value="2">has not</option>
                            </select>
                            <input type="text" class="form-control" placeholder="Enter the word(s)">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <div class="input-group">
                            <select class="form-select w-auto flex-grow-0">
                                <option value="1" selected>is</option>
                                <option value="2">is not</option>
                            </select>
                            <select class="form-select">
                                <option value="1" selected>Active</option>
                                <option value="2">Inactive</option>
                                <option value="3">New</option>
                                <option value="4">Expired</option>
                                <option value="5">Pending</option>
                            </select>
                        </div>
                    </div>

                    <div class="d-flex">
                        <button type="button" class="btn btn-light">Reset</button>

                        <div class="ms-auto">
                            <button type="button" class="btn btn-light">Cancel</button>
                            <button type="button" class="btn btn-primary ms-2">Apply</button>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>

        <ul class="nav flex-row justify-content-end order-1 order-lg-2">
            <li class="nav-item ms-lg-2">
                <a href="#" class="navbar-nav-link navbar-nav-link-icon rounded-pill"
                    data-bs-toggle="offcanvas" data-bs-target="#notifications">
                    <i class="ph-bell"></i>
                    <span
                        class="badge bg-yellow text-black position-absolute top-0 end-0 translate-middle-top zindex-1 rounded-pill mt-1 me-1">12</span>
                </a>
            </li>

            <li class="nav-item nav-item-dropdown-lg dropdown ms-lg-2">
                <a href="#" class="navbar-nav-link align-items-center rounded-pill p-1"
                    data-bs-toggle="dropdown">
                    <div class="status-indicator-container">
                        <img src="{{ asset('/admin/assets/images/demo/users/face11.jpg') }}"
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


<div class="offcanvas offcanvas-end" tabindex="-1" id="notifications">
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

            {{-- <div class="d-flex align-items-start mb-3">
                <a href="#" class="status-indicator-container me-3">
                    <img src="{{asset('/admin/assets/images/demo/users/face3.jpg')}}"
                        class="w-40px h-40px rounded-pill" alt="">
                    <span class="status-indicator bg-warning"></span>
                </a>
                <div class="flex-fill">
                    <a href="#" class="fw-semibold">Margo</a> has added 4 users to <span
                        class="fw-semibold">Customer enablement</span> channel

                    <div class="d-flex my-2">
                        <a href="#" class="status-indicator-container me-1">
                            <img src="{{asset('/admin/assets/images/demo/users/face10')}}.jpg"
                                class="w-32px h-32px rounded-pill" alt="">
                            <span class="status-indicator bg-danger"></span>
                        </a>
                        <a href="#" class="status-indicator-container me-1">
                            <img src="{{asset('/admin/assets/images/demo/users/face11')}}.jpg"
                                class="w-32px h-32px rounded-pill" alt="">
                            <span class="status-indicator bg-success"></span>
                        </a>
                        <a href="#" class="status-indicator-container me-1">
                            <img src="{{asset('/admin/assets/images/demo/users/face12')}}.jpg"
                                class="w-32px h-32px rounded-pill" alt="">
                            <span class="status-indicator bg-success"></span>
                        </a>
                        <a href="#" class="status-indicator-container me-1">
                            <img src="{{asset('/admin/assets/images/demo/users/face13')}}.jpg"
                                class="w-32px h-32px rounded-pill" alt="">
                            <span class="status-indicator bg-success"></span>
                        </a>
                        <button type="button"
                            class="btn btn-light btn-icon d-inline-flex align-items-center justify-content-center w-32px h-32px rounded-pill p-0">
                            <i class="ph-plus ph-sm"></i>
                        </button>
                    </div>

                    <div class="fs-sm text-muted mt-1">3 hours ago</div>
                </div>
            </div> --}}

            {{-- <div class="d-flex align-items-start">
                <div class="me-3">
                    <div class="bg-warning bg-opacity-10 text-warning rounded-pill">
                        <i class="ph-warning p-2"></i>
                    </div>
                </div>
                <div class="flex-1">
                    Subscription <a href="#">#466573</a> from 10.12.2021 has been cancelled. Refund case <a
                        href="#">#4492</a> created
                    <div class="fs-sm text-muted mt-1">4 hours ago</div>
                </div>
            </div> --}}
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

            {{-- <div class="d-flex align-items-start mb-3">
                <div class="me-3">
                    <div class="bg-success bg-opacity-10 text-success rounded-pill">
                        <i class="ph-calendar-plus p-2"></i>
                    </div>
                </div>
                <div class="flex-fill">
                    All hands meeting will take place coming Thursday at 13:45.

                    <div class="my-2">
                        <a href="#" class="btn btn-primary btn-sm">
                            <i class="ph-calendar-plus ph-sm me-1"></i>
                            Add to calendar
                        </a>
                    </div>

                    <div class="fs-sm text-muted mt-1">2 days ago</div>
                </div>
            </div>

            <div class="d-flex align-items-start mb-3">
                <a href="#" class="status-indicator-container me-3">
                    <img src="{{asset('/admin/assets/images/demo/users/face4.jpg')}}"
                        class="w-40px h-40px rounded-pill" alt="">
                    <span class="status-indicator bg-danger"></span>
                </a>
                <div class="flex-fill">
                    <a href="#" class="fw-semibold">Christine</a> commented on your community <a href="#">post</a>
                    from 10.12.2021

                    <div class="fs-sm text-muted mt-1">2 days ago</div>
                </div>
            </div>

            <div class="d-flex align-items-start mb-3">
                <div class="me-3">
                    <div class="bg-primary bg-opacity-10 text-primary rounded-pill">
                        <i class="ph-users-four p-2"></i>
                    </div>
                </div>
                <div class="flex-fill">
                    <span class="fw-semibold">HR department</span> requested you to complete internal survey by
                    Friday

                    <div class="fs-sm text-muted mt-1">3 days ago</div>
                </div>
            </div> --}}

            {{-- <div class="text-center">
                <div class="spinner-border" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div> --}}
        </div>
    </div>
</div>
