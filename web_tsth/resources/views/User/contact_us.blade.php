@extends('User.main')
@section('content')
    @php
        $contact = $contacts->first();
    @endphp
    <div class="breadcrumb-wrapper bg-f br-bg-1 container">
        <img src="{{ asset('images/breadcrumb.jpg') }}" alt="Image"
            class="breadcrumb-image position-absolute top-0 start-0 w-100 h-100 object-cover">
        <div class="overlay op-8 bg-racing-green"></div>
        <div class="container">
            <h2 class="breadcrumb-title">{{ __('messages.Kontak Kami') }}</h2>
            <ul class="breadcrumb-menu list-style">
                <li><a href="{{ route('home') }}">{{ __('messages.Beranda') }}</a></li>
                <li>{{ __('messages.Kontak Kami') }}</li>
            </ul>
        </div>
    </div>

    <section class="project-wrap pt-100 pb-75">
        <div class="container">
            <div class="bg-light p-5 rounded shadow-sm">
                @if ($contact)
                    <h1 class="mb-4 border-bottom pb-2 text-dark">{{ $contact->title }}</h1>
                    <div class="content-body fs-5">
                        {!! $contact->text !!}
                    </div>
                @else
                    <p>Data kontak tidak tersedia.</p>
                @endif
            </div>
        </div>
    </section>
@endsection
