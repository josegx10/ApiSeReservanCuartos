<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lugar_categorias;
use Carbon\Carbon;

class Lugar_categoriasController extends Controller{
    public function index(){
        $datos = Lugar_categorias::all();
        return response()->json($datos);
    }

    public function Guardar(Request $request){
        $datos = new Lugar_categorias;
        $datos->ID_categorias = $request->idCategorias;
        $datos->ID_lugar= $request->idLugar;
        $datos->save();
        return response()->json($datos);
    }
    public function ver($id){
        $datos = new Lugar_categorias;
        $busca = $datos->find($id);
        return response()->json($busca);
    }
    public function eliminar($id){
        $datos = Lugar_categorias::find($id);
        if($datos){
            $datos->delete();
            return response()->json("Registro Borrado");
        }
        return response()->json("No existe el Registro");
    }
    public function actualizar(Request $request,$id){
        $datos = Lugar_categorias::find($id);
        if($datos){
            if($request->input('idLugar')){
                $datos->ID_categorias = $request->idCategorias;
                $datos->ID_lugar= $request->idLugar;
            }
            $datos->save();
            return response()->json($datos);
        }

        return response()->json("No existe el registro");
    }

}
