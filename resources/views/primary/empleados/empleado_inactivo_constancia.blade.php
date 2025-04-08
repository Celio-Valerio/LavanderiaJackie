<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; margin: 1.5cm; }
        .title { text-align: center; font-size: 18px; margin-bottom: 20px; }
        .text-center { text-align: center; }
        .text-justify { text-align: justify; }
        .firma { margin-top: 50px; }
        .firma-line { border-top: 1px solid black; width: 300px; margin: 20px 0; }
    </style>
</head>
<body>
<h1 class="title"><strong>CONSTANCIA DE TRABAJO</strong></h1>
<p class="text-center">Danlí, El Paraíso. {{ \Carbon\Carbon::parse($fechaActual)->locale('es_ES')->isoFormat('D [de] MMMM YYYY') }}</p>

<p>Lavandería Jackie<br>
    A quien corresponda:</p>

@php
    use Carbon\Carbon;

    $inicio = Carbon::parse($empleado->hire_date);
    $fin = Carbon::parse($empleado->fecha_salida);
    $diff = $inicio->diff($fin);

    $años = $diff->y > 0 ? $diff->y . ' año' . ($diff->y > 1 ? 's' : '') : '';
    $meses = $diff->m > 0 ? $diff->m . ' mes' . ($diff->m > 1 ? 'es' : '') : '';
    $tiempo = trim($años . ($años && $meses ? ', ' : '') . $meses);

    $fechaInicio = $inicio->locale('es_ES')->isoFormat('D [de] MMMM YYYY');
    $fechaFin = $fin->locale('es_ES')->isoFormat('D [de] MMMM YYYY');
@endphp

<p class="text-justify">
    Por medio de la presente, hacemos constar que el Sr(a). <strong>{{ $empleado->first_name }} {{ $empleado->last_name }}</strong>,
    portador(a) de identidad No. <strong>
        {{ substr($empleado->identity_number, 0, 4) }} -
        {{ substr($empleado->identity_number, 4, 4) }} -
        {{ substr($empleado->identity_number, 8, 5) }}
    </strong>,
    laboró en nuestra empresa <strong>Lavandería Jackie</strong>, desde el <strong>{{ $fechaInicio }}</strong> hasta el <strong>{{ $fechaFin }}</strong>,
    desempeñándose en el área de <strong>{{ $empleado->puesto->name }}</strong> durante <strong>{{ $tiempo ?: 'menos de un mes' }}</strong>, con responsabilidad, compromiso y ética profesional.
</p>

<p class="text-justify">
    Durante su trayectoria en la empresa, el <strong>Sr(a). {{ $empleado->last_name }}</strong> demostró un alto nivel de desempeño,
    contribuyendo significativamente al desarrollo y éxito de nuestra organización.
</p>

<p class="text-justify">
    Extendemos la presente constancia a solicitud del interesado(a) para los fines que estime convenientes.
</p>

<p>Atentamente,</p>

<div class="firma">
    <div class="text-center">
        <div class="firma-line" style="margin: 20px auto;"></div>
        <p>
            {{ $gerente }}<br>
            Gerente General
        </p>
    </div>
    <p>
        Lavandería Jackie<br>
        Teléfono: {{ $telefonoEmpresa }}<br>
        Correo electrónico: {{ $emailEmpresa }}
    </p>

</div>
</body>
</html>
