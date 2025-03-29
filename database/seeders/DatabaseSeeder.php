<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Producto;
use App\Models\ProductoPrecioHistorial;
use Database\Factories\ProductoPrecioHistorialFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // Llamar a la semilla
        $this->call(CategoriaSeeder::class);
        $this->call(PuestoSeeder::class);
        //$this->call(EmpleadoSeeder::class);
        $this->call(ClienteSeeder::class);
        $this->call(ProveedorSeeder::class);
        $this->call(MaquinariaSeeder::class);
        $this->call(MantenimientoSeeder::class);
        $this->call(PromoSeeder::class);
        $this->call(ProductoSeeder::class);
        $this->call(CompraSeeder::class);
        $this->call(ServicioSeeder::class);
        //$this->call(ServicioEfectuadoSeeder::class);
        $this->call(GastosSeeder::class);

        $this->call(CuentaBancoSeeder::class);
        $this->call(PresupuestoSeeder::class);
        $this->call(ControlCuentaSeeder::class);
        $this->call(CuponSeeder::class);
        //$this->call(GastoDiarioSeeder::class);

        // Crear productos con historial de precios
        Producto::all()->each(function ($producto) {
            ProductoPrecioHistorial::factory()->count(2)->create([
                'producto_id' => $producto->id
            ]);
        });

        //$this->call(VisitaSeeder::class);

    }

}
