@extends('user.main')
@push('resource')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            let timer;
            const $searchInput = $('#news-search');
            const $results = $('#search-results');

            $searchInput.on('keyup', function() {
                clearTimeout(timer);
                let query = $(this).val();

                timer = setTimeout(function() {
                    if (query.length === 0) {
                        $results.html('<p>Ketik untuk mencari berita...</p>').hide();
                        return;
                    }

                    $.ajax({
                        url: "{{ route('user.news.search') }}",
                        type: "GET",
                        data: {
                            search: query
                        },
                        success: function(data) {
                            $results.html(data).fadeIn();
                        },
                        error: function() {
                            $results.html('<p>Terjadi kesalahan saat memuat hasil.</p>')
                                .fadeIn();
                        }
                    });
                }, 300);
            });

            // Close popup when clicking outside
            $(document).on('click', function(e) {
                if (!$(e.target).closest('.search-box').length) {
                    $results.fadeOut();
                }
            });

            // Re-open if clicked inside input again
            $searchInput.on('focus', function() {
                if ($searchInput.val().length > 0) {
                    $results.fadeIn();
                }
            });
        });
    </script>

    <style>
        .search-box {
            position: relative;
        }

        .search-box input[type="search"] {
            width: 100%;
            padding-right: 40px;
            /* ruang untuk ikon */
            height: 45px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        .search-box button {
            position: absolute;
        }

        .search-box .search-popup {
            position: absolute;
            top: 100%;
            left: 0;
            z-index: 1000;
            width: 100%;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-shadow: #ccc;
            max-height: 300px;
            overflow-y: auto;
            display: none;
            padding: 10px;
        }
    </style>
@endpush
@section('content')
    @php
        $recentNews = collect($news)
            ->filter(fn($item) => $item->status == true && $item->published !== null)
            ->sortByDesc(fn($item) => \Carbon\Carbon::parse($item->published))
            ->take(5);
    @endphp
    <div class="breadcrumb-wrapper bg-f br-bg-1 container">
        <img src="{{ asset('images/breadcrumb.jpg') }}" alt="Image"
            class="breadcrumb-image position-absolute top-0 start-0 w-100 h-100 object-cover">
        <div class="overlay op-8 bg-racing-green"></div>
        <div class="container">
            <h2 class="breadcrumb-title">{{ __('messages.Berita') }}</h2>
            <ul class="breadcrumb-menu list-style">
                <li><a href="{{ route('home') }}">{{ __('messages.Beranda') }}</a></li>
                <li><a href="{{ route('news') }}">{{ __('messages.Berita') }}</a></li>
                <li>{{ __('messages.Detail Berita') }}</li>
            </ul>
        </div>
    </div>

    <section class="blog-wrap ptb-100">
        <div class="container">
            <div class="row gx-5">
                <div class="col-xl-4 col-lg-12 order-xl-1 order-lg-2 order-md-2 order-2">
                    <div class="sidebar-widget search-box">
                        <input type="search" name="search" id="news-search"
                            placeholder="{{ __('messages.Cari Berita') }}..." autocomplete="off">
                        <button type="submit"><i class="las la-search"></i></button>
                        <div id="search-results" class="search-popup">
                        </div>
                    </div>

                    <div class="sidebar-widget recent-post mt-3 blog-card">
                        <h4>{{ __('messages.Berita Terbaru') }}</h4>
                        <div class="popular-post-widget">
                            @forelse ($recentNews as $recent)
                                @if ($recent->status == true)
                                    <div class="pp-post-item">
                                        <div class="pp-post-img">
                                            <img src="{{ $recent->images[0]['image_path'] }}" alt="Image">
                                        </div>
                                        <div class="pp-post-info">
                                            <h6><a
                                                    href="{{ route('user.news.detail', $recent->id) }}">{{ Str::limit($recent->title, 60) }}</a>
                                            </h6>
                                            <span><i class="las la-calendar"></i>
                                                {{ $recent->published ? \Carbon\Carbon::parse($recent->published)->format('d M, Y') : 'Not Published' }}
                                            </span>
                                        </div>
                                    </div>
                                @endif
                            @empty
                                <p>{{ __('messages.Tidak Ada Berita Terbaru.') }}</p>
                            @endforelse
                        </div>
                    </div>
                </div>
                <div class="col-xl-8 col-lg-12 order-xl-2 order-lg-1 order-md-1 order-1">
                    <article class="bg-white">
                        <div class="post-img">
                            <div id="newsCarousel" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    @foreach ($detailNews['data']['images'] as $image)
                                        <div class="carousel-item active">
                                            <img src="{{ $image['image_path'] }}" class="d-block w-100" alt="Image 1">
                                        </div>
                                    @endforeach
                                </div>
                                <button class="carousel-control-prev" type="button" data-bs-target="#newsCarousel"
                                    data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#newsCarousel"
                                    data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                            <span
                                class="hort-post-date">{{ \Carbon\Carbon::parse($detailNews['data']['published'])->format('d M, Y') }}</span>
                        </div>
                        <h2 class="post-title">{{ $detailNews['data']['title'] }}</h2>
                        <div class="post-para">
                            <p>{!! $detailNews['data']['content'] !!}</p>
                        </div>
                    </article>
                </div>
            </div>
        </div>
    </section>
@endsection
