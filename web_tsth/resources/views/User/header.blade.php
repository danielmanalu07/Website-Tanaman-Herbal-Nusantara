@push('resource')
    <style>
        .flag-icon {
            width: 30px;
            /* ukuran bisa kamu sesuaikan */
            height: 30px;
            /* supaya bulet */
            object-fit: cover;
            /* supaya gambar gak penyok */
            border-radius: 50%;
            /* ini yang bikin bulet */
            border: 1px solid #ddd;
            /* optional: kasih border tipis */
        }
    </style>
@endpush
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
                {{-- <div class="header-bottom-right xl-none">
                    <div class="select_lang">
                        <div class="navbar-option-item navbar-language language-option">
                            <form action="{{ route('user.language') }}" method="POST" id="language-form">
                                @csrf
                                <div class="d-flex align-items-center">
                                    <i class="las la-globe me-2"></i>
                                    <select name="language" class="form-select border-0 bg-transparent p-0"
                                        onchange="document.getElementById('language-form').submit()"
                                        style="min-width: 120px; background: transparent; box-shadow: none;">
                                        @foreach ($languages as $language)
                                            <option value="{{ $language->code }}"
                                                {{ session('app_language', 'id') == $language->code ? 'selected' : '' }}>
                                                {{ $language->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </form>
                        </div>
                    </div>
                </div> --}}
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
                                    <a href="{{ route('home') }}"
                                        class="{{ request()->routeIs('home') ? 'active' : '' }}">
                                        <i class="flaticon-home"></i>Beranda
                                    </a>
                                </li>
                                <li class="has-children">
                                    <a href="#" class="{{ request()->is('profile*') ? 'active' : '' }}">
                                        <i class="flaticon-book"></i>Profil
                                    </a>
                                    <ul class="sub-menu list-style">
                                        @foreach ($contents as $content)
                                            @if ($content->status === true)
                                                <li>
                                                    <a
                                                        href="{{ route('user.profile.detail', $content->id) }}">{{ $content->title }}</a>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </li>
                                <li class="children">
                                    <a href="{{ route('user.ourgarden') }}"
                                        class="{{ request()->routeIs('user.ourgarden') || request()->routeIs('user.ourgarden.detail') || request()->routeIs('user.ourgarden.plant.detail') ? 'active' : '' }}">
                                        <i class="fi fi-rr-hand-holding-seeding"></i>Taman Kami
                                    </a>
                                </li>
                                <li class="children">
                                    <a href="{{ route('news') }}"
                                        class="{{ request()->routeIs('news') || request()->routeIs('user.news.detail') ? 'active' : '' }}">
                                        <i class="flaticon-pencil"></i>Berita
                                    </a>
                                </li>
                                <li class="children">
                                    <a href="#" class="{{ request()->is('#') ? 'active' : '' }}">
                                        <i class="fi fi-rr-marker"></i>Peta Tanaman
                                    </a>
                                </li>
                                <li class="children">
                                    <a href="{{ route('user.contact') }}"
                                        class="{{ request()->routeIs('user.contact') ? 'active' : '' }}">
                                        <i class="flaticon-contact-book"></i>Kontak Kami
                                    </a>
                                </li>

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
                        <div class="select_lang">
                            <div class="navbar-option-item navbar-language language-option">
                                <form action="{{ route('user.language') }}" method="POST" id="language-form">
                                    @csrf
                                    <div class="d-flex align-items-center">
                                        <i class="las la-globe me-2"></i>
                                        <select name="language" class="form-select border-0 bg-transparent p-0"
                                            onchange="document.getElementById('language-form').submit()"
                                            style="min-width: 120px; background: transparent; box-shadow: none;">
                                            @foreach ($languages as $language)
                                                <option value="{{ $language->code }}"
                                                    {{ session('app_language', 'id') == $language->code ? 'selected' : '' }}>
                                                    {{ $language->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
