<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Imagenes;
use Carbon\Carbon;

class ImagenesController extends Controller{
    public function index(){
        $datos = Imagenes::all();
        return response()->json($datos);
    }
    public function Guardar(Request $request){
        $datos = new Imagenes(); //imagen idLugar
		if($request->imagen){


        if($request->hasFile('imagen')){
            $NombreOriginal = $request->file('imagen')->getClientOriginalName();
            $nuevoNombre = Carbon::now()->timestamp."_".$NombreOriginal;
            $Carpeta = './lugar/';
            $request->file('imagen')->move($Carpeta, $nuevoNombre);
            $datos->id_lugar= $request->idLugar;
            $datos->imagen= ltrim($Carpeta,'.').$nuevoNombre;
            $datos->save();
            return response()->json($datos);
        }else {
            return response()->json("El dato imagen tiene que ser una imagen");
			}
		}else {
			return response()->json("No existe Archivos");
		}
    }
    public function ver($id){
        $datos = Imagenes::find($id);
        return response()->json($datos);
    }
    public function eliminar($id){
        $datos = Imagenes::find($id);
        if($datos){
            $datos->delete();
            return response()->json("Registro Borrado");
        }
        return response()->json("No existe el Registro");
    }
    public function actualizar(Request $request,$id){
        $datos = Imagenes::find($id);
        if($datos){


                $datos->id_lugar= $request->idLugar;




            $datos->save();
            return response()->json($datos);
        }

        return response()->json("No existe el registro");
    }
}
