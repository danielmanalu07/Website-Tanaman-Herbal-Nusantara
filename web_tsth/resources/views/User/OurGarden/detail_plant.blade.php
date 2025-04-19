@extends('user.main')
@push('resource')
    <style>
        /* Enhance thumbnail hover effect */
        .gallery-item {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .gallery-item:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .project-img img {
            object-fit: cover;
            /* Biar rapi dan nggak gepeng */
            transition: transform 0.3s ease;
        }

        .project-img:hover img {
            transform: scale(1.05);
        }
    </style>
@endpush
@section('content')
    @php
        $lands = collect($plants['data']['lands']);
    @endphp
    <div class="breadcrumb-wrapper bg-f br-bg-1 container">
        <img src="{{ asset('images/breadcrumb.jpg') }}" alt="Image"
            class="breadcrumb-image position-absolute top-0 start-0 w-100 h-100 object-cover">
        <div class="overlay op-8 bg-racing-green"></div>
        <div class="container">
            <h2 class="breadcrumb-title">Detail Tanaman</h2>
            <ul class="breadcrumb-menu list-style">
                <li><a href="{{ route('home') }}">Beranda</a></li>
                <li><a href="{{ route('user.ourgarden') }}">Taman</a></li>
                <li><a href="{{ route('user.ourgarden.detail', $currentPlantHabitusId) }}">Tanaman</a></li>
                <li>Detail Tanaman</li>
            </ul>
        </div>
    </div>
    <section class="project-details-wrap pt-100 pb-75">
        <div class="container">
            <div class="row gx-5">
                <div class="col-xxl-9 col-xl-8 col-lg-12">
                    <div class="project_desc-wrap">
                        <div class="project-img-wrap position-relative">
                            <div class="project-img bg-f single-project-1">
                                <img src="{{ $plants['data']['images'][0]['image_path'] }}" class="img-fluid w-100 h-100"
                                    alt="">
                            </div>
                            <div class="project-desc" style="font-size: 1.1rem;">
                                <h3 class="mb-3" style="font-size: 1.75rem;">Informasi Tanaman</h3>
                                <div class="d-flex flex-column flex-md-row justify-content-between">
                                    <!-- Left Column -->
                                    <ul class="list-style project-desc-list" style="flex: 1; margin-right: 15px;">
                                        <li class="d-flex flex-column mb-2">
                                            <h6 class="fw-bold" style="font-size: 1.25rem;">Plant Name</h6>
                                            <p class="mb-0" style="font-size: 1.1rem;">{{ $plants['data']['name'] }}</p>
                                        </li>
                                        <li class="d-flex flex-column mb-2">
                                            <h6 class="fw-bold" style="font-size: 1.25rem;">Latin Name</h6>
                                            <p class="mb-0" style="font-size: 1.1rem;">{{ $plants['data']['latin_name'] }}
                                            </p>
                                        </li>
                                        <li class="d-flex flex-column mb-2">
                                            <h6 class="fw-bold" style="font-size: 1.25rem;">Location</h6>
                                            <p class="mb-0" style="font-size: 1.1rem;">
                                                {{ $lands->isEmpty() ? '-' : $lands->pluck('name')->implode(', ') }}
                                            </p>
                                        </li>
                                    </ul>
                                    <!-- Right Column -->
                                    <ul class="list-style project-desc-list" style="flex: 1; margin-left: 15px;">
                                        <li class="d-flex flex-column mb-2">
                                            <h6 class="fw-bold" style="font-size: 1.25rem;">Ecology</h6>
                                            <p class="mb-0" style="font-size: 1.1rem;">{{ $plants['data']['ecology'] }}
                                            </p>
                                        </li>
                                        <li class="d-flex flex-column mb-2">
                                            <h6 class="fw-bold" style="font-size: 1.25rem;">Endemic Information</h6>
                                            <p class="mb-0" style="font-size: 1.1rem;">
                                                {{ $plants['data']['endemic_information'] }}</p>
                                        </li>
                                        <li class="d-flex flex-column mb-2">
                                            <h6 class="fw-bold" style="font-size: 1.25rem;">Habitus</h6>
                                            <p class="mb-0" style="font-size: 1.1rem;">
                                                {{ $plants['data']['habitus']['name'] }}</p>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="project-advantage mt-5">
                            <p>{!! $plants['data']['advantage'] !!}</p>
                        </div>
                        <div class="project-images-gallery mt-5">
                            <h3 class="mb-4">Galeri Tanaman</h3>
                            <div class="row">
                                @foreach ($plants['data']['images'] as $image)
                                    <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                                        <div class="project-img bg-f single-project-1 gallery-item">
                                            <a href="{{ $image['image_path'] }}"
                                                data-lightbox="plant-gallery-{{ $plants['data']['id'] }}"
                                                data-title="Plant Image">
                                                <img src="{{ $image['image_path'] }}"
                                                    class="img-fluid w-100 h-auto rounded shadow-sm" alt="Plant Image">
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="project-card mt-5">
                            <h3 class="mb-4">Galeri Lokasi</h3>
                            <div class="row">
                                @foreach ($plants['data']['lands'] as $land)
                                    <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                                        <div class="project-img bg-f single-project-1 gallery-item">
                                            <a href="{{ $land['image'] }}"
                                                data-lightbox="land-gallery-{{ $plants['data']['id'] }}"
                                                data-title="{{ $land['name'] }}">
                                                <img src="{{ $land['image'] }}"
                                                    class="img-fluid w-100 h-auto rounded shadow-sm" alt="Land Image">
                                            </a>
                                            <div class="project-info mt-2">
                                                <h5 class="text-center">{{ $land['name'] }}</h5>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-xl-4 col-lg-12">
                    <div class="sidebar">
                        {{-- <div class="sidebar-widget search-box">
                            <input type="search" placeholder="Search By Keywords">
                            <button type="submit"> <i class="las la-search"></i></button>
                        </div> --}}
                        <div class="sidebar-widget categories box">
                            <h4>Habitus</h4>
                            <div class="category-box">
                                <ul class="list-style">
                                    @foreach ($habituses as $habitus)
                                        <li><a
                                                href="{{ route('user.ourgarden.detail', $habitus->id) }}">{{ $habitus->name }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="sidebar-widget categories box">
                            <h4>Tanaman Sejenis</h4>
                            <div class="category-box">
                                <ul class="list-style">
                                    @foreach ($plantHabitus as $item)
                                        <li>
                                            <a
                                                href="{{ route('user.ourgarden.plant.detail', $item->id) }}">{{ $item->name }}</a>
                                        </li>
                                    @endforeach
                                    @if ($plantHabitus->isEmpty())
                                        <li>-</li>
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
