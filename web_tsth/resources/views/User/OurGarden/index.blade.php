@extends('user.main')
@push('resource')
    <style>
        .project-card {
            transition: transform 0.3s;
        }

        .project-card:hover {
            transform: scale(1.05);
        }

        .project-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            opacity: 0;
            transition: opacity 0.3s;
        }

        .project-card:hover .project-overlay {
            opacity: 1;
        }
    </style>
@endpush
@section('content')
    <div class="breadcrumb-wrapper bg-f br-bg-1 container">
        <img src="{{ asset('images/breadcrumb.jpg') }}" alt="Image"
            class="breadcrumb-image position-absolute top-0 start-0 w-100 h-100 object-cover">
        <div class="overlay op-8 bg-racing-green"></div>
        <div class="container">
            <h2 class="breadcrumb-title">Taman Kami</h2>
            <ul class="breadcrumb-menu list-style">
                <li><a href="{{ route('home') }}">Beranda</a></li>
                <li>Taman Kami</li>
            </ul>
        </div>
    </div>

    <section class="project-wrap pt-100 pb-75">
        <div class="container">
            <div class="row">
                @foreach ($habituses as $habitus)
                    <div class="col-xl-4 col-lg-6 col-md-6 mb-4">
                        <div class="d-flex justify-content-center">
                            <div class="project-card position-relative" style="width: 400px; height: 400px;">
                                <!-- Gambar dengan bentuk bulat -->
                                <img src="{{ $habitus->image }}" alt="{{ $habitus->name }}"
                                    class="img-fluid rounded-circle w-100 h-100 object-fit-cover">

                                <!-- Overlay teks (muncul saat hover) -->
                                <div
                                    class="project-overlay rounded-circle d-flex align-items-center justify-content-center">
                                    <h5 class="text-white text-center mb-0 px-2">
                                        <a href="{{ route('user.ourgarden.detail', $habitus->id) }}"
                                            class="text-white text-decoration-none">
                                            {{ $habitus->name }}
                                        </a>
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
