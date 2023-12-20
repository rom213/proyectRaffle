<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Cliente;

class clienteController extends Controller
{
    public function oneRef(Request $request)
    {   
        // Obtener parámetros de consulta
        $id = $request->input('id');
        $reference = $request->input('reference');
        
        // Construir consulta
        $query = Cliente::query();
    
        if ($id) {
            $query->where('id', $id);
        }
    
        if ($reference) {
            $query->where('reference', '=', $reference); // Cambiado a igual (=) para una coincidencia exacta
        }
    
        // Agrega más condiciones según tus necesidades
    
        // Ejecutar consulta
        $clientes = $query->get();
    
        return response()->json($clientes);
    }
    

    public function create(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string',
        ];

        $messages = [
            'name.required' => 'El campo nombre es obligatorio.',
            'email.required' => 'El campo email es obligatorio.',
            'email.email' => 'El email debe ser una dirección de correo válida.',
            'tipo_documento_id.required' => 'El campo tipo_documento_id es obligatorio.',
            'apellido.required' => 'El campo apellido es obligatorio.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        return response()->json(['mensaje' => 'create exelente']);
    }
}
