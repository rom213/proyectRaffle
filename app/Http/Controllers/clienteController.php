<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Illuminate\Support\Facades\Validator;
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
            'lastname.required' => 'El campo lastname es obligatorio.',
            'phone.required' => 'El teléfono es requerido', // Corregido aquí
        ];
        
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
        

        $cliente = Cliente::create($request->all());
        return response()->json(
            [
                'status' => 'success',
                'message' => 'Usuario creado satisfactoriamente',
                'cliente' => $cliente,
            ],
            200,
        );
        
    }

    public function update(Request $request, $id)
    {

        try {
        $rules = [
            "reference" => 'required|string|max:255',
        ];

        $messages = [
            'reference.required' => 'El campo reference es obligatorio.',
            'reference.string' => 'El campo reference debe ser una cadena de texto.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $cliente = Cliente::findOrFail($id);
        $cliente->update($request->all());

        return response()->json([
            'message' => 'actualización se realizó con éxito.',
        ], 200);

    } catch (\Exception $e) {
        return response()->json(['error' => 'cliente no encontrado'], 404);
    }
    }

}
