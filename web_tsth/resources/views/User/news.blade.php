@extends('user.main')
@section('content')
    @php
        $currentPage = request()->get('page', 1);
        $perPage = 6;
        $offset = ($currentPage - 1) * $perPage;

        $paginatedNews = $news->slice($offset, $perPage);
        $totalItems = $news->count();
        $totalPages = ceil($totalItems / $perPage);

        $recentNews = collect($news)
            ->filter(function ($item) {
                return \Carbon\Carbon::parse($item->created_at)->greaterThanOrEqualTo(now()->subDays(7));
            })
            ->take(6);
    @endphp
    <div class="breadcrumb-wrapper bg-f br-bg-1 container">
        <img src="{{ asset('images/breadcrumb.jpg') }}" alt="Image"
            class="breadcrumb-image position-absolute top-0 start-0 w-100 h-100 object-cover">
        <div class="overlay op-8 bg-racing-green"></div>
        <div class="container">
            <h2 class="breadcrumb-title">Berita</h2>
            <ul class="breadcrumb-menu list-style">
                <li><a href="{{ route('home') }}">Beranda</a></li>
                <li>Berita</li>
            </ul>
        </div>
    </div>

    <section class="blog-wrap ptb-100">
        <div class="container">
            <div class="row">
                <!-- Sidebar -->
                <div class="col-xl-3 col-lg-12 order-xl-1 order-lg-2">
                    <div class="sidebar-widget search-box">
                        <input type="search" placeholder="Search By Keywords">
                        <button type="submit"><i class="las la-search"></i></button>
                    </div>

                    <div class="sidebar-widget recent-post mt-3 blog-card">
                        <h4>Berita Terbaru</h4>
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
                                <p>Tidak Ada Berita Terbaru.</p>
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
