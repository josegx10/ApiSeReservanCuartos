<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comentarios;

class ComentariosController extends Controller
{
    public function mostrar($id)
    {
        $query =  Comentarios::find($id);
        return response()->json($query);
    }
    public function ver($id, $num)
    {
        if ($num == 0) { //para los lugares
            $query =  Comentarios::where('id_lugar', $id)->get();
        } else {
            $query =  Comentarios::where('id_usuario', $id)->get();
        }
        return response()->json($query);
    }
    public function Guardar(Request $request)
    {
        $datos = new Comentarios();
        $datos->id_lugar = $request->idLugar;
        $datos->id_usuario = $request->idUsuario;
        $datos->Comentario = $request->Comentario;
        $datos->save();
        $array = array();
        array_push($array, $datos);
        return response()->json($datos);
    }
    public function index()
    {
        $datos = Comentarios::all();
        return response()->json($datos);
    }
    public function eliminar($id)
    {
        $datos = Comentarios::find($id);
        if ($datos) {
            $datos->delete();
            return response()->json("Registro Borrado");
        }
        return response()->json("No existe el Registro");
    }
    public function actualizar(Request $request, $id)
    {
        $datos = Comentarios::find($id);
        if ($datos) {
            if ($request->input('idLugar')) {
                $datos->id_lugar = $request->idLugar;
                $datos->id_usuario = $request->idUsuario;
                $datos->Comentario = $request->Comentario;
            }
            $datos->save();
            return response()->json($datos);
        }

        return response()->json("No existe el registro");
    }
}
