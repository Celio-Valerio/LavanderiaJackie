<?php
namespace App\Http\Controllers;

use App\Models\CuentaBanco;
use Illuminate\Http\Request;

class CuentaBancoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtener todos los nombres únicos de los bancos
        $bancos = CuentaBanco::select('banco')->distinct()->get();

        // Obtener todas las cuentas bancarias
        $cuentaBanco = CuentaBanco::all();

        // Pasar los bancos y las cuentas a la vista
        return view('primary.cuentas_bancos.cuentas_bancos_index', compact('bancos', 'cuentaBanco'));
    }
}
