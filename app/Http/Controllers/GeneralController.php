<?php

namespace App\Http\Controllers;

use App\Models\Categorias;
use App\Models\Comentarios;
use Illuminate\Http\Request;
use App\Models\Imagenes;
use App\Models\Lugar;
use App\Models\Lugar_categorias;
use App\Models\Usuario;
use App\Models\Periodo;

class GeneralController extends Controller
{
    public function Ver($num, $id)
    {
        if ($num == 1) { //Image Lugar Individual
            $query = Lugar::all();
            $array = array();
            foreach ($query as $valor) {
                $query =  Imagenes::where('id_lugar', $valor->id)->first();
                array_push($array, $query);
            }
            return response()->json($array);
        } else if ($num == 2) { //Image Lugar ALL
            $query =  Imagenes::where('id_lugar', $id)->get();
            return response()->json($query);
        } else if ($num == 3) { //Todas las categorias del lugar
            $query =  Lugar_categorias::where('ID_lugar', $id)->get();
            $array = array();
            foreach ($query as $valor) {
                $json = Categorias::where('id', $valor->ID_categorias)->first();
                array_push($array, $json);
            }
            return response()->json($array);
        } else if ($num == 4) { //todos los lugares del usuario
            $query =  Lugar::where('id_usuario', $id)->get();
            return response()->json($query);
        } else if ($num == 5) { //todas las no categorias del lugar
            $todo =  Lugar_categorias::where('ID_lugar', $id)->get();
            $query = Categorias::all();

            $array = array();
            foreach ($query as $valor) {
                $cont = true;
                foreach ($todo as $dato) {
                    if ($dato->ID_categorias == $valor->id) {
                        $cont = false;
                        break;
                    }
                }
                if ($cont) {
                    array_push($array, $valor);
                }
            }
            return response()->json($array);
        } else if ($num == 6) {
            if ($id < 16) {
                $array = array();
                $query =  Lugar_categorias::where('ID_categorias', $id)->get();
                foreach ($query as $valor) { // Todos los lugares de la categoria
                    $json = Lugar::where('id', $valor->ID_lugar)->first();

                    $query = Imagenes::where('id_lugar', $json->id)->first();
                    $json->imagen = $query->imagen;
                    $query = Periodo::where('id_lugar', $json->id)->get();
                    foreach ($query as $q) {
                        if ($q->Enable == 1) {
                            $json->fechaI = $q->fInicial;
                            $json->fechaF = $q->fFinal;
                            break;
                        }
                    }

                    array_push($array, $json);
                }
                return response()->json($array);
            } else {
                $query = Categorias::find($id);
                $data = Lugar::where('Tipo_Lugar', $query->Nombre)->get();
                foreach ($data as $d) {
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
                return response()->json($data);
            }
        } else if ($num == 7) { // encontrar usuario en correo o numero
            $query =  Usuario::where('email', $id)->first();
            $query2 =  Usuario::where('numero', $id)->first();
            $array = array();
            if (isset($query->id)) {
                array_push($array, $query);
                return response()->json($array);
            } else if (isset($query2->id)) {
                array_push($array, $query2);
                return response()->json($array);
            } else {
                return response()->json('El usuario no existe');
            }
        } else if ($num == 8) { // encontrar usuario en correo o numero
            $query =  Comentarios::where('id_usuario', $id)->get();
            return response()->json($query);
        } else if ($num == 9) { // encontrar usuario en correo o numero
            $query =  Comentarios::where('id_usuario', $id)->get();
            return response()->json($query);
        } else {
            return response()->json('El resultado no existe');
        }
    }
}
