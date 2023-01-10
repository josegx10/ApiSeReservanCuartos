<?php

namespace App\Http\Controllers;

use App\Models\Comentarios;
use App\Models\Imagenes;
use Illuminate\Http\Request;
use App\Models\Lugar;
use App\Models\Lugar_categorias;
use App\Models\Periodo;
use App\Models\Reserva;

class LugarController extends Controller
{
    public function index()
    {
        $datos = Lugar::all();
        foreach ($datos as $d) {
            $query = Imagenes::where('id_lugar', $d->id)->first();
            $d->imagen = $query->imagen;
            $query = Periodo::where('id_lugar', $d->id)->get();
            foreach ($query as $q) {
                if ($q->Enable == 1) {
                    $d->fechaI = $q->fInicial;
                    $d->fechaF = $q->fFinal;
                    break;
                }
            }
        }
        $arraydinero = [];
        for ($i = 0; $i < count($datos); $i++) {
            array_push($arraydinero, $datos[$i]->Dinero * 1000 + $i);
            sort($arraydinero);
        }
        for ($i = 0; $i < count($datos); $i++) {
            $datos[$arraydinero[$i] % 10]->precio = $i;
        }
        return response()->json($datos);
    }
    public function ver($id)
    {
        $query =  Lugar::where('id', $id)->get();
        return response()->json($query);
    }
    public function Guardar(Request $request)
    {
        $datos = new Lugar();
        $datos->id_usuario = $request->idUsuario;
        $datos->ubicacion = $request->ubicacion;
        $datos->Tipo_Lugar = $request->TipoLugar;
        $datos->Descripcion_Lugar = $request->TipoDesc;
        $datos->Tipo_espacio = $request->TipoEsp;
        $datos->Calle = $request->Calle;
        $datos->Opcional = $request->opcion;
        $datos->Ciudad = $request->Ciudad;
        $datos->Estado = $request->Estado;
        $datos->CP = $request->cp;
        $datos->Pais = $request->Pais;
        $datos->NHuespedes = $request->Nhuesped;
        $datos->NBanios = $request->Nbanios;
        $datos->NCamas = $request->NCamas;
        $datos->Descripcion = $request->Description;
        $datos->Titulo = $request->Titulo;
        $datos->Dinero = $request->Dinero;
        $datos->enable = filter_var($request->enable, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
        $datos->save();
        return response()->json($datos);
    }
    public function actualizar(/*$num,*/$id, Request $request)
    {
        /*switch ($num) {
            case 0: //enable
                $query =  Lugar::find($id);
                $query->enable = filter_var($request->valor, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
                $query->save();
                return response()->json($query);
                break;
            case 1: //NHuespedes
                $query =  Lugar::find($id);
                $query->NHuespedes = $request->valor;
                $query->save();
                return response()->json($query);
                break;
            case 2: //NBanios
                $query =  Lugar::find($id);
                $query->NBanios = $request->valor;
                $query->save();
                return response()->json($query);
                break;
            case 3: //NCamas
                $query =  Lugar::find($id);
                $query->NCamas = $request->valor;
                $query->save();
                return response()->json($query);
                break;
            case 4: //Dinero
                $query =  Lugar::find($id);
                $query->Dinero = $request->valor;
                $query->save();
                return response()->json($query);
                break;
            default:*/
        $datos =  Lugar::find($id);
        $datos->id_usuario = $request->idUsuario;
        $datos->ubicacion = $request->ubicacion;
        $datos->Tipo_Lugar = $request->TipoLugar;
        $datos->Descripcion_Lugar = $request->TipoDesc;
        $datos->Tipo_espacio = $request->TipoEsp;
        $datos->Calle = $request->Calle;
        $datos->Opcional = $request->opcion;
        $datos->Ciudad = $request->Ciudad;
        $datos->Estado = $request->Estado;
        $datos->CP = $request->cp;
        $datos->Pais = $request->Pais;
        $datos->NHuespedes = $request->Nhuesped;
        $datos->NBanios = $request->Nbanios;
        $datos->NCamas = $request->NCamas;
        $datos->Descripcion = $request->Description;
        $datos->Titulo = $request->Titulo;
        $datos->Dinero = $request->Dinero;
        $datos->enable = filter_var($request->enable, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
        $datos->save();
        return response()->json($datos);
        //}
    }
    public function mostrar($num, $cadena)
    {
        switch ($num) {
            case 0:
                $query =  Lugar::where('Tipo_Lugar', $cadena)->get();
                return response()->json($query);
                break;
            case 1:
                $query =  Lugar::where('Descripcion_Lugar', $cadena)->get();
                return response()->json($query);
                break;
            case 2:
                $query =  Lugar::where('Tipo_espacio', $cadena)->get();
                return response()->json($query);
                break;
        }
    }
    public function eliminar($id)
    {
        $datos = Lugar::find($id);
        if ($datos) {
            $lc = Lugar_categorias::where('ID_lugar', $datos->id)->get();
            $reserva = Reserva::where('idLugar', $datos->id)->get();
            $comentario = Comentarios::where('id_lugar', $datos->id)->get();
            $periodo = Periodo::where('id_lugar', $datos->id)->get();
            $imagen = Imagenes::where('id_lugar', $datos->id)->get();
            foreach ($lc as $r) {
                $r->delete();
            }
            foreach ($reserva as $r) {
                $r->delete();
            }
            foreach ($comentario as $r) {
                $r->delete();
            }
            foreach ($periodo as $r) {
                $r->delete();
            }
            foreach ($imagen as $r) {
                $r->delete();
            }
            $datos->delete();
            return response()->json("Registro Borrado");
        }
        return response()->json("No existe el Registro");
    }
}
