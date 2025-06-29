@extends('User.main');
@push('resource')
    <style>
        :root {
            --primary-green: #2d5016;
            --secondary-green: #4a7c59;
            --accent-green: #68b684;
            --light-green: #a8d5ba;
            --very-light-green: #e8f5e8;
            --white: #ffffff;
            --text-dark: #2c3e50;
            --text-gray: #6c757d;
            --shadow: rgba(0, 0, 0, 0.1);
            --shadow-hover: rgba(0, 0, 0, 0.2);
            --gradient: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            min-height: 100vh;
        }

        .hero-section {
            background: var(--gradient);
            padding: 4rem 0;
            margin-bottom: 3rem;
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="leaves" patternUnits="userSpaceOnUse" width="20" height="20"><path d="M10 2C15 2 18 6 18 10C18 14 15 18 10 18C5 18 2 14 2 10C2 6 5 2 10 2Z" fill="rgba(255,255,255,0.1)"/></pattern></defs><rect width="100" height="100" fill="url(%23leaves)"/></svg>') repeat;
            animation: float 20s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }

            50% {
                transform: translateY(-20px) rotate(180deg);
            }
        }

        .hero-content {
            position: relative;
            z-index: 2;
            text-align: center;
            color: white;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            opacity: 0;
            animation: slideInUp 1s ease-out forwards;
        }

        .hero-subtitle {
            color: var(--very-light-green);
            font-size: 1.2rem;
            opacity: 0.9;
            margin-bottom: 2rem;
            opacity: 0;
            animation: slideInUp 1s ease-out 0.3s forwards;
        }

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
        }

        .stat-card {
            background: var(--accent-green);
            padding: 2rem;
            border-radius: 20px;
            box-shadow: 0 10px 30px var(--shadow);
            text-align: center;
            transition: all 0.3s ease;
            opacity: 0;
            animation: fadeInScale 0.8s ease-out forwards;
        }

        .stat-card:nth-child(2) {
            animation-delay: 0.2s;
        }

        .stat-card:nth-child(3) {
            animation-delay: 0.4s;
        }

        .stat-card:nth-child(4) {
            animation-delay: 0.6s;
        }

        .stat-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px var(--shadow-hover);
        }

        .stat-number {
            color: var(--text-dark);
            font-size: 2rem;
            font-weight: 700;
            background: var(--gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .stat-label {
            color: var(--text-dark);
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 0.5rem;
        }

        @keyframes fadeInScale {
            from {
                opacity: 0;
                transform: scale(0.8) translateY(20px);
            }

            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        .lands-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(400px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
        }

        .land-card {
            background: white;
            border-radius: 25px;
            overflow: hidden;
            box-shadow: 0 15px 35px var(--shadow);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            opacity: 0;
            animation: slideInCard 0.8s ease-out forwards;
            position: relative;
        }

        .land-card:nth-child(even) {
            animation-delay: 0.2s;
        }

        .land-card:hover {
            transform: translateY(-15px) scale(1.02);
            box-shadow: 0 25px 50px var(--shadow-hover);
        }

        @keyframes slideInCard {
            from {
                opacity: 0;
                transform: translateY(50px) rotateX(10deg);
            }

            to {
                opacity: 1;
                transform: translateY(0) rotateX(0deg);
            }
        }

        .land-image {
            position: relative;
            height: 250px;
            overflow: hidden;
        }

        .land-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
        }

        .land-card:hover .land-image img {
            transform: scale(1.1);
        }

        .land-image::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 50%;
            background: linear-gradient(transparent, rgba(0, 0, 0, 0.3));
        }

        .land-badge {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: var(--gradient);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            z-index: 3;
        }

        .land-content {
            padding: 2rem;
        }

        .land-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .land-icon {
            width: 2rem;
            height: 2rem;
            background: var(--gradient);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1rem;
        }

        .plants-section {
            margin-top: 1.5rem;
        }

        .plants-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1rem;
        }

        .plants-title {
            font-size: 1rem;
            color: var(--text-gray);
            font-weight: 600;
        }

        .plants-count {
            background: var(--very-light-green);
            color: var(--primary-green);
            padding: 0.3rem 0.8rem;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .plants-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .plant-item {
            background: var(--very-light-green);
            padding: 1.2rem;
            border-radius: 15px;
            transition: all 0.3s ease;
            border-left: 4px solid var(--accent-green);
        }

        .plant-item:hover {
            background: var(--light-green);
            transform: translateX(5px);
        }

        .plant-name {
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 0.3rem;
        }

        .plant-latin {
            font-style: italic;
            color: var(--text-gray);
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }

        .plant-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .meta-tag {
            background: white;
            color: var(--primary-green);
            padding: 0.2rem 0.6rem;
            border-radius: 8px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .land-footer {
            background: var(--very-light-green);
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.8rem;
            color: var(--text-gray);
        }

        .view-btn {
            background: var(--gradient);
            color: white;
            padding: 0.6rem 1.2rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .view-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(45, 80, 22, 0.3);
            color: white;
            text-decoration: none;
        }

        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: var(--text-gray);
        }

        .empty-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.3;
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }

            .lands-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }

            .stats-container {
                grid-template-columns: repeat(2, 1fr);
                gap: 1rem;
            }
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            animateNumbers();
            observeElements();
        });

        function animateNumbers() {
            const numbers = document.querySelectorAll('.stat-number');
            numbers.forEach(number => {
                const target = parseInt(number.textContent);
                if (isNaN(target)) return;

                let current = 0;
                const increment = target / 50;
                const timer = setInterval(() => {
                    current += increment;
                    if (current >= target) {
                        current = target;
                        clearInterval(timer);
                    }
                    number.textContent = Math.floor(current);
                }, 30);
            });
        }

        function observeElements() {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.animationPlayState = 'running';
                    }
                });
            });

            document.querySelectorAll('.land-card, .stat-card').forEach(el => {
                observer.observe(el);
            });
        }

        function viewLandDetails(landId) {
            // Add your navigation logic here
            console.log('Viewing details for land ID:', landId);
            // Example: window.location.href = `/lands/${landId}`;
        }

        // Add smooth scroll behavior
        document.documentElement.style.scrollBehavior = 'smooth';
    </script>
