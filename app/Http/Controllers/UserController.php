<?php

namespace App\Http\Controllers;

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

        $query1 = Usuario::where('email', $request->email)->first();
        $query2 = Usuario::where('numero', $request->numero)->first();
        if ($query1 != null && $query2 != null) {
            return response()->json('El correo ya esta registrado');
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
