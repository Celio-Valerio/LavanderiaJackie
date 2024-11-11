@extends('layouts.principal')
@section('title', 'Promociones')
@section('content')
    <style>
        .promo-card img {
            transition: transform 0.3s ease, opacity 0.3s ease;
        }
        .promo-card:hover img {
            transform: scale(1.05);
            opacity: 0.9;
        }
        .promo-card .btn {
            display: none;
        }
    </style>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h1 class="card-title" style="font-size: 30px; margin: 0;">Lista de Promociones</h1>
                            <div class="button-group d-flex gap-2">
                                <a href="{{ route('promociones.index') }}" class="btn btn-dark btn-sm d-flex align-items-center" style="border-radius: 5px; height: 40px; padding: 0 15px;">Modo Tabla</a>
                                <a href="{{ route('promociones.create') }}" class="btn btn-primary btn-sm d-flex align-items-center" style="border-radius: 5px; height: 40px; padding: 0 15px;">Agregar Promoción</a>
                            </div>
                        </div>
                        
                    @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-message">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        <hr>

                        <div id="promotionsContainer" class="row">
                            @foreach($promociones as $promo)
                                <div class="col-xxl-3 col-lg-4 col-md-6 col-sm-12 mb-4 promo-card"
                                     data-name="{{ $promo->name }}"
                                     data-price="{{ $promo->price }}"
                                     data-discount="{{ $promo->discount }}"
                                     data-days="{{ implode(', ', json_decode($promo->days, true)) }}">
                                    <div class="card promo-card shadow-lg border-0 rounded-3 d-flex flex-column" style="height: auto;">
                                        <div class="position-relative">
                                            <img
                                                src="{{ !empty($promo->image) && file_exists(public_path('assets/img/promociones/' . $promo->image)) ? asset('assets/img/promociones/' . $promo->image) : asset('assets/img/promociones/promos (1).jpg') }}"
                                                class="card-img-top"
                                                alt="{{ $promo->image }}"
                                                style="height: 150px; object-fit: cover;"
                                            >
                                            <span class="badge bg-danger position-absolute top-0 end-0 m-2" style="font-size: 0.8em;">{{ $promo->discount }}%</span>
                                        </div>
                                        <div class="card-body text-center flex-grow-1">
                                            <h5 class="card-title" style="font-size: 1.1em;">{{ $promo->name }}</h5>
                                            <p class="text-muted mb-1" style="font-size: 0.8em; display: none;">
                                                <del>L. {{ number_format($promo->price, 2) }}</del>
                                            </p>
                                            @php
                                                $discountedPrice = $promo->price - ($promo->price * ($promo->discount / 100));
                                            @endphp
                                            <p class="fw-bold mb-3" style="color: #d9534f; font-size: 1.3em; display: none;">
                                                L. {{ number_format($discountedPrice, 2) }}
                                            </p>

                                            <div class="mb-3">
                                                @foreach(json_decode($promo->days, true) as $day)
                                                    <span class="badge bg-secondary me-1" style="font-size: 0.7em;">{{ $day }}</span>
                                                @endforeach
                                            </div>
                                            <a href="#" class="btn btn-primary w-100 rounded-pill" style="display: none;">Aplicar</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div>
                            {{ $promociones->links('pagination::bootstrap-5') }} <!-- Paginación -->
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const alert = document.getElementById('success-message');
                if (alert) {
                    setTimeout(() => {
                        alert.classList.remove('show');
                        alert.style.display = 'none';
                    }, 5000);
                }
            });
        </script>


    </section>
@endsection
