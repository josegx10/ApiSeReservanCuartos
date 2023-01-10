<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paises;

class PaisesController extends Controller{
    public function index(){
        $datos = Paises::all();
        return response()->json($datos);
    }

    public function Guardar(Request $request){
        $datos = new Paises;
        $datos->id= $request->id;
        $datos->Nombre= $request->nombre;
        $datos->save();
        return response()->json($request);
    }
    public function ver($id){
        $datos = new Paises;
        $busca = $datos->find($id);
        return response()->json($busca);
    }
    public function eliminar($id){
        $datos = Paises::find($id);
        if($datos){
            $datos->delete();
            return response()->json("Registro Borrado");
        }
        return response()->json("No existe el Registro");
    }
    public function actualizar(Request $request,$id){
        $datos = Paises::find($id);
        if($datos){
            if($request->input('nombre')){
                $datos->Nombre= $request->nombre;
            }
            $datos->save();
            return response()->json($datos);
        }

        return response()->json("No existe el registro");
    }
}
