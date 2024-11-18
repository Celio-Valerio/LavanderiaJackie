<?php

namespace Database\Seeders;

use App\Models\Servicio;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServicioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $servicios = [
            [
                'nombre' => 'Lavado Completo',
                'descripcion' => 'Lavado estándar con detergente y suavizante.',
                'precio' => 50.00,
                'duracion_estimada' => 60,
                'estado' => true,
                'articulos' => json_encode(['Ropa', 'Ropa habitual', 'Sábanas']),
                'extras' => json_encode(['Detergente', 'Suavizante']),
            ],
            [
                'nombre' => 'Planchado',
                'descripcion' => 'Planchado profesional de ropa.',
                'precio' => 30.00,
                'duracion_estimada' => 45,
                'estado' => true,
                'articulos' => json_encode(['Ropa', 'Camisas', 'Pantalones']),
                'extras' => json_encode(['Planchado a vapor']),
            ],
            [
                'nombre' => 'Secado Rápido',
                'descripcion' => 'Secado de ropa en secadora a alta temperatura.',
                'precio' => 20.00,
                'duracion_estimada' => 30,
                'estado' => true,
                'articulos' => json_encode(['Ropa', 'Toallas']),
                'extras' => json_encode(['Suavizante']),
            ],
            [
                'nombre' => 'Lavado de Zapatos',
                'descripcion' => 'Lavado y secado especializado para zapatos.',
                'precio' => 40.00,
                'duracion_estimada' => 60,
                'estado' => true,
                'articulos' => json_encode(['Zapatos deportivos', 'Zapatos de cuero']),
                'extras' => json_encode(['Quitamanchas']),
            ],
            [
                'nombre' => 'Lavado de Cobijas',
                'descripcion' => 'Lavado de cobijas y edredones grandes.',
                'precio' => 70.00,
                'duracion_estimada' => 90,
                'estado' => true,
                'articulos' => json_encode(['Cobijas', 'Edredones']),
                'extras' => json_encode(['Detergente especial', 'Suavizante']),
            ],
            [
                'nombre' => 'Limpieza de Alfombras',
                'descripcion' => 'Servicio de limpieza profunda para alfombras.',
                'precio' => 100.00,
                'duracion_estimada' => 120,
                'estado' => true,
                'articulos' => json_encode(['Alfombras']),
                'extras' => json_encode(['Quitamanchas', 'Aromatizante']),
            ],
            [
                'nombre' => 'Lavado de Peluches',
                'descripcion' => 'Lavado cuidadoso para peluches y juguetes de tela.',
                'precio' => 25.00,
                'duracion_estimada' => 45,
                'estado' => true,
                'articulos' => json_encode(['Peluches']),
                'extras' => json_encode(['Detergente hipoalergénico']),
            ],
            [
                'nombre' => 'Limpieza de Cojines',
                'descripcion' => 'Lavado y secado de cojines y almohadas.',
                'precio' => 35.00,
                'duracion_estimada' => 60,
                'estado' => true,
                'articulos' => json_encode(['Cojines', 'Almohadas']),
                'extras' => json_encode(['Aromatizante']),
            ],
            [
                'nombre' => 'Servicio de Recogida y Entrega',
                'descripcion' => 'Recogemos y entregamos tus prendas a domicilio.',
                'precio' => 20.00,
                'duracion_estimada' => null,
                'estado' => true,
                'articulos' => json_encode([]),
                'extras' => json_encode(['Recogida', 'Entrega']),
            ],
            [
                'nombre' => 'Lavado Delicado',
                'descripcion' => 'Lavado suave para prendas delicadas.',
                'precio' => 45.00,
                'duracion_estimada' => 75,
                'estado' => true,
                'articulos' => json_encode(['Ropa delicada']),
                'extras' => json_encode(['Detergente delicado']),
            ],
            [
                'nombre' => 'Lavado Industrial',
                'descripcion' => 'Lavado de grandes volúmenes de ropa, ideal para hoteles.',
                'precio' => 200.00,
                'duracion_estimada' => 180,
                'estado' => true,
                'articulos' => json_encode(['Ropa de cama', 'Toallas']),
                'extras' => json_encode(['Suavizante', 'Detergente industrial']),
            ],
            [
                'nombre' => 'Lavado Antibacterial',
                'descripcion' => 'Lavado con productos antibacteriales para desinfección.',
                'precio' => 55.00,
                'duracion_estimada' => 60,
                'estado' => true,
                'articulos' => json_encode(['Ropa', 'Cobijas']),
                'extras' => json_encode(['Detergente antibacterial']),
            ],
        ];

        // Crear los servicios en la base de datos
        foreach ($servicios as $servicio) {
            Servicio::create($servicio);
        }
    }
}
