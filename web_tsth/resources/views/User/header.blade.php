<header class="header-wrap style2 bg-narvik">
    <div class="header-top">
        <div class="close-header-top xl-none">
            <button type="button"><i class="las la-times"></i></button>
        </div>
        <div class="container-fluid container-full">
            <div class="row align-items-center">
                <div class="col-xl-4 col-lg-12">
                    <div class="header-contact-item">
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="flaticon-phone-call"></i>
                            </div>
                            <div class="contact-text">
                                <a href="tel:8882222200">888-222-2200</a>
                            </div>
                        </div>
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="flaticon-mail"></i>
                            </div>
                            <div class="contact-text">
                                <a href="mailto:support@hort.com">support@hort.com</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-12 text-center lg-none">
                    <a href="index.html" class="logo">
                        <img class="logo-light" src="{{ asset('images/logoweb-removebg.png') }}" alt="Image">
                        <img class="logo-dark" src="{{ asset('images/logoweb-removebg.png') }}" alt="Image">
                    </a>
                </div>
                <div class="col-xl-4 col-lg-12 text-xl-end">
                    <ul class="social-profile style1 list-style">
                        <li><a target="_blank" href="https://facebook.com"><i class="lab la-facebook-f"></i>
                            </a></li>
                        <li><a target="_blank" href="https://twitter.com"> <i class="lab la-twitter"></i> </a>
                        </li>
                        <li><a target="_blank" href="https://linkedin.com"> <i class="lab la-linkedin-in"></i>
                            </a></li>
                        <li><a target="_blank" href="https://instagram.com"> <i class="lab la-instagram"></i>
                            </a></li>
                    </ul>
                </div>
                <div class="header-bottom-right xl-none">
                    <div class="select_lang me-3">
                        <div class="navbar-option-item navbar-language dropdown language-option">
                            <button class="dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <i class="las la-globe"></i>
                                <span class="lang-name"></span>
                            </button>
                            <div class="dropdown-menu language-dropdown-menu">
                                <a class="dropdown-item" href="#">
                                    <img src="{{ asset('hort/assets/img/uk.png') }}" alt="flag">
                                    Eng
                                </a>
                                <a class="dropdown-item" href="#">
                                    <img src="{{ asset('images/indonesia.jpg') }}" alt="flag">
                                    ID
                                </a>
                            </div>
                        </div>
                    </div>
                    {{-- <a href="quote.html" class="btn style1"><i class="flaticon-right-arrow"></i> Request A
                        Quote</a> --}}
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid container-full">
        <div class="header-bottom">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-6 col-6 xl-none">
                    <a href="index.html" class="logo">
                        <img class="logo-light" src="{{ asset('images/logoweb-removebg.png') }}" alt="Image">
                        <img class="logo-dark" src="{{ asset('images/logoweb-removebg.png') }}" alt="Image">
                    </a>
                </div>
                <div class="col-xl-8 col-lg-6 col-md-6 col-6 ">
                    <div class="main-menu-wrap style2">
                        <div class="menu-close xl-none">
                            <a href="javascript:void(0)"><i class="las la-times"></i></a>
                        </div>
                        <div id="menu">
                            <ul class="main-menu list-style">
                                <li class="children">
                                    <a class="active" href="#"><i class="flaticon-home"></i>Home</a>
                                </li>
                                <li class="children">
                                    <a href="#"><i class="fi fi-rr-info"></i>About Us</a>
                                </li>
                                <li class="children">
                                    <a href="#"><i class="fi fi-rr-hand-holding-seeding"></i>Our Garden</a>
                                </li>
                                <li class="children">
                                    <a href="#"><i class="flaticon-pencil"></i>News</a>
                                </li>
                                <li class="has-children">
                                    <a href="#"><i class="flaticon-book"></i>Profile</a>
                                    <ul class="sub-menu list-style">
                                        <li>
                                            <a href="#">Visi Misi</a>
                                        </li>
                                        <li>
                                            <a href="#">Sejarah</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="children">
                                    <a href="#"><i class="flaticon-contact-book"></i>Contact Us</a>
                                </li>
                                {{-- <li class="has-children">
                                    <a href="#"><i class="flaticon-image"></i>Projects</a>
                                    <ul class="sub-menu list-style">
                                        <li>
                                            <a href="projects.html">Our Project</a>
                                        </li>
                                        <li>
                                            <a href="project-details.html">Single Project</a>
                                        </li>
                                        <li><a href="gallery.html">Gallery</a></li>
                                    </ul>
                                </li>
                                <li class="has-children">
                                    <a href="#"> <i class="flaticon-page"></i>Pages</a>
                                    <ul class="sub-menu list-style">
                                        <li><a href="about.html">About Us</a></li>
                                        <li><a href="contact.html">Contact</a></li>
                                        <li class="has-children">
                                            <a href="#">Shop</a>
                                            <ul class="sub-menu list-style">
                                                <li>
                                                    <a href="shop-left-sidebar.html">Shop Left Sidebar</a>
                                                </li>
                                                <li>
                                                    <a href="shop-right-sidebar.html">Shop Right Sidebar</a>
                                                </li>
                                                <li>
                                                    <a href="shop-No-sidebar.html">Shop No Sidebar</a>
                                                </li>
                                                <li>
                                                    <a href="shop-details.html">Shop Single</a>
                                                </li>
                                                <li>
                                                    <a href="cart.html">Cart</a>
                                                </li>
                                                <li>
                                                    <a href="wishlist.html">Wishlist</a>
                                                </li>
                                                <li>
                                                    <a href="checkout.html">Checkout</a>
                                                </li>
                                                <li><a href="login.html">Login</a></li>
                                                <li><a href="register.html">Register</a></li>
                                                <li><a href="my-account.html">My Account</a></li>
                                                <li><a href="forgot-pwd.html">Forgot Password</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="quote.html">Request A Quote</a></li>
                                        <li><a href="faq.html">FAQ</a></li>
                                        <li>
                                            <a href="privacy-policy.html">Privacy Policy</a>
                                        </li>
                                        <li>
                                            <a href="terms-condition.html">Terms &AMP; Conditions</a>
                                        </li>
                                        <li><a href="404.html">404</a></li>
                                    </ul>
                                </li>
                                <li class="has-children">
                                    <a href="#"><i class="flaticon-pencil"></i>News</a>
                                    <ul class="sub-menu list-style">
                                        <li class="has-children">
                                            <a href="#">Blog Layout</a>
                                            <ul class="sub-menu list-style">
                                                <li>
                                                    <a href="blog-left-sidebar.html">Blog Left Sidebar</a>
                                                </li>
                                                <li>
                                                    <a href="blog-right-sidebar.html">Blog Right Sidebar</a>
                                                </li>
                                                <li>
                                                    <a href="blog-no-sidebar.html">Blog No Sidebar</a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="has-children">
                                            <a href="#">Single Blog</a>
                                            <ul class="sub-menu list-style">
                                                <li>
                                                    <a href="blog-details-left-sidebar.html">Single Blog Left
                                                        Sidebar</a>
                                                </li>
                                                <li>
                                                    <a href="blog-details-right-sidebar.html">Single Blog Right
                                                        Sidebar</a>
                                                </li>
                                                <li>
                                                    <a href="blog-details-no-sidebar.html">Single Blog No
                                                        Sidebar</a>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li> --}}
                            </ul>
                        </div>
                    </div>
                    <div class="mobile-bar-wrap">
                        <div class="mobile-top-bar xl-none">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                        <div class="mobile-menu xl-none">
                            <a href="javascript:void(0)"><i class="las la-bars"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 lg-none">
                    <div class="header-bottom-right">
                        <div class="select_lang me-3">
                            <div class="navbar-option-item navbar-language dropdown language-option">
                                <button class="dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    <i class="las la-globe"></i>
                                    <span class="lang-name"></span>
                                </button>
                                <div class="dropdown-menu language-dropdown-menu">
                                    <a class="dropdown-item" href="#">
                                        <img src="{{ asset('hort/assets/img/uk.png') }}" alt="flag">
                                        Eng
                                    </a>
                                    <a class="dropdown-item" href="#">
                                        <img src="{{ asset('images/indonesia.jpg') }}" alt="flag">
                                        ID
                                    </a>
                                </div>
                            </div>
                        </div>
                        {{-- <a href="quote.html" class="btn style1"><i class="flaticon-right-arrow"></i> Request
                            A Quote</a> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
