@extends('user.main')
@section('content')
    @php
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
                <li><a href="{{ route('news') }}">Berita</a></li>
                <li>Detail Berita</li>
            </ul>
        </div>
    </div>

    <section class="blog-wrap ptb-100">
        <div class="container">
            <div class="row gx-5">
                <div class="col-xl-4 col-lg-12 order-xl-1 order-lg-2 order-md-2 order-2">
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
                                            <h6><a href="#">{{ Str::limit($recent->title, 60) }}</a></h6>
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
                            <span class="hort-post-date">{{ $detailNews['data']['published'] }}</span>
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
