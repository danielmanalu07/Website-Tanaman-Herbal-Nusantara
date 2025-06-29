<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>TSTH2 - Tanaman Herbal Nusantara</title>

    <!-- Global stylesheets -->
    <link href="{{ asset('/admin/assets/fonts/inter/inter.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('/admin/assets/icons/phosphor/styles.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('/admin/html/full/assets/css/ltr/all.min.css') }}" id="stylesheet" rel="stylesheet"
        type="text/css">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <!-- /global stylesheets -->

    <!-- Core JS files -->
    <script src="{{ asset('/admin/assets/demo/demo_configurator.js') }}"></script>
    <script src="{{ asset('/admin/assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script>


    <!-- jQuery dan DataTables JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <!-- /core JS files -->

    <!-- Theme JS files -->
    <script src="{{ asset('/admin/assets/js/vendor/visualization/d3/d3.min.js') }}"></script>
    <script src="{{ asset('/admin/assets/js/vendor/visualization/d3/d3_tooltip.js') }}"></script>

    <script src="{{ asset('/admin/html/seed/assets/js/app.js') }}"></script>
    <script src="{{ asset('/admin/assets/demo/pages/dashboard.js') }}"></script>
    <script src="{{ asset('/admin/assets/demo/charts/pages/dashboard/streamgraph.js') }}"></script>
    <script src="{{ asset('/admin/assets/demo/charts/pages/dashboard/sparklines.js') }}"></script>
    <script src="{{ asset('/admin/assets/demo/charts/pages/dashboard/lines.js') }}"></script>
    <script src="{{ asset('/admin/assets/demo/charts/pages/dashboard/areas.js') }}"></script>
    <script src="{{ asset('/admin/assets/demo/charts/pages/dashboard/donuts.js') }}"></script>
    <script src="{{ asset('/admin/assets/demo/charts/pages/dashboard/bars.js') }}"></script>
    <script src="{{ asset('/admin/assets/demo/charts/pages/dashboard/progress.js') }}"></script>
    <script src="{{ asset('/admin/assets/demo/charts/pages/dashboard/heatmaps.js') }}"></script>
    <script src="{{ asset('/admin/assets/demo/charts/pages/dashboard/pies.js') }}"></script>
    <script src="{{ asset('/admin/assets/demo/charts/pages/dashboard/bullets.js') }}"></script>

    <!-- /theme JS files -->

    <link rel="icon" type="image/jpg" href="{{ asset('images/logo.jpg') }}">

    <!-- CSS SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <!-- JS SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>

    <!-- CK EDITOR -->
    <script src="https://cdn.ckeditor.com/ckeditor5/41.2.1/classic/ckeditor.js"></script>
    {{-- <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/45.0.0/ckeditor5.css"> --}}

    {{-- <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/45.0.0/ckeditor5.css" crossorigin>
    <link rel="stylesheet"
        href="https://cdn.ckeditor.com/ckeditor5-premium-features/45.0.0/ckeditor5-premium-features.css" crossorigin> --}}

    {{-- <script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/translations/id.js"></script> --}}
    {{-- <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/45.0.0/ckeditor5.css" />
    <script src="https://cdn.ckeditor.com/ckeditor5/45.0.0/ckeditor5.umd.js"></script> --}}

    <!-- External Resources -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
    <script src="https://unpkg.com/filepond@4.30.4/dist/filepond.js"></script>
    <link href="https://unpkg.com/filepond@4.30.4/dist/filepond.css" rel="stylesheet">


    @if (Session::has('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: "Success",
                    text: "{{ session('success') }}",
                    imageUrl: "https://cdn-icons-png.flaticon.com/512/190/190411.png", // URL gambar checklist online
                    imageWidth: 100,
                    imageHeight: 100,
                    imageAlt: "Checklist icon",
                    draggable: true
                });
            });
        </script>
    @endif
    @if (Session::has('error'))
        <script>
            $(document).ready(function() {
                Swal.fire({
                    title: "Error!",
                    text: "{{ session('error') }}",
                    icon: "error",
                });
            });
        </script>
    @endif
    @stack('resource')
</head>

<body>

    <!-- Main navbar -->
    @include('Component.navbar')
    <!-- /main navbar -->


    <!-- Page content -->
    <div class="page-content">

        <!-- Main sidebar -->
        @include('Component.sidebar')
        <!-- /main sidebar -->


        <!-- Main content -->
        <div class="content-wrapper">

            <!-- Inner content -->
            <div class="content-inner">

                <!-- Page header -->
                <div class="page-header page-header-light shadow">
                    <div class="page-header-content d-lg-flex">
                        <div class="d-flex">
                            <h4 class="page-title mb-0">
                                Home - <span class="fw-normal">@yield('title')</span>
                            </h4>

                            <a href="#page_header"
                                class="btn btn-light align-self-center collapsed d-lg-none border-transparent rounded-pill p-0 ms-auto"
                                data-bs-toggle="collapse">
                                <i class="ph-caret-down collapsible-indicator ph-sm m-1"></i>
                            </a>
                        </div>

                        <div class="d-flex justify-content-between align-items-center my-lg-auto ms-lg-auto flex-wrap"
                            id="page_header">
                            <span id="tanggal" class="me-3"></span>

                            <form action="{{ route('news.language') }}" method="POST" id="language-form">
                                @csrf
                                <select name="language" class="form-select"
                                    onchange="document.getElementById('language-form').submit()"
                                    style="min-width: 120px;">
                                    @foreach ($languages as $language)
                                        <option value="{{ $language->code }}"
                                            {{ session('app_language', 'id') == $language->code ? 'selected' : '' }}>
                                            {{ $language->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </form>
                        </div>

                    </div>

                    <div class="page-header-content d-lg-flex border-top">
                        <div class="d-flex">
                            <div class="breadcrumb py-2">
                                <a href="index.html" class="breadcrumb-item">@yield('icon')</a>
                                <a href="#" class="breadcrumb-item">@yield('menu')</a>
                                <span class="breadcrumb-item active">@yield('title')</span>
                            </div>

                            <a href="#breadcrumb_elements"
                                class="btn btn-light align-self-center collapsed d-lg-none border-transparent rounded-pill p-0 ms-auto"
                                data-bs-toggle="collapse">
                                <i class="ph-caret-down collapsible-indicator ph-sm m-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <!-- /page header -->


                <!-- Content area -->
                <div class="content">

                    @yield('content')

                </div>
                <!-- /content area -->


                <!-- Footer -->
                @include('Component.footer')
                <!-- /footer -->

            </div>
            <!-- /inner content -->

        </div>
        <!-- /main content -->

    </div>
    <!-- /page content -->


    <!-- Notifications -->

    <!-- /notifications -->


    <!-- Demo config -->
    @include('Component.demo-config')
    <!-- /demo config -->

    <script>
        function updateTime() {
            const now = new Date();
            const timeString = now.toLocaleTimeString('id-ID', {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });
            const dateString = now.toLocaleDateString('id-ID', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
            document.getElementById("tanggal").textContent = dateString + " - " + timeString;
        }
        setInterval(updateTime, 1000);
        updateTime();
    </script>
    {{-- <script src="https://cdn.ckeditor.com/ckeditor5/45.0.0/ckeditor5.umd.js"></script> --}}
    {{-- <script src="https://cdn.ckeditor.com/ckeditor5/45.0.0/ckeditor5.umd.js" crossorigin></script>
    <script src="https://cdn.ckeditor.com/ckeditor5-premium-features/45.0.0/ckeditor5-premium-features.umd.js" crossorigin> --}}
    </script>
    {{-- <script src="https://cdn.ckbox.io/ckbox/2.6.1/ckbox.js" crossorigin></script> --}}

    {{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}

</body>

</html>
