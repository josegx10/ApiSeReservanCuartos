<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categorias;
use Carbon\Carbon;

class CategoriasController extends Controller{
    public function index(){
        $datos = Categorias::all();
        return response()->json($datos);
    }

    public function Guardar(Request $request){
        $datos = new Categorias();
        if($request->hasFile('icono')){
            $NombreOriginal = $request->file('icono')->getClientOriginalName();
            $nuevoNombre = Carbon::now()->timestamp."_".$NombreOriginal;
            $Carpeta = './upload/';
            $request->file('icono')->move($Carpeta, $nuevoNombre);
            $datos->Nombre= $request->nombre;
            $datos->Icono= ltrim($Carpeta,'.').$nuevoNombre;
            $datos->save();
            return response()->json($datos);
        }
    }
    public function ver($id){
        $datos = new Categorias();
        $busca = $datos->find($id);
        return response()->json($busca);
    }
    public function eliminar($id){
        $datos = Categorias::find($id);
        if($datos){
            $datos->delete();
            return response()->json("Registro Borrado");
        }
        return response()->json("No existe el Registro");
    }
    public function actualizar(Request $request,$id){
        $datos = Categorias::find($id);
        if($datos){
                $datos->Nombre= $request->nombre;
            $datos->save();
            return response()->json($datos);
        }

        return response()->json("No existe el registro");
    }
}
