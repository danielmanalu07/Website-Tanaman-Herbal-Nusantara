@extends('user.main')
@push('resource')
    <style>
        .social-icons {
            display: flex;
            justify-content: center;
            gap: 25px;
            margin-top: 20px;
        }

        .social-icons a {
            font-size: 3rem;
            color: #155e30;
            /* ganti sesuai tema */
            transition: all 0.3s ease;
        }

        .social-icons a:hover {
            color: #3bb77e;
            transform: scale(1.2);
        }

        .about-content p {
            font-size: 1.1rem;
            color: #555;
        }

        .btn.style1 {
            background-color: #155e30;
            color: #fff;
            padding: 10px 25px;
            border-radius: 50px;
            transition: 0.3s ease;
        }

        .btn.style1:hover {
            background-color: #3bb77e;
            color: #fff;
        }
    </style>
@endpush

@section('content')
    @php
        $recentHabitus = collect($habituses)->take(3);
    @endphp
    <!-- Hero section start -->
    <section class="hero-wrap style2 bg-narvik">
        <div class="container-fluid container-full">
            <img class="brick-shape-1" src="{{ asset('hort/assets/img/hero/brick-2.svg') }}" alt="Image">
            <img class="brick-shape-2" src="{{ asset('hort/assets/img/hero/brick-2.svg') }}" alt="Image">
            <div class="hero-slider-one">
                <div class="hero-slide-one">
                    <div class="row align-items-center">
                        <div class="col-xl-7 col-lg-6 col-md-12 col-12 order-xl-1 order-lg-1 order-md-2 order-2">
                            <div class="hero-content style2">
                                <span>{{ __('messages.Tanaman Herbal Nusantara') }}</span>
                                <h1>{{ __('messages.Taman Sains Teknologi Herbal & Hortikultura') }}</h1>
                                <p>{{ __('messages.Temukan Tanaman Herbal dan Hortikultura Favoritmu Sekarang dan Cari Tahu Manfaat Tanaman Lokal di Sekitarmu!') }}
                                </p>
                                <div class="hero-btn">
                                    <a href="#" class="btn style1"><i
                                            class="flaticon-book"></i>{{ __('messages.Profil') }}</a>
                                    <a href="{{ route('user.contact') }}" class="btn style2"><i
                                            class="flaticon-contact-book"></i>{{ __('messages.Kontak Kami') }}</a>
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
                            <h5>{{ __('messages.Jelajahi Tanaman Herbal') }}</h5>
                            <p>{{ __('messages.Akses lengkap ke tanaman herbal, manfaatnya, dan tips budidaya.') }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-6 col-md-6">
                    <div class="promo-item">
                        <div class="promo-icon">
                            <i class="flaticon-agriculture"></i>
                        </div>
                        <div class="promo-text">
                            <h5>{{ __('messages.Tips & Panduan Hortikultura') }}</h5>
                            <p>{{ __('messages.Pelajari praktik terbaik untuk menanam dan merawat kebun herbal.') }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-6 col-md-6">
                    <div class="promo-item">
                        <div class="promo-icon">
                            <i class="flaticon-growth"></i>
                        </div>
                        <div class="promo-text">
                            <h5>{{ __('messages.Temukan Pengobatan Herbal') }}</h5>
                            <p>{{ __('messages.Temukan penggunaan tanaman herbal secara tradisional dan modern untuk kesehatan dan kebugaran.') }}
                            </p>
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
            <div class="row justify-content-center align-items-center gx-5">
                <div class="col-xl-8 col-lg-10">
                    <div class="about-content text-center">
                        <div class="content-title">
                            <h2 class="d-block mb-2 text-success fw-semibold">{{ __('messages.Tentang Kami') }}</h2>
                            @foreach ($contents as $profile)
                                @if (Str::lower($profile->key) == 'sejarah')
                                    <p class="mb-4">{!! Str::limit(strip_tags(preg_replace('/<(img|iframe|video)[^>]*>/i', '', $profile->content)), 400, '...') !!}</p>

                                    <a href="{{ route('user.profile.detail', $profile->id) }}" class="btn style1"><i
                                            class="fi fi-rr-info"></i> {{ __('messages.Lihat Selengkapnya') }}</a>
                                @endif
                            @endforeach
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
                    <h2>{{ __('messages.Taman Kami') }}</h2>
                    <p>{{ __('messages.Temukan Tanaman Herbal dan Hortikultura Favoritmu Sekarang dan Cari Tahu Manfaat Tanaman Lokal di Sekitarmu!') }}
                    </p>
                </div>
            </div>
            <div class="row justify-content-center">
                @foreach ($recentHabitus as $habitus)
                    <div class="col-xl-4 col-lg-6 col-md-6">
                        <div class="service-card style2">
                            <div class="service-img" style="width: 100%; height: 200px; overflow: hidden;">
                                <img src="{{ $habitus->image }}" style="width: 100%; height: 100%; object-fit: cover;"
                                    alt="Image">
                            </div>
                            <div class="service-info">
                                <h3 class="service-title"><a href="service-details.html">{{ $habitus->name }}</a>
                                </h3>
                                {{-- <p class="service-desc">{!! Str::limit(
                                    strip_tags(preg_replace('/<(img|iframe|video)[^>]*>/i', '', $plant->advantage), '<b><strong><i><em><u><span>'),
                                    45,
                                    '...',
                                ) !!}
                                </p> --}}
                                <a href="{{ route('user.ourgarden.detail', $habitus->id) }}"
                                    class="link style2">{{ __('messages.Lihat Selengkapnya') }}
                                    <i class="flaticon-right-arrow"></i></a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="row mt-15">
                <div class="col-md-12">
                    <p class="subtitle">{{ __('messages.Jelajahi Taman Kami.') }}<a class="link style1"
                            href="{{ route('user.ourgarden') }}">{{ __('messages.Lihat Semua Taman') }}<i
                                class="flaticon-right-arrow"></i></a></p>
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
                        <p>{{ __('messages.Pengunjung') }}</p>
                        <h2><span class="odometer" data-count="{{ $visitorCount }}"></span></h2>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="counter-card style2 bg-link-ice">
                        <div class="counter-icon">
                            <i class="flaticon-growth-1"></i>
                        </div>
                        <p>{{ __('messages.Tanaman') }}</p>
                        <h2><span class="odometer" data-count="{{ $plantCount }}"></span></h2>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="counter-card style2 bg-vanila-ice">
                        <div class="counter-icon">
                            <i class="fi fi-rr-map"></i>
                        </div>
                        <p>{{ __('messages.Lahan') }}</p>
                        <h2><span class="odometer" data-count="{{ $landCount }}"></span></h2>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="counter-card style2 bg-ecru">
                        <div class="counter-icon">
                            <i class="flaticon-pencil"></i>
                        </div>
                        <p>{{ __('messages.Habitus') }}</p>
                        <h2><span class="odometer" data-count="{{ $habitusCount }}"></span></h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @php
        $news = collect($news)
            ->sortByDesc(function ($item) {
                return \Carbon\Carbon::parse($item->published);
            })
            ->take(3);
    @endphp
    <!-- Blog Section start -->
    <section class="blog-wrap pt-100 pb-75 bg-apple-green td-aztech">
        <div class="container">
            <div class="section-title style1 text-center mb-50">
                <h2>{{ __('messages.Berita Terbaru') }}</h2>
                <p>{{ __('messages.Ikuti terus kabar terbaru dari kami, informasi selengkapnya ada di sini!') }}</p>
            </div>
            <div class="row justify-content-center">
                @foreach ($news as $new)
                    @if ($new->status === true)
                        <div class="col-lg-4 col-md-6">
                            <div class="blog-card style2">
                                <a href="blog-details-left-sidebar.html" class="blog-img"
                                    style="width: 100%; height: 400px; overflow: hidden;">
                                    <img src="{{ $new->images[0]['image_path'] }}" alt="Image"
                                        style="width: 100%; height: 100%; object-fit: cover;">
                                </a>
                                <div class="blog-info">
                                    <ul class="blog-metainfo list-style">
                                        <li><a
                                                href="{{ route('user.news.detail', $new->id) }}">{{ \Carbon\Carbon::parse($new->published)->format('d F Y') }}</a>
                                        </li>

                                    </ul>
                                    <h3 class="blog-title"><a
                                            href="{{ route('user.news.detail', $new->id) }}">{{ Str::limit($new->title, 70) }}</a>
                                    </h3>
                                    <a href="{{ route('user.news.detail', $new->id) }}"
                                        class="link style2">{{ __('messages.Lihat Selengkapnya') }} <i
                                            class="flaticon-right-arrow"></i></a>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
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
                <h2>{{ __('messages.Kontak Kami') }}</h2>
                <p>{{ __('messages.Untuk informasi lebih lanjut, pertanyaan, atau kerja sama, silakan hubungi kami melalui platform media sosial berikut. Kami akan merespons secepat mungkin.') }}
                </p>

            </div>
            <div class="row">
                <div class="col-xl-8 offset-xl-2 col-lg-10 offset-lg-1">
                    <div class="social-icons">
                        <a target="_blank" href="https://facebook.com"><i class="lab la-facebook-f"></i></a>
                        <a target="_blank" href="https://twitter.com"><i class="lab la-twitter"></i></a>
                        <a target="_blank" href="https://linkedin.com"><i class="lab la-linkedin-in"></i></a>
                        <a target="_blank" href="https://instagram.com"><i class="lab la-instagram"></i></a>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <!-- Newsletter section end -->
@endsection
