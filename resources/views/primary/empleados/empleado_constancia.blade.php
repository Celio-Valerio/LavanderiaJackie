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

<p class="text-justify">
    Por medio de la presente, hacemos constar que el Sr(a). <strong>{{ $empleado->first_name }} {{ $empleado->last_name }}</strong>,
    portador(a) de identidad No. <strong>
        {{ substr($empleado->identity_number, 0, 4) }} -
        {{ substr($empleado->identity_number, 4, 4) }} -
        {{ substr($empleado->identity_number, 8, 5) }}
    </strong>
    , trabaja en nuestra empresa <strong>Lavandería Jackie</strong>,
    desde el <strong>{{ \Carbon\Carbon::parse($empleado->hire_date)->locale('es_ES')->isoFormat('D [de] MMMM YYYY') }}</strong> hasta la fecha,
    desempeñándose en el área de <strong>{{ $empleado->puesto->name }}</strong> con responsabilidad, compromiso y ética profesional.
</p>

<p class="text-justify">
    Durante su trayectoria en la empresa, el <strong>Sr(a). {{ $empleado->last_name }}</strong> ha demostrado un alto nivel de desempeño,
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
