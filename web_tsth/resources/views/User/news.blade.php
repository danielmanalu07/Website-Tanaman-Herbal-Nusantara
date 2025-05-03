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
        $currentPage = request()->get('page', 1);
        $perPage = 6;
        $offset = ($currentPage - 1) * $perPage;

        $paginatedNews = $news->slice($offset, $perPage);
        $totalItems = $news->count();
        $totalPages = ceil($totalItems / $perPage);

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
                <li>{{ __('messages.Berita') }}</li>
            </ul>
        </div>
    </div>

    <section class="blog-wrap ptb-100">
        <div class="container">
            <div class="row">
                <!-- Sidebar -->
                <div class="col-xl-3 col-lg-12 order-xl-1 order-lg-2">
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

                <!-- News Grid -->
                <div class="col-xl-9 col-lg-12 order-xl-2 order-lg-1">
                    <div class="row justify-content-center">
                        @forelse ($paginatedNews as $new)
                            @if ($new->status == true)
                                <div class="col-lg-6 col-md-6">
                                    <div class="blog-card style1">
                                        <a href="{{ route('user.news.detail', $new->id) }}" class="blog-img">
                                            <img src="{{ $new->images[0]['image_path'] }}"
                                                class="img-fluid w-100 object-fit-cover" style="height: 250px;"
                                                alt="Image">
                                            <span class="blog-date">
                                                {{ $new->published ? \Carbon\Carbon::parse($new->published)->format('d F Y') : 'Not Published' }}
                                            </span>
                                        </a>
                                        <div class="blog-info">
                                            <h3 class="blog-title"><a
                                                    href="{{ route('user.news.detail', $new->id) }}">{{ Str::limit($new->title, 70) }}</a>
                                            </h3>
                                            <p>{!! Str::limit(strip_tags(preg_replace('/<(img|iframe|video)[^>]*>/i', '', $new->content)), 45, '...') !!}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @empty
                            <div class="col-12 text-center">
                                <h4>No News Available</h4>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    <div class="page-navigation">
                        <div class="row">
                            <div class="col-lg-12">
                                <ul class="page-nav list-style">
                                    @if ($currentPage > 1)
                                        <li><a href="?page={{ $currentPage - 1 }}"><i
                                                    class="flaticon-left-arrow-1"></i></a>
                                        </li>
                                    @endif

                                    @for ($i = 1; $i <= $totalPages; $i++)
                                        <li><a class="{{ $i == $currentPage ? 'active' : '' }}"
                                                href="?page={{ $i }}">{{ $i }}</a></li>
                                    @endfor

                                    @if ($currentPage < $totalPages)
                                        <li><a href="?page={{ $currentPage + 1 }}"><i class="flaticon-right-arrow"></i></a>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
