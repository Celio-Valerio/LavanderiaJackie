@extends('layouts.principal')
@section('title', 'Lista de Promociones')
@section('content')

    <!-- Asegúrate de incluir este CSS y JS en tu archivo principal o en esta vista -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css">
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" defer></script>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h1 class="card-title" style="font-size: 30px; margin: 0;">Lista de promociones</h1>
                            <a href="{{ route('promociones.create') }}" class="btn btn-primary btn-sm d-flex align-items-center" style="border-radius: 5px; height: 40px; padding: 0 15px;">Agregar Promoción</a>
                        </div>

                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-message">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        <hr>

                        <!-- Campo de búsqueda -->
                        <div class="mb-3">
                            <input type="text" id="searchInput" placeholder="Buscar promociones..." class="form-control" style="width: 300px; margin: 0 auto;">
                        </div>

                        <div id="promotionsContainer" class="row">
                            @foreach($promociones as $promo)
                                <div class="col-xxl-3 col-lg-4 col-md-6 col-sm-12 mb-4 promo-card" data-name="{{ $promo->name }}" data-price="{{ $promo->price }}" data-discount="{{ $promo->discount }}">
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
                                            <p class="text-muted mb-1" style="font-size: 0.8em;">
                                                <del>L. {{ number_format($promo->price, 2) }}</del>
                                            </p>
                                            @php
                                                $discountedPrice = $promo->price - ($promo->price * ($promo->discount / 100));
                                            @endphp
                                            <p class="fw-bold mb-3" style="color: #d9534f; font-size: 1.3em;">
                                                L. {{ number_format($discountedPrice, 2) }}
                                            </p>
                                            <div class="mb-3">
                                                @foreach(json_decode($promo->days, true) as $day)
                                                    <span class="badge bg-secondary me-1" style="font-size: 0.7em;">{{ $day }}</span>
                                                @endforeach
                                            </div>
                                            <a href="#" class="btn btn-primary w-100 rounded-pill">Aplicar</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Paginación -->
                        <!-- Paginación -->
                        <div id="paginationContainer" class="d-flex justify-content-center mt-4">
                            <div>
                                <!-- Enlace de la página anterior -->
                                @if($promociones->onFirstPage())
                                    <span class="disabled btn btn-secondary">Anterior</span>
                                @else
                                    <a href="{{ $promociones->previousPageUrl() }}" class="btn btn-primary">Anterior</a>
                                @endif

                                <!-- Mostrar números de página -->
                                @for($i = 1; $i <= $promociones->lastPage(); $i++)
                                    @if($i == $promociones->currentPage())
                                        <span class="btn btn-secondary disabled">{{ $i }}</span>
                                    @else
                                        <a href="{{ $promociones->url($i) }}" class="btn btn-primary">{{ $i }}</a>
                                    @endif
                                @endfor

                                <!-- Enlace de la siguiente página -->
                                @if($promociones->hasMorePages())
                                    <a href="{{ $promociones->nextPageUrl() }}" class="btn btn-primary">Siguiente</a>
                                @else
                                    <span class="disabled btn btn-secondary">Siguiente</span>
                                @endif
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Configurar el mensaje de éxito
                const alert = document.getElementById('success-message');
                if (alert) {
                    setTimeout(() => {
                        alert.classList.remove('show');
                        alert.style.display = 'none';
                    }, 5000);
                }

                // Funcionalidad de búsqueda
                const searchInput = document.getElementById('searchInput');
                const promoCards = document.querySelectorAll('.promo-card');

                // Función debounce
                function debounce(func, delay) {
                    let timeoutId;
                    return function(...args) {
                        if (timeoutId) {
                            clearTimeout(timeoutId);
                        }
                        timeoutId = setTimeout(() => {
                            func.apply(null, args);
                        }, delay);
                    };
                }

                // Filtrar tarjetas
                const filterCards = function() {
                    const searchValue = searchInput.value.trim().toLowerCase();

                    promoCards.forEach(card => {
                        const name = card.getAttribute('data-name').trim().toLowerCase();

                        // Filtrar tarjetas que coinciden con el valor de búsqueda
                        if (searchValue === '' || name.includes(searchValue)) {
                            card.style.display = ''; // Mostrar tarjeta
                        } else {
                            card.style.display = 'none'; // Ocultar tarjeta
                        }
                    });
                };

                // Agregar evento de búsqueda con debounce
                searchInput.addEventListener('input', debounce(filterCards, 300)); // Ajusta el tiempo según sea necesario
            });
        </script>


    </section>
@endsection
