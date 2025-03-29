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
<h1 class="title">CONSTANCIA DE TRABAJO</h1>
<p class="text-center">Danlí {{ $fechaActual }}</p>

<p>Lavandería Jackie<br>
    A quien corresponda:</p>

<p class="text-justify">
    Por medio de la presente, hacemos constar que el Sr(a). {{ $empleado->first_name }} {{ $empleado->last_name }},
    portador(a) de identidad No. ____ - ____ - _____, trabaja en nuestra empresa "Lavandería Jackie",
    desde el {{ \Carbon\Carbon::parse($empleado->hire_date)->locale('es_ES')->isoFormat('D [de] MMMM YYYY') }} hasta la fecha,
    desempeñándose en el área de {{ $empleado->puesto->name }} con responsabilidad, compromiso y ética profesional.
</p>

<p class="text-justify">
    Durante su trayectoria en la empresa, el Sr(a). {{ $empleado->last_name }} ha demostrado un alto nivel de desempeño,
    contribuyendo significativamente al desarrollo y éxito de nuestra organización.
</p>

<p class="text-justify">
    Extendemos la presente constancia a solicitud del interesado(a) para los fines que estime convenientes.
</p>

<p>Atentamente,</p>

<div class="firma">
    <div class="firma-line"></div>
    <p>{{ $gerente }}<br>
        Gerente General<br>
        Lavandería Jackie<br>
        Teléfono: [{{ $telefonoEmpresa }}]<br>
        Correo electrónico: [{{ $emailEmpresa }}]</p>
</div>
</body>
</html>
