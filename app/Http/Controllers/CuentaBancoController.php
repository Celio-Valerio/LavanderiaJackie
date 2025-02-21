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

    public function store(Request $request)
    {
        $request->validate([
            'banco' => 'required|string|max:100',
            'cuenta' => 'required|string|max:50|unique:cuenta_bancos,cuenta',
            'saldo' => 'required|numeric|min:0'
        ]);

        $cuenta = CuentaBanco::create($request->all());

        return response()->json([
            'success' => true,
            'cuenta' => $cuenta
        ]);
    }
}
