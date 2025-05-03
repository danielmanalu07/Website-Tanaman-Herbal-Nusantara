@extends('user.main')
@push('resource')
    <style>
        .project-img {
            position: relative;
            width: 100%;
            aspect-ratio: 1 / 1;
            /* Bikin persegi */
            overflow: hidden;
            border-radius: 10px;
        }

        .project-img img {
            width: 100%;
            height: 100%;
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
    <div class="breadcrumb-wrapper bg-f br-bg-1 container">
        <img src="{{ asset('images/breadcrumb.jpg') }}" alt="Image"
            class="breadcrumb-image position-absolute top-0 start-0 w-100 h-100 object-cover">
        <div class="overlay op-8 bg-racing-green"></div>
        <div class="container">
            <h2 class="breadcrumb-title">{{ __('messages.Tanaman') }}</h2>
            <ul class="breadcrumb-menu list-style">
                <li><a href="{{ route('home') }}">{{ __('messages.Beranda') }}</a></li>
                <li><a href="{{ route('user.ourgarden') }}">{{ __('messages.Taman') }}</a></li>
                <li>{{ __('messages.Tanaman') }}</li>
            </ul>
        </div>
    </div>

    <section class="project-wrap pt-100 pb-75">
        <div class="container">
            <div class="row">
                @foreach ($plantHabitus as $item)
                    @if ($item->status == true)
                        <div class="col-xl-4 col-lg-6 col-md-6">
                            <div class="project-card">
                                <div class="project-img">
                                    <img src="{{ $item->images[0]['image_path'] }}" alt="Image">
                                    <a href="{{ route('user.ourgarden.plant.detail', $item->id) }}">
                                        <div class="project-info">
                                            <h4>{{ $item->name }}</h4>
                                            <p>{{ $item->latin_name }}</p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </section>
@endsection
