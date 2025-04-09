<!DOCTYPE html>
<html lang="zxx">

<head>
    <!--====== Required meta tags ======-->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!--====== Title ======-->
    <title>Hort - Garden Landscaper Bootstrap 5 Template</title>
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


</head>

<body>
    <!--Preloader starts-->
    <div class="preloader js-preloader">
        <img src="{{ asset('hort/assets/img/preloader.gif') }}" alt="Image">
    </div>
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

        <!-- Hero section start -->
        <section class="hero-wrap style2 bg-narvik">
            <div class="container-fluid container-full">
                <img class="brick-shape-1" src="{{ asset('hort/assets/img/hero/brick-2.svg') }}" alt="Image">
                <img class="brick-shape-2" src="{{ asset('hort/assets/img/hero/brick-2.svg') }}" alt="Image">
                {{-- <div class="gd-cat one">
                    <img src="{{ asset('hort/assets/img/hero/pin.svg') }}" alt="Image" class="pin">
                    <img class="gd-cat-img" src="{{ asset('hort/assets/img/hero/gloves.svg') }}" alt="Image">
                    <span>Garden Setup</span>
                </div>
                <div class="gd-cat two">
                    <img src="{{ asset('hort/assets/img/hero/pin.svg') }}" alt="Image" class="pin">
                    <img class="gd-cat-img" src="{{ asset('hort/assets/img/hero/flower-tub.svg') }}" alt="Image">
                    <span>Plants Planted</span>
                </div>
                <div class="gd-cat three">
                    <img src="{{ asset('hort/assets/img/hero/pin.svg') }}" alt="Image" class="pin">
                    <img class="gd-cat-img" src="{{ asset('hort/assets/img/hero/water-pot.svg') }}" alt="Image">
                    <span>Gardening</span>
                </div>
                <div class="gd-cat four">
                    <img src="{{ asset('hort/assets/img/hero/pin.svg') }}" alt="Image" class="pin">
                    <img class="gd-cat-img" src="{{ asset('hort/assets/img/hero/tools-1.svg') }}" alt="Image">
                    <span>Maintenance</span>
                </div> --}}
                <div class="hero-slider-one">
                    <div class="hero-slide-one">
                        <div class="row align-items-center">
                            <div class="col-xl-7 col-lg-6 col-md-12 col-12 order-xl-1 order-lg-1 order-md-2 order-2">
                                <div class="hero-content style2">
                                    <span>Tanaman Herbal Nusantara</span>
                                    <h1>Taman Sains Teknologi Herbal & Hortikultura</h1>
                                    <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod
                                        tempor invidunt ut labore et dolore magna aliquyam erat, sed diam Voluptua.</p>
                                    <div class="hero-btn">
                                        <a href="about.html" class="btn style1"><i class="flaticon-book"></i>Profile</a>
                                        <a href="about.html" class="btn style2"><i
                                                class="flaticon-contact-book"></i>Contact Us</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-5 col-lg-6 col-md-12 col-12 order-xl-2 order-lg-2 order-md-1 order-1">
                                <div class="hero-img">
                                    <img src="{{ asset('images/image1.jpg') }}" alt="Image" class="brick-shape-3">
                                    <img src="{{ asset('images/image1.jpg') }}" alt="Image">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Hero section end -->

        <!-- Promo section start -->
        <div class="promo-wrap style2">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-4 col-lg-6 col-md-6">
                        <div class="promo-item">
                            <div class="promo-icon">
                                <i class="flaticon-gardening"></i>
                            </div>
                            <div class="promo-text">
                                <h5><a href="services.html">Variation Gardening</a></h5>
                                <p>Lorem ipsum dolor sit amet, consetetur sadip scing elitr, sed diam nonumy eirmod.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-6">
                        <div class="promo-item">
                            <div class="promo-icon">
                                <i class="flaticon-agriculture"></i>
                            </div>
                            <div class="promo-text">
                                <h5><a href="services.html">Get The Best Garden Designer</a></h5>
                                <p>Lorem ipsum dolor sit amet, consetetur sadip scing elitr, sed diam nonumy eirmod.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-6">
                        <div class="promo-item">
                            <div class="promo-icon">
                                <i class="flaticon-growth"></i>
                            </div>
                            <div class="promo-text">
                                <h5><a href="services.html">Design And 3D Model</a></h5>
                                <p>Lorem ipsum dolor sit amet, consetetur sadip scing elitr, sed diam nonumy eirmod.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Promo section end -->

        <!-- About Section start -->
        <section class="about-wrap style2 ptb-100">
            <div class="container">
                <div class="row gx-5">
                    <div class="col-xl-6">
                        <div class="about-img-wrap">
                            <div class="about-bg-five bg-f about-bg-4">
                                <img src="{{ asset('images/image2.jpg') }}" style="min-height: 100%; width: 100%;"
                                    alt="images">
                            </div>
                            {{-- <div class="about-cat">
                                <i class="flaticon-house"></i>
                                <span>Home Garden Setup</span>
                            </div> --}}
                            <img src="{{ asset('images/image1.jpg') }}" alt="Image" class="ab-img-5">
                            <img src="{{ asset('images/image2.jpg') }}" alt="Image" class="ab-img-6">
                            {{-- <div class="exp-text"><span>14</span>
                                Years Work Experience
                            </div> --}}
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="about-content">
                            <div class="content-title">
                                <span>About Us</span>
                                <h2>We Created &amp; Managed
                                    Gardens Around USA</h2>
                                <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod
                                    tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero
                                    eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea
                                    takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet.</p>
                                <a href="about.html" class="btn style1"><i class="fi fi-rr-info"></i>Read More</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- About Section end -->

        <!-- Service Section start -->
        <section class="service-wrap ptb-100 bg-apple-green">
            <div class="container">
                <div class="row">
                    <div class="section-title text-center mb-50">
                        <h2>Our Garden</h2>
                        <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod
                            tempor invidunt ut labore et dolore magna aliquyam erat, </p>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-xl-4 col-lg-6 col-md-6">
                        <div class="service-card style2">
                            <div class="service-img">
                                <div class="service-icon">
                                    <i class="flaticon-house"></i>
                                </div>
                                <img src="{{ asset('images/image1.jpg') }}" alt="Image">
                            </div>
                            <div class="service-info">
                                <h3 class="service-title"><a href="service-details.html">Commercial Gardens</a></h3>
                                <p class="service-desc">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed
                                    diam nonumy eirmod tempor</p>
                                <a href="service-details.html" class="link style2">Read More <i
                                        class="flaticon-right-arrow"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-6">
                        <div class="service-card style2">
                            <div class="service-img">
                                <div class="service-icon">
                                    <i class="flaticon-farming"></i>
                                </div>
                                <img src="{{ asset('images/image1.jpg') }}" alt="Image">
                            </div>
                            <div class="service-info">
                                <h3 class="service-title"><a href="service-details.html">Contemporary Gardens</a></h3>
                                <p class="service-desc">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed
                                    diam nonumy eirmod tempor</p>
                                <a href="service-details.html" class="link style2">Read More <i
                                        class="flaticon-right-arrow"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-6">
                        <div class="service-card style2">
                            <div class="service-img">
                                <div class="service-icon">
                                    <i class="flaticon-gardening-1"></i>
                                </div>
                                <img src="{{ asset('images/image1.jpg') }}" alt="Image">
                            </div>
                            <div class="service-info">
                                <h3 class="service-title"><a href="service-details.html">Small Garden Setup</a></h3>
                                <p class="service-desc">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed
                                    diam nonumy eirmod tempor</p>
                                <a href="service-details.html" class="link style2">Read More <i
                                        class="flaticon-right-arrow"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-15">
                    <div class="col-md-12">
                        <p class="subtitle">Explore Our Garden.<a class="link style1" href="services.html">View
                                All Garden <i class="flaticon-right-arrow"></i></a></p>
                    </div>
                </div>
            </div>
        </section>
        <!-- Service Section end -->

        <!-- Counter section start -->
        <div class="counter-wrap pt-100 pb-75">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="counter-card style2 bg-peppermint-dark">
                            <div class="counter-icon">
                                <i class="flaticon-rating-1"></i>
                            </div>
                            <p>Visitors</p>
                            <h2><span class="odometer" data-count="300">00</span>+</h2>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="counter-card style2 bg-link-ice">
                            <div class="counter-icon">
                                <i class="flaticon-growth-1"></i>
                            </div>
                            <p>Plants</p>
                            <h2><span class="odometer" data-count="1500">00</span>+</h2>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="counter-card style2 bg-vanila-ice">
                            <div class="counter-icon">
                                <i class="fi fi-rr-map"></i>
                            </div>
                            <p>Lands</p>
                            <h2><span class="odometer" data-count="203">00</span>+</h2>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="counter-card style2  bg-ecru ">
                            <div class="counter-icon">
                                <i class="flaticon-pencil"></i>
                            </div>
                            <p>News</p>
                            <h2><span class="odometer" data-count="40">00</span>+</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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

        <!-- Blog Section start -->
        <section class="blog-wrap pt-100 pb-75 bg-apple-green td-aztech">
            <div class="container">
                <div class="section-title style1 text-center mb-50">
                    <h2>News</h2>
                    <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod
                        tempor invidunt ut labore et dolore magna aliquyam erat, </p>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-4 col-md-6">
                        <div class="blog-card style2">
                            <a href="blog-details-left-sidebar.html" class="blog-img">
                                <img src="{{ asset('images/image1.jpg') }}" alt="Image">
                            </a>
                            <div class="blog-info">
                                <ul class="blog-metainfo list-style">
                                    <li><a href="blog-left-sidebar.html">31 Mar 2024</a></li>
                                    <li><a href="blog-left-sidebar.html">By Andrew P. Mason</a></li>
                                </ul>
                                <h3 class="blog-title"><a href="blog-details-left-sidebar.html">Everything You Need To
                                        Know For Your Home Garden Setup</a></h3>
                                <a href="blog-details-left-sidebar.html" class="link style2">Read More <i
                                        class="flaticon-right-arrow"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="blog-card style2">
                            <a href="blog-details-left-sidebar.html" class="blog-img">
                                <img src="{{ asset('images/image1.jpg') }}" alt="Image">
                            </a>
                            <div class="blog-info">
                                <ul class="blog-metainfo list-style">
                                    <li><a href="blog-left-sidebar.html">15 Mar 2024</a></li>
                                    <li><a href="blog-left-sidebar.html">By Andrew Phil</a></li>
                                </ul>
                                <h3 class="blog-title"><a href="blog-details-left-sidebar.html">How To Take proper
                                        Nurtcher Of Your Home Garden Plants</a></h3>
                                <a href="blog-details-left-sidebar.html" class="link style2">Read More <i
                                        class="flaticon-right-arrow"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="blog-card style2">
                            <a href="blog-details-left-sidebar.html" class="blog-img">
                                <img src="{{ asset('images/image1.jpg') }}" alt="Image">
                            </a>
                            <div class="blog-info">
                                <ul class="blog-metainfo list-style">
                                    <li><a href="blog-left-sidebar.html">12 Jan 2024</a></li>
                                    <li><a href="blog-left-sidebar.html">By Tony Stark</a></li>
                                </ul>
                                <h3 class="blog-title"><a href="blog-details-left-sidebar.html">A Step-By-Step
                                        Guideline For Home Garden Installation</a></h3>
                                <a href="blog-details-left-sidebar.html" class="link style2">Read More <i
                                        class="flaticon-right-arrow"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Blog Section end -->

        <!-- Newsletter section start -->
        <section class="newsletter-wrap style2 ptb-100">
            <img class="nl-shape-1" src="{{ asset('hort/assets/img/brick-2.png') }}" alt="Image">
            <img class="nl-shape-2" src="{{ asset('hort/assets/img/brick.svg') }}" alt="Image">
            <div class="container">
                <div class="section-title style1 text-center mb-50">
                    <h2>Get In Touch</h2>
                    <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod
                        tempor invidunt ut labore et dolore magna aliquyam erat, </p>
                </div>
                <div class="row">
                    <div class="col-xl-8 offset-xl-2 col-lg-10 offset-lg-1">
                        <form action="#" class="newsletter-form">
                            <div class="form-group">
                                <input type="email" placeholder="Please Enter Your Email Address">
                                <button type="submit"> <i class="flaticon-right-arrow"></i> Get Subscribe
                                    Now</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        <!-- Newsletter section end -->

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
</body>

</html>
