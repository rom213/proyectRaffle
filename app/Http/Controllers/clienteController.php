<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;


use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Models\Cliente;

class clienteController extends Controller
{

    public function oneRef(Request $request) {   
        $transaction_id = $request->input('transaction_id');
        
        $query = Cliente::query();
    
        if ($transaction_id) {
            $query->where('transaction_id', '=', $transaction_id);
        } else {
            return response()->json(['error' => 'transactionId is required'], 400);
        }
    
        $client = $query->get();

        if ($client->isEmpty()) {
            return response()->json(['error' => 'transactionId not found'], 404);
        }
    
        $numbersRaffle = $client->pluck('numbersR')->first();
        return response()->json(['numbersR' => json_decode($numbersRaffle)]);
    }

    
    public function create(Request $request) {
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
            'phone.required' => 'El teléfono es requerido',
        ];
        
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $reference = Str::uuid()->toString();

        $request['reference'] = $reference;
        $price = $request['price'];
        $number_tickets = $request['number_raffle'];

        $integrityHash = $this->generateIntegrityHash($request);

        $request['hash_integrity'] = $integrityHash;
        $request['quantity_numbers'] = $number_tickets;

        $cliente = Cliente::create($request->all());
        return response()->json(
            [
                'status' => 'success',
                'message' => 'Usuario creado satisfactoriamente',
                'cliente' => $cliente,
                'hash_integrity' => $integrityHash,
            ],
            200,
        );
    }


    private function generateIntegrityHash($request)
    {
        $referencia = $request['reference'];
        $monto = $request['price'];
        $moneda = 'COP';
        $secretoIntegridad = 'test_integrity_v3iBS12tr8FO83E9VXa1E6cpudVjGdNH';
        $cadenaConcatenada = "{$referencia}{$monto}{$moneda}{$secretoIntegridad}";
        // Genera y devuelve el hash de integridad
        return hash('sha256', $cadenaConcatenada);
    }


    public function update(Request $request, $id) {
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


    public function handleWebhook(Request $request) {

        try {
        $secret = 'test_events_gvuFd3BB5XyJ9iObrfE8ZytRkQMRQGBh'; // Reemplaza con tu secreto proporcionado por Wompi

        $data = $request->json()->all();

        $transactionId = $data['data']['transaction']['id'];
        $status = $data['data']['transaction']['status'];
        $reference = $data['data']['transaction']['reference'];
        
        $cliente = Cliente::where('reference', $reference)->first();

        if ($cliente) {
            // Asocia el transactionId con el cliente
            $cliente->update(['transaction_id' => $transactionId]);
            $cliente->update(['status' => $status]);

            if ($status==='APPROVED') {
                $number_tickets = $cliente -> quantity_numbers;
                $numerRaffle = $this->generarNumerosRifa($cliente->id, $number_tickets);
                $cliente->update(['numbersR' => $numerRaffle]);
            }

        } else {
            Log::error('Cliente no encontrado para la referencia: ' . $reference);
            return response()->json(['error' => 'Cliente no encontrado'], 404);
        }

        return response()->json(['success' => true,'transactionId' => $transactionId]);

        } catch (\Exception $e) {
            Log::error('Error en el controlador de Wompi: ' . $e->getMessage());
            return response()->json(['error' => 'Internal Server Error papu'], 500);
        }
    }


    private function generarNumerosRifa($clienteId, $numeroTickets) {
        // Buscar el último cliente que ya tiene números de rifa asignados
        $ultimoClienteConNumeros = Cliente::whereNotNull('numbersR')
            ->orderBy('id', 'desc')
            ->first();

        $ultimoNumeroRifa = $ultimoClienteConNumeros ? json_decode                          ($ultimoClienteConNumeros->numbersR, true) : [];

        $ultimoNumero = end($ultimoNumeroRifa) ?? 0;

        $nuevosNumeros = [];

        for ($i = 1; $i <= $numeroTickets; $i++) {
            $nuevoNumero = $ultimoNumero + $i;
            $nuevoNumeroFormateado = str_pad($nuevoNumero, 4, '0', STR_PAD_LEFT);
            $nuevosNumeros[] = $nuevoNumeroFormateado;
        }

        Cliente::where('id', $clienteId)->update(['numbersR' => json_encode($nuevosNumeros)]);

        $nuevosNumerosJSON = json_encode($nuevosNumeros);

        return $nuevosNumerosJSON;
    }
    
}