@endpush
@section('content')
    <div class="hero-section container">
        <div class="container">
            <div class="hero-content">
                <h1 class="hero-title">🌱 {{ __('messages.Lokasi Tanaman') }}</h1>
                <p class="hero-subtitle">{{ __('messages.Jelajahi lokasi taman kami dengan mudah') }}</p>
            </div>
        </div>
    </div>

    <div class="project-wrap">
        <div class="container">
            <!-- Statistics Section -->
            <div class="stats-container">
                <div class="stat-card">
                    <div class="stat-number" id="total-lands">{{ count($lands ?? []) }}</div>
                    <div class="stat-label">{{ __('messages.Total Lokasi') }}</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number" id="total-plants">
                        @php
                            $totalPlants = 0;
                            if (isset($lands)) {
                                foreach ($lands as $land) {
                                    $totalPlants += count($land->plants ?? []);
                                }
                            }
                        @endphp
                        {{ $totalPlants }}
                    </div>
                    <div class="stat-label">{{ __('messages.Total Tanaman') }}</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number" id="total-species">
                        @php
                            $uniqueSpecies = [];
                            if (isset($lands)) {
                                foreach ($lands as $land) {
                                    foreach ($land->plants ?? [] as $plant) {
                                        $uniqueSpecies[$plant['habitus_id']] = true;
                                    }
                                }
                            }
                        @endphp
                        {{ count($uniqueSpecies) }}
                    </div>
                    <div class="stat-label">{{ __('messages.Habitus') }}</div>
                </div>
            </div>

            <!-- Lands Grid -->
            @if (isset($lands) && count($lands) > 0)
                <div class="lands-grid">
                    @foreach ($lands as $index => $land)
                        <div class="land-card" style="animation-delay: {{ $index * 0.1 }}s">
                            <div class="land-image">
                                <img src="{{ $land->image }}" alt="{{ $land->name }}">
                                <div class="land-badge">{{ count($land->plants ?? []) }} {{ __('messages.Tanaman') }}
                                </div>
                            </div>

                            <div class="land-content">
                                <h3 class="land-title">
                                    <div class="land-icon">🏡</div>
                                    {{ $land->name }}
                                </h3>

                                @if (isset($land->plants) && count($land->plants) > 0)
                                    <div class="plants-section">
                                        <div class="plants-header">
                                            <span class="plants-title">{{ __('messages.Spesies Tanaman') }}</span>
                                            <span class="plants-count">{{ count($land->plants) }}
                                                {{ __('messages.Spesies') }}</span>
                                        </div>

                                        <div class="plants-list">
                                            @foreach ($land->plants as $plant)
                                                <div class="plant-item">
                                                    <div class="plant-name">{{ $plant['name'] }}</div>
                                                    <div class="plant-latin">{{ $plant['latin_name'] }}</div>
                                                    <div class="plant-meta">
                                                        <span class="meta-tag">🌍 {{ $plant['ecology'] ?? 'N/A' }}</span>
                                                        @if ($plant['endemic_information'])
                                                            <span class="meta-tag">🔬
                                                                {{ $plant['endemic_information'] }}</span>
                                                        @endif
                                                        @foreach ($habituses as $habitus)
                                                            @if ($plant['habitus_id'] == $habitus->id)
                                                                <span class="meta-tag">📊 {{ $habitus->name }}
                                                                </span>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="land-footer">
                                <div>
                                    <strong>Date:</strong> {{ $land->created_at }}<br>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection
