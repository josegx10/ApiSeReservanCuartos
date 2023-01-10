<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reserva;

class ReservaController extends Controller
{
    public function index()
    {
        $datos = Reserva::all();
        return response()->json($datos);
    }
    public function ver($id)
    {
        $datos = Reserva::where('idUsuario', $id)->get();
        return response()->json($datos);
    }
    public function guardar(Request $request)
    {
        $datos = new Reserva();
        $datos->idLugar = $request->lugar;
        $datos->idUsuario = $request->usuario;
        $datos->idPeriodo = $request->periodo;
        $datos->Dinero = $request->dinero;
        $datos->huesped = $request->huesped;
        $datos->save();
        return response()->json($datos);
    }
}
