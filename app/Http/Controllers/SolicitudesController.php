<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Client;
use App\Models\Profile;
use App\Models\Solicitud;
use Illuminate\Http\Request;
use App\Models\SolicitudUser;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Solicitud\SolicitudResource;
use App\Http\Resources\Solicitud\SolicitudCollection;

class SolicitudesController extends Controller
{
    public function index()
    {
        $solicitudes = Solicitud::orderBy('id', 'ASC')
        
        ->get();

        return response()->json([
            'code' => 200,
            'status' => 'Listar todos los solicitudes',
            'solicitudes' => $solicitudes,
        ], 200);
    }
    /**
     * Store a newly created solicitud
     */
    public function store(Request $request)
    {
        // $validator = Validator::make($request->all(), [
        //     'pedido' => 'required|json',
        //     'client_id' => 'required|exists:client,id',
        //     'user_id' => 'required|exists:users,id',
        // ]);

        // if ($validator->fails()) {
        //     return response()->json($validator->errors(), 400);
        // }
        $request->request->add(["pedido"=>json_encode($request->pedido)]);
        
        $solicitud = Solicitud::create([
            'pedido' => $request->pedido,
            'status' => 1 // Default status
        ]);

        SolicitudUser::create([
            'solicitud_id' => $solicitud->id,
            'client_id' => $request->client_id,
            'user_id' => $request->user_id
        ]);

        return response()->json($solicitud->load('solicitudUsers'), 201);
    }

    /**
     * Update the specified solicitud
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'pedido' => 'sometimes|json',
            'status' => 'sometimes|integer',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $solicitud = Solicitud::findOrFail($id);
        $solicitud->update($request->only(['pedido', 'status']));

        return response()->json($solicitud);
    }

    /**
     * Get solicitudes by client ID
     */
    public function getByCliente($clientId)
    {
        $client = Client::findOrFail($clientId);
        $solicitudes = $client->solicitudUsersAsCliente()
            ->with('solicitud')
            ->get()
            ->pluck('solicitud');

            return response()->json([
                'code' => 200,
                'status' => 'success',
                'solicitudes' => $solicitudes,
                'client' => $client,
                // 'profile' => ProfileResource::make($profile),
            ], 200);
    }
    public function getByUser($userId)
    {
        $user = User::findOrFail($userId);
        $solicitudes = $user->solicitudUsersAsUser()
            ->with('solicitud')
            ->orderBy('created_at', 'desc')
            ->get()
            ->pluck('solicitud');

        

        return response()->json([
            'code' => 200,
            'status' => 'success',
            // 'solicitudes' => $solicitudes,
            'solicitudes' => SolicitudCollection::make($solicitudes),
            'user' => $user,
        ], 200);
    }

    /**
     * Get specific solicitud by ID
     */
    public function show($id)
    {
        $solicitud = Solicitud::with('solicitudUsers')->findOrFail($id);
        
        // Get client and user with proper error handling
        $clienteData = [];
        $usuarioData = [];

        if ($solicitud->client_id) {
            $client = Client::find($solicitud->client_id);
            if ($client) {
                $clienteData = $client->solicitudUsersAsCliente()
                    ->with('solicitud')
                    ->get()
                    ->pluck('solicitud');
            }
        }

        if ($solicitud->user_id) {
            $user = User::find($solicitud->user_id);
            if ($user) {
                $usuarioData = $user->solicitudUsersAsUser()
                    ->with('solicitud')
                    ->get()
                    ->pluck('solicitud');
            }
        }

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'solicitud' => $solicitud,
            'cliente' => $clienteData,
            'usuario' => $usuarioData,
        ], 200);
    }

    public function updateStatusSolicitud(Request $request, $id)
    {
        
        $solicitud = Solicitud::findOrfail($id);
        $solicitud->status = $request->status;
        $solicitud->update();
        // if($request->status ===2){
        //     Mail::to($solicitud->email)->send(new UpdateStatusMail($user));
        // }

        return $solicitud;
        
    }

   
   
}
