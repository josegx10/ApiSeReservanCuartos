<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notificacion;

class NotificacionController extends Controller
{
    public function index()
    {
        $datos = Notificacion::all();
        return response()->json($datos);
    }
    public function ver($id)
    {
        $datos = Notificacion::where('idUsuario', $id)->get();
        return response()->json($datos);
    }
    public function guardar(Request $request)
    {
        $datos = new Notificacion();
        $datos->idUsuario = $request->lugar;
        $datos->notificacion = $request->notificacion;
        $datos->save();
        return response()->json($datos);
    }
}
