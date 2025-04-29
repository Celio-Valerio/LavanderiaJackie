@extends('layouts.principal')
@section('title', 'Historial cliente')
@section('content')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <section class="section">
        @if($usuario->rolpermiso->clientes_ver == 1)
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h1 class="card-title" style="font-size: 30px !important;">Historial de servicios de {{$cliente->first_name}} {{$cliente->last_name}}</h1>
                            <hr>
                            <label for="lblValor" style="margin-bottom: 20px"><b>Mostrar por:</b></label>
                            <br>
                            <div class="row" style="margin-bottom: 20px">
                                <div class="col-md-4">
                                    <label for="lblAnio">Año:</label>
                                    <select name="anio" class="form-control" id="anio">
                                        <option value=""></option>
                                        @foreach($anios as $anio)
                                            <option>{{$anio}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="lblMes">Mes:</label>
                                    <select name="mes" class="form-control" id="mes">
                                        <option value=""></option>
                                        <option value="01">Enero</option>
                                        <option value="02">Febrero</option>
                                        <option value="03">Marzo</option>
                                        <option value="04">Abril</option>
                                        <option value="05">Mayo</option>
                                        <option value="06">Junio</option>
                                        <option value="07">Julio</option>
                                        <option value="08">Agosto</option>
                                        <option value="09">Septiembre</option>
                                        <option value="10">Octubre</option>
                                        <option value="11">Noviembre</option>
                                        <option value="12">Diciembre</option>
                                    </select>
                                </div>
                            </div>


                            <div id="chart"></div>
                            <div id="chart2"></div>
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('clientes.index') }}" class="btn btn-danger flex-fill">Regresar</a>
                            </div>
                        </div>
                        <input type="hidden" id="porDia" name="porDia" value='@json($clienteDia)'>
                        <input type="hidden" id="servicios" name="servicios" value="{{$clienteServicios}}">
                    </div>
                </div>
            </div>
        @else
            <div class="d-flex justify-content-center align-items-center vh-100 bg-light">
                <div class="text-center p-5 bg-white rounded shadow-lg" style="max-width: 600px;">
                    <img src="https://cdn-icons-png.flaticon.com/512/16962/16962145.png"
                         alt="Sin permisos" class="img-fluid mb-4" style="max-height: 250px; border-radius: 10px;">
                    <h2 class="text-danger mb-3">Acceso Denegado</h2>
                    <p class="fs-5">No tienes permisos para acceder a este apartado.</p>
                    <a href="{{ route('dashboard') }}" class="btn btn-primary mt-4 px-4 py-2">Volver al inicio</a>
                </div>
            </div>
        @endif
            document.addEventListener("DOMContentLoaded", function () {
                var porDia = JSON.parse(document.getElementById('porDia').value);
                var serviciosC = JSON.parse(document.getElementById('servicios').value);
                var anioSelect = document.getElementById('anio');
                var mesSelect = document.getElementById('mes');
                var chart;   // Gráfico mensual
                var chart2;  // Gráfico diario

                var mesesTraducir = {
                    "01": "Enero", "02": "Febrero", "03": "Marzo", "04": "Abril",
                    "05": "Mayo", "06": "Junio", "07": "Julio", "08": "Agosto",
                    "09": "Septiembre", "10": "Octubre", "11": "Noviembre", "12": "Diciembre"
                };

                function actualizarGrafico(anioFiltrar) {
                    var meses = [];
                    var cantidades = [];
                    var dias = [];
                    var cantidads = [];

                    // Si se ha seleccionado un mes y un año, filtrar por días (gráfico diario)
                    if (mesSelect.value !== '' && anioSelect.value !== '') {
                        // Destruir el gráfico mensual si existe
                        if(chart){
                            chart.destroy();
                            chart = null;
                        }

                        var primerDia = new Date(anioSelect.value, mesSelect.value - 1, 1);
                        var ultimoDia = new Date(anioSelect.value, mesSelect.value, 0);
                        var primerDiaISO = primerDia.toISOString().split('T')[0];
                        var ultimoDiaISO = ultimoDia.toISOString().split('T')[0];

                        porDia.forEach(function(servicio) {
                            if (servicio.fecha >= primerDiaISO && servicio.fecha <= ultimoDiaISO) {
                                var fechaObj = new Date(servicio.fecha + "T00:00:00");
                                var fechaFormateada = fechaObj.toLocaleDateString('es-ES', {
                                    day: '2-digit',
                                    month: 'long',
                                    year: 'numeric'
                                });
                                dias.push(fechaFormateada);
                                cantidads.push(servicio.cantidad);
                            }
                        });



                        // Crear o actualizar el gráfico diario
                        if (chart2) {
                            chart2.updateOptions({
                                xaxis: { categories: dias },
                                series: [{ name: 'Servicios', data: cantidads }]
                            });
                        } else {
                            var options = {
                                series: [{ name: 'Servicios', data: cantidads }],
                                chart: { height: 350, type: 'bar' },
                                plotOptions: {
                                    bar: { borderRadius: 10, dataLabels: { position: 'top' } }
                                },
                                dataLabels: {
                                    enabled: true,
                                    formatter: function (val) { return val; },
                                    offsetY: -20,
                                    style: { fontSize: '12px', colors: ["#304758"] }
                                },
                                xaxis: {
                                    categories: dias,
                                    position: 'top',
                                    axisBorder: { show: false },
                                    axisTicks: { show: false },
                                    tooltip: { enabled: true }
                                },
                                yaxis: {
                                    axisBorder: { show: false },
                                    axisTicks: { show: false },
                                    labels: { show: false, formatter: function (val) { return val; } }
                                },
                                title: {
                                    text: 'Historial de servicios por día',
                                    floating: true,
                                    offsetY: 330,
                                    align: 'center',
                                    style: { color: '#444' }
                                }
                            };

                            chart2 = new ApexCharts(document.querySelector("#chart2"), options);
                            chart2.render();
                        }
                    } else {
                        // Si no se ha seleccionado un mes, se agrupa por mes (gráfico mensual)
                        // Destruir el gráfico diario si existe
                        if(chart2){
                            chart2.destroy();
                            chart2 = null;
                        }

                        serviciosC.forEach(function (servicio) {
                            var partes = servicio.mes.split("-"); // "YYYY-MM"
                            var mesNumero = partes[1]; // número de mes
                            var anio = partes[0]; // año

                            if (anioFiltrar === "" || anio === anioFiltrar) {
                                meses.push(mesesTraducir[mesNumero] + " " + anio);
                                cantidades.push(servicio.cantidad);
                            }
                        });

                        // Crear o actualizar el gráfico mensual
                        if (chart) {
                            chart.updateOptions({
                                xaxis: { categories: meses },
                                series: [{ name: 'Servicios', data: cantidades }]
                            });
                        } else {
                            var options = {
                                series: [{ name: 'Servicios', data: cantidades }],
                                chart: { height: 350, type: 'bar' },
                                plotOptions: {
                                    bar: { borderRadius: 10, dataLabels: { position: 'top' } }
                                },
                                dataLabels: {
                                    enabled: true,
                                    formatter: function (val) { return val; },
                                    offsetY: -20,
                                    style: { fontSize: '12px', colors: ["#304758"] }
                                },
                                xaxis: {
                                    categories: meses,
                                    position: 'top',
                                    axisBorder: { show: false },
                                    axisTicks: { show: false },
                                    tooltip: { enabled: true }
                                },
                                yaxis: {
                                    axisBorder: { show: false },
                                    axisTicks: { show: false },
                                    labels: { show: false, formatter: function (val) { return val; } }
                                },
                                title: {
                                    text: 'Historial de servicios',
                                    floating: true,
                                    offsetY: 330,
                                    align: 'center',
                                    style: { color: '#444' }
                                }
                            };

                            chart = new ApexCharts(document.querySelector("#chart"), options);
                            chart.render();
                        }
                    }
                }

                // Inicializar gráfico sin filtro
                actualizarGrafico("");

                // Detectar cambio en el año seleccionado
                anioSelect.addEventListener("change", function () {
                    actualizarGrafico(anioSelect.value);
                });

                // Detectar cambio en el mes seleccionado
                mesSelect.addEventListener("change", function () {
                    actualizarGrafico(anioSelect.value);
                });
            });

        </script>
    </section>
@endsection
