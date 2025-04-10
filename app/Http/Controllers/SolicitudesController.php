<?php

namespace App\Http\Controllers;

use App\Models\User;
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
        $validator = Validator::make($request->all(), [
            'pedido' => 'required|json',
            'cliente_id' => 'required|exists:users,id',
            'user_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $request->request->add(["pedido"=>json_encode($request->pedido)]);
        
        $solicitud = Solicitud::create([
            'pedido' => $request->pedido,
            'status' => 1 // Default status
        ]);

        SolicitudUser::create([
            'solicitud_id' => $solicitud->id,
            'cliente_id' => $request->cliente_id,
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
    public function getByCliente($clienteId)
    {
        $cliente = User::findOrFail($clienteId);
        $solicitudes = $cliente->solicitudUsersAsCliente()
            ->with('solicitud')
            ->get()
            ->pluck('solicitud');

            return response()->json([
                'code' => 200,
                'status' => 'success',
                'solicitudes' => $solicitudes,
                'cliente' => $cliente,
                // 'profile' => ProfileResource::make($profile),
            ], 200);
    }
    public function getByUser($userId)
    {
        $user = User::findOrFail($userId);
        $solicitudes = $user->solicitudUsersAsUser()
            ->with('solicitud')
            ->orderBy('created_at', 'asc')
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
            $user = User::find($solicitud->client_id);
            if ($user) {
                $clienteData = $user->solicitudUsersAsCliente()
                    ->with('solicitud')
                    ->get()
                    ->pluck('solicitud');
            }
        }

        if ($solicitud->user_id) {
            $user2 = User::find($solicitud->user_id);
            if ($user2) {
                $usuarioData = $user2->solicitudUsersAsUser()
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

    /**
     * Get all unique clients associated with a specific user through solicitudes
     */
    public function clientesByUser($userId)
    {
        $user = User::findOrFail($userId);
        $solicitud_status= Solicitud::where('status', 2)->get();
        // Get all unique client users associated with this user through solicitudes
        $clientes = SolicitudUser::where('user_id', $userId)
            ->with(['cliente' => function($query) {
                $query->select('id', 'username', 'email');
            }])
            ->get()
            //sacamos el status de la solicitud
            
            ->pluck('cliente')
            ->unique('id')
            ->values();

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'user' => $user,
            'clientes' => $clientes,
            'solicitud_status' => $solicitud_status,
            
        ], 200);
    }
    public function contactosByUser($clienteId)
    {
        $cliente = User::findOrFail($clienteId);
        
        // Get all unique client users associated with this user through solicitudes
        $users = SolicitudUser::where('cliente_id', $clienteId)
            ->with(['user' => function($query) {
                $query->select('id', 'username', 'email');
            }])
            ->get()
            ->pluck('user')
            ->unique('id')
            ->values();

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'cliente' => $cliente,
            'users' => $users,
        ], 200);
    }
}
