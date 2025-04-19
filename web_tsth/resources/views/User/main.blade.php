<!DOCTYPE html>
<html lang="zxx">

<head>
    <!--====== Required meta tags ======-->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!--====== Title ======-->
    <title>Taman Sains Teknologi Herbal dan Hortikultura </title>
    <!--====== Favicon Icon ======-->
    <link rel="shortcut icon" href="{{ asset('hort/assets/img/favicon.png') }}" type="image/png">
    <!--====== Bootstrap css ======-->
    <link href="{{ asset('hort/assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <!--====== icon css ======-->
    <link href="{{ asset('hort/assets/css/line-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('hort/assets/css/flaticon.css') }}" rel="stylesheet">
    <!--====== Swiper css ======-->
    <link href="{{ asset('hort/assets/css/swiper-bundle.min.css') }}" rel="stylesheet">
    <!--====== Animate css ======-->
    <link href="{{ asset('hort/assets/css/animate.min.css') }}" rel="stylesheet">
    <!--====== Odometre css ======-->
    <link href="{{ asset('hort/assets/css/odometer.css') }}" rel="stylesheet">
    <!--====== Style css ======-->
    <link href="{{ asset('hort/assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('hort/assets/css/dark-theme.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn-uicons.flaticon.com/uicons-regular-rounded/css/uicons-regular-rounded.css">

    <!-- CSS SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <!-- JS SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css">

    @if (Session::has('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: "Welcome Back!",
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
    <!--Preloader starts-->
    {{-- <div class="preloader js-preloader">
        <img src="{{ asset('hort/assets/img/preloader.gif') }}" alt="Image">
    </div> --}}
    <!--Preloader ends-->

    <!-- Theme Switcher Start -->
    <div class="switch-theme-mode">
        <label id="switch" class="switch">
            <input type="checkbox" onchange="toggleTheme()" id="slider">
            <span class="slider round"></span>
        </label>
    </div>
    <!-- Theme Switcher End -->

    <!-- page wrapper Start -->
    <div class="page-wrapper ">

        <!-- Header  Start -->
        @include('user.header')
        <!-- Header  end -->


        @yield('content')

        <!-- Counter section end -->

        <!-- Why choose us section start -->
        {{-- <section class="why-choose-wrap style2 ptb-100 bg-vista-white">
            <img src="assets/img/leaf-6.png" alt="Image" class="leaf-6 lg-none">
            <div class="container">
                <div class="row">
                    <div class="container">
                        <div class="row gx-5">
                            <div class="col-xl-5">
                                <div class="content-title mb-20">
                                    <h2>Why Choose Us</h2>
                                    <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod
                                        tempor invidunt ut labore.</p>
                                </div>
                                <div class="wh-item-wrap">
                                    <div class="wh-item">
                                        <div class="wh-icon">
                                            <i class="flaticon-watering-plants"></i>
                                        </div>
                                        <div class="wh-text">
                                            <h5><a href="about.html">Getting The Best Garden Designers</a></h5>
                                            <p>Lorem ipsum dolor sit amet, sconsetetur sadipscing elitr, sed diam
                                                nonumy eirmod </p>
                                        </div>
                                    </div>
                                    <div class="wh-item">
                                        <div class="wh-icon">
                                            <i class="flaticon-watering-plants"></i>
                                        </div>
                                        <div class="wh-text">
                                            <h5><a href="about.html">24/7 Customer Support</a></h5>
                                            <p>Lorem ipsum dolor sit amet, sconsetetur sadipscing elitr, sed diam
                                                nonumy eirmod </p>
                                        </div>
                                    </div>
                                    <div class="wh-item">
                                        <div class="wh-icon">
                                            <i class="flaticon-agriculture"></i>
                                        </div>
                                        <div class="wh-text">
                                            <h5><a href="about.html">Design And 3D Model</a></h5>
                                            <p>Lorem ipsum dolor sit amet, sconsetetur sadipscing elitr, sed diam
                                                nonumy eirmod</p>
                                        </div>
                                    </div>
                                    <div class="wh-item">
                                        <div class="wh-icon">
                                            <i class="flaticon-growth"></i>
                                        </div>
                                        <div class="wh-text">
                                            <h5><a href="about.html">Commercial Gardening Design</a></h5>
                                            <p>Lorem ipsum dolor sit amet, sconsetetur sadipscing elitr, sed diam
                                                nonumy eirmod</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-7">
                                <div class="wh-img-slider swiper-container">
                                    <div class="swiper-wrapper">
                                        <div class="swiper-slide">
                                            <div class="wh-img-item bg-f wh-bg-3"></div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div class="wh-img-item bg-f wh-bg-4"></div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div class="wh-img-item bg-f wh-bg-5"></div>
                                        </div>
                                    </div>
                                    <div class="wh-slider-nav">
                                        <div class="swiper-pagination"></div>
                                        <div class="wh-btn-wrp">
                                            <div class="wh-img-prev slider-btn style1"><i
                                                    class="flaticon-left-arrow-2"></i></div>
                                            <div class="wh-img-next slider-btn style1"><i
                                                    class="flaticon-right-arrow-1"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section> --}}
        <!-- Why choose us section end -->

        <!-- Testimonial section start -->
        {{-- <section class="testimonial-wrap style3 ptb-100">
            <div class="container">
                <div class="section-title style1 text-center mb-10">
                    <h2>What Our Customer Says
                        About Our Services</h2>
                    <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor
                        invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.</p>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="testimonial-slider-two swiper-container">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <div class="testimonial-slider-item style2">
                                        <div class="client-quote">
                                            <p>"Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy
                                                eirm od tempor invidunt ut sadipscing elitr, sed diam nonumy eirm od
                                                tempor invidunt ut Lorem ipsum dolor sit"</p>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="client-info-wrap">
                                                    <div class="client-img">
                                                        <img src="assets/img/testimonials/client-1.jpg"
                                                            alt="Image">
                                                    </div>
                                                    <div class="client-info">
                                                        <h5>Bianca A. Wells</h5>
                                                        <span>CEO, Arttree</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="testimonial-slider-item style2">
                                        <div class="client-quote">
                                            <p>"Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy
                                                eirm od tempor invidunt ut sadipscing elitr, sed diam nonumy eirm od
                                                tempor invidunt ut Lorem ipsum dolor sit"</p>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="client-info-wrap">
                                                    <div class="client-img">
                                                        <img src="assets/img/testimonials/client-2.jpg"
                                                            alt="Image">
                                                    </div>
                                                    <div class="client-info">
                                                        <h5>Holly J. Knight</h5>
                                                        <span>MD, Mackins</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="testimonial-slider-item style2">
                                        <div class="client-quote">
                                            <p>"Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy
                                                eirm od tempor invidunt ut sadipscing elitr, sed diam nonumy eirm od
                                                tempor invidunt ut Lorem ipsum dolor sit"</p>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="client-info-wrap">
                                                    <div class="client-img">
                                                        <img src="assets/img/testimonials/client-3.jpg"
                                                            alt="Image">
                                                    </div>
                                                    <div class="client-info">
                                                        <h5>April a. Morales</h5>
                                                        <span>Doctor, ADL</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="testimonial-two-pagination slider-pagination style1"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section> --}}
        <!-- Testimonial section end -->

        <!-- Gallery Section start -->
        {{-- <section class="gallery-wrap pt-100 pb-75 bg-apple-green td-aztech">
            <div class="container">
                <div class="section-title style1 text-center mb-50">
                    <h2>Our Gallery</h2>
                    <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod
                        tempor invidunt ut labore et dolore magna aliquyam erat, </p>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <ul class="nav nav-tabs gallery-tablist" role="tablist">
                            <li class="nav-item">
                                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab_1"
                                    type="button" role="tab">All</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link " data-bs-toggle="tab" data-bs-target="#tab_2"
                                    type="button" role="tab">Gardening</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link " data-bs-toggle="tab" data-bs-target="#tab_3"
                                    type="button" role="tab">Planting</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link " data-bs-toggle="tab" data-bs-target="#tab_4"
                                    type="button" role="tab">Maintenance</button>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="tab-content gallery-tab-content">
                    <div class="tab-pane fade show active" id="tab_1" role="tabpanel">
                        <div class="row  justify-content-center">
                            <div class="col-xl-6 col-lg-12">
                                <div class="gallery-item style3 bg-f gallery-bg-7">
                                    <div class="gallery-info">
                                        <div>
                                            <h5><a href="project-details.html">Home Garden</a></h5>
                                            <span>South Dakota</span>
                                        </div>
                                        <a class="gal_btn" href="project-details.html"><i
                                                class="flaticon-right-arrow-1"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-12">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="gallery-item style4 bg-f gallery-bg-8">
                                            <div class="gallery-info">
                                                <div>
                                                    <h5><a href="project-details.html">Maintenance</a></h5>
                                                    <span>New York</span>
                                                </div>
                                                <a class="gal_btn" href="project-details.html"><i
                                                        class="flaticon-right-arrow-1"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="gallery-item style4 bg-f gallery-bg-9">
                                            <div class="gallery-info">
                                                <div>
                                                    <h5><a href="project-details.html">Design & Planting</a></h5>
                                                    <span>Florida</span>
                                                </div>
                                                <a class="gal_btn" href="project-details.html"><i
                                                        class="flaticon-right-arrow-1"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="gallery-item style4 bg-f gallery-bg-10">
                                            <div class="gallery-info">
                                                <div>
                                                    <h5><a href="project-details.html">Indoor Scaping</a></h5>
                                                    <span>South Dakota</span>
                                                </div>
                                                <a class="gal_btn" href="project-details.html"><i
                                                        class="flaticon-right-arrow-1"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-6">
                                <div class="gallery-item style4 bg-f gallery-bg-11">
                                    <div class="gallery-info">
                                        <div>
                                            <h5><a href="project-details.html">Commercial Garden</a></h5>
                                            <span>California</span>
                                        </div>
                                        <a class="gal_btn" href="project-details.html"><i
                                                class="flaticon-right-arrow-1"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-6">
                                <div class="gallery-item style4 bg-f gallery-bg-12">
                                    <div class="gallery-info">
                                        <div>
                                            <h5><a href="project-details.html">Home Garden</a></h5>
                                            <span>South Dakota</span>
                                        </div>
                                        <a class="gal_btn" href="project-details.html"><i
                                                class="flaticon-right-arrow-1"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-12">
                                <div class="gallery-item style4 bg-f gallery-bg-13">
                                    <div class="gallery-info">
                                        <div>
                                            <h5><a href="project-details.html">Outdoor Scaping</a></h5>
                                            <span>Agortia</span>
                                        </div>
                                        <a class="gal_btn" href="project-details.html"><i
                                                class="flaticon-right-arrow-1"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="tab_2" role="tabpanel">
                        <div class="row justify-content-center">
                            <div class="col-xl-3 col-lg-6">
                                <div class="gallery-item style4 bg-f gallery-bg-11">
                                    <div class="gallery-info">
                                        <div>
                                            <h5><a href="project-details.html">Commercial Garden</a></h5>
                                            <span>California</span>
                                        </div>
                                        <a class="gal_btn" href="project-details.html"><i
                                                class="flaticon-right-arrow-1"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-6">
                                <div class="gallery-item style4 bg-f gallery-bg-12">
                                    <div class="gallery-info">
                                        <div>
                                            <h5><a href="project-details.html">Home Garden</a></h5>
                                            <span>South Dakota</span>
                                        </div>
                                        <a class="gal_btn" href="project-details.html"><i
                                                class="flaticon-right-arrow-1"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-12">
                                <div class="gallery-item style4 bg-f gallery-bg-13">
                                    <div class="gallery-info">
                                        <div>
                                            <h5><a href="project-details.html">Outdoor Scaping</a></h5>
                                            <span>Agortia</span>
                                        </div>
                                        <a class="gal_btn" href="project-details.html"><i
                                                class="flaticon-right-arrow-1"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="tab_3" role="tabpanel">
                        <div class="row  justify-content-center">
                            <div class="col-xl-6 col-lg-12">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="gallery-item style4 bg-f gallery-bg-8">
                                            <div class="gallery-info">
                                                <div>
                                                    <h5><a href="project-details.html">Maintenance</a></h5>
                                                    <span>New York</span>
                                                </div>
                                                <a class="gal_btn" href="project-details.html"><i
                                                        class="flaticon-right-arrow-1"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="gallery-item style4 bg-f gallery-bg-9">
                                            <div class="gallery-info">
                                                <div>
                                                    <h5><a href="project-details.html">Design & Planting</a></h5>
                                                    <span>Florida</span>
                                                </div>
                                                <a class="gal_btn" href="project-details.html"><i
                                                        class="flaticon-right-arrow-1"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="gallery-item style4 bg-f gallery-bg-10">
                                            <div class="gallery-info">
                                                <div>
                                                    <h5><a href="project-details.html">Indoor Scaping</a></h5>
                                                    <span>South Dakota</span>
                                                </div>
                                                <a class="gal_btn" href="project-details.html"><i
                                                        class="flaticon-right-arrow-1"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-12">
                                <div class="gallery-item style3 bg-f gallery-bg-7">
                                    <div class="gallery-info">
                                        <div>
                                            <h5><a href="project-details.html">Home Garden</a></h5>
                                            <span>South Dakota</span>
                                        </div>
                                        <a class="gal_btn" href="project-details.html"><i
                                                class="flaticon-right-arrow-1"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="tab_4" role="tabpanel">
                        <div class="row  justify-content-center">
                            <div class="col-xxl-3 col-xl-6 col-lg-6">
                                <div class="gallery-item style4 bg-f gallery-bg-9">
                                    <div class="gallery-info">
                                        <div>
                                            <h5><a href="project-details.html">Design & Planting</a></h5>
                                            <span>Florida</span>
                                        </div>
                                        <a class="gal_btn" href="project-details.html"><i
                                                class="flaticon-right-arrow-1"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xxl-3 col-xl-6 col-lg-6">
                                <div class="gallery-item style4 bg-f gallery-bg-10">
                                    <div class="gallery-info">
                                        <div>
                                            <h5><a href="project-details.html">Indoor Scaping</a></h5>
                                            <span>South Dakota</span>
                                        </div>
                                        <a class="gal_btn" href="project-details.html"><i
                                                class="flaticon-right-arrow-1"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xxl-3 col-xl-6 col-lg-6">
                                <div class="gallery-item style4 bg-f gallery-bg-11">
                                    <div class="gallery-info">
                                        <div>
                                            <h5><a href="project-details.html">Commercial Garden</a></h5>
                                            <span>California</span>
                                        </div>
                                        <a class="gal_btn" href="project-details.html"><i
                                                class="flaticon-right-arrow-1"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xxl-3 col-xl-6 col-lg-6">
                                <div class="gallery-item style4 bg-f gallery-bg-12">
                                    <div class="gallery-info">
                                        <div>
                                            <h5><a href="project-details.html">Home Garden</a></h5>
                                            <span>South Dakota</span>
                                        </div>
                                        <a class="gal_btn" href="project-details.html"><i
                                                class="flaticon-right-arrow-1"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section> --}}
        <!-- Gallery Section end -->

        <!-- Footer  start -->
        @include('user.footer')
        <!-- Footer  end -->

    </div>
    <!-- Page wrapper end -->

    <!-- Back-to-top button start -->
    <a href="javascript:void(0)" class="back-to-top bounce"><i class="las la-arrow-up"></i></a>
    <!-- Back-to-top button end -->

    <!--====== jquery js ======-->
    <script src="{{ asset('hort/assets/js/jquery.min.js') }}"></script>
    <!--====== Bootstrap js ======-->
    <script src="{{ asset('hort/assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('hort/assets/js/bootstrap-validator.js') }}"></script>
    <script src="{{ asset('hort/assets/js/form-validation.js') }}"></script>
    <!--====== Swiper js ======-->
    <script src="{{ asset('hort/assets/js/swiper-bundle.min.js') }}"></script>
    <!--====== Appear js ======-->
    <script src="{{ asset('hort/assets/js/jquery.appear.js') }}"></script>
    <!--====== Odometer js ======-->
    <script src="{{ asset('hort/assets/js/odometer.min.js') }}"></script>
    <!--====== Fslightbox js ======-->
    <script src="{{ asset('hort/assets/js/fslightbox.js') }}"></script>
    <!--====== Main js ======-->
    <script src="{{ asset('hort/assets/js/main.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>

</body>

</html>
