<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Periodo;
use Carbon\Carbon;

class Periodo_lugarController extends Controller
{
    public function index()
    {
        $datos = Periodo::all();
        return response()->json($datos);
    }
    public function ver($id)
    {
        $datos = new Periodo();
        $busca = $datos->where('id_lugar', $id)->get();
        $array = array();
        foreach ($busca as $b) {
            if ($b->Enable == 1) {
                array_push($array, $b);
            }
        }
        return response()->json($array);
    }
    public function Guardar(Request $request)
    {
        $datos = new Periodo();
        $datos->id_usuario = $request->idUsuario;
        $datos->id_lugar = $request->idLugar;
        $datos->fInicial = Carbon::parse($request->fecha);
        $d = Carbon::parse($request->fecha);
        $datos->fFinal = /*$d->addDay*/ Carbon::parse($request->dias);
        $datos->Enable = filter_var($request->enable, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
        $datos->save();
        return response()->json($datos);
    }
    public function Finalizar($id)
    {
        $datos = Periodo::find($id);
        //$datos->Enable = filter_var('false', FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
        $datos->Enable = false;
        $datos->save();
        return response()->json($datos);
    }
    public function eliminar($id)
    {
        $datos = Periodo::find($id);
        if ($datos) {
            $datos->delete();
            return response()->json("Registro Borrado");
        }
        return response()->json("No existe el Registro");
    }
    public function actualizar(Request $request, $id)
    {
        $datos = Periodo::find($id);
        if ($datos) {
            if ($request->input('idLugar')) {
                $datos->id_usuario = $request->idUsuario;
                $datos->id_lugar = $request->idLugar;
                $datos->fInicial = Carbon::parse($request->fecha);
                $datos->fFinal = Carbon::parse($request->dias);
                $datos->Enable = filter_var($request->enable, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
            }
            $datos->save();
            return response()->json($datos);
        }

        return response()->json("No existe el registro");
    }
    public function final()
    {
        $datos = Periodo::all();
        $hoy = date('y-m-d');

        foreach ($datos as $d) {
            if ($d->fFinal < Carbon::parse($hoy)) {
                $d->Enable = 0;
                $d->save();
            }
        }

        return response()->json($datos);
    }
}
