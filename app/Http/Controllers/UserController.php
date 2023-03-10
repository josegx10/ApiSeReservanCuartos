<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Usuario;
use Carbon\Carbon;

class UserController extends Controller
{
    public function index()
    {
        $datos = Usuario::all();
        return response()->json($datos);
    }
    public function Guardar(Request $request)
    {
        $datos = new Usuario();

        $query1 = Usuario::where('email', $request->email)->get();
        $query2 = Usuario::where('numero', $request->numero)->get();
        if (isset($query1[0]->id) || isset($query2[0]->id)) {
            return response()->json('El correo o telefono ya esta registrado');
        } else {
            $datos->numero = $request->numero;
            $datos->email = $request->email;
            $datos->password = $request->password;
            $datos->apellido = $request->apellido;
            $datos->nombre = $request->nombre;
            $datos->fecha_naci = Carbon::parse($request->fecha);
            $datos->Huesped = filter_var($request->Huesped, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
            $datos->Anfitrion = filter_var($request->Anfitrion, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
            $datos->save();
            return response()->json($datos);
        }
    }
    public function Modificar($id, Request $request)
    {
        switch ($request->num) {
            case 0:
                $datos = Usuario::find($id);
                $datos->Huesped = filter_var($request->dato, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
                $datos->save();
                return response()->json($datos);
                break;
            case 1:
                $datos = Usuario::find($id);
                $datos->Anfitrion = filter_var($request->dato, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
                $datos->save();
                return response()->json($datos);
                break;
            default:
                # code...
                break;
        }
    }
    public function ver($id)
    {
        $query =  Usuario::where('id', $id)->get();
        return response()->json($query);
    }
    public function eliminar($id)
    {
        $datos = Usuario::find($id);
        if ($datos) {
            $datos->delete();
            return response()->json("Registro Borrado");
        }
        return response()->json("No existe el Registro");
    }
    public function actualizar(Request $request, $id)
    {
        $datos = Usuario::find($id);
        if ($datos) {
            $que = Usuario::where('numero', $request->numero)->first();
            $que2 = Usuario::where('email', $request->email)->first();
            if (isset($que->id)) {
                if ($que->id != $datos->id) {
                    return response()->json('El numero ya esta registrado con otro usuario');
                }
            }
            if (isset($que2->id)) {
                if ($que2->id != $datos->id) {
                    return response()->json('El correo electronico ya existe en otra parte');
                }
            }
            $datos->numero = $request->numero;
            $datos->email = $request->email;
            $datos->apellido = $request->apellido;
            $datos->nombre = $request->nombre;
            $datos->fecha_naci = Carbon::parse($request->fecha);
            $datos->password = $request->password;
            $datos->save();
            $array = array();
            array_push($array, $datos);
            return response()->json($array);
        }

        return response()->json("No existe el registro");
    }
}
