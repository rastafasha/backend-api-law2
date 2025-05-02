<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Client;
use App\Models\ClientsUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClienteController extends Controller
{
    public function index()
    {

       
        
        $clients = Client::select([
            "id", "username", "email"
        ])
            ->with([
                "profile",
                "roles",
            ])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            // ->get();

            return response()->json([
                'code' => 200,
                'status' => 'Listar todos los Clientes',
                'users' => $clients,
            ], 200);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function clientShow(Client $client)
    {
        // $this->authorize('view', Client::class);

        if (!$client) {
            return response()->json([
                'message' => 'User not found.'
            ], 404);
        }

        $client = Client::select([
            "id", "username", "email", "created_at"
        ])
            // ->with([
            //     // "payments",
            //     "profiles",
            // ])
            ->with([
                // "payments",
                "profile",
            ])
            ->find($client);

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'user' => $client,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function clientUpdate( $request, Client $client)
    {
        // $this->authorize('update', Client::class);

        try {
            DB::beginTransaction();

            $input = $this->userInput($client);
            $client->fill($input)->update();

            DB::commit();
            return response()->json([
                'code' => 200,
                'status' => 'Update user success',
                'user' => $client,
            ], 200);
        } catch (\Throwable $exception) {

            DB::rollBack();
            return response()->json([
                'message' => 'Error no update' . $exception,
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function clientDestroy(Client $client)
    {
        // $this->authorize('delete', Client::class);
        
        try {
            DB::beginTransaction();

            $client->delete();

            DB::commit();
            return response()->json([
                'code' => 200,
                'status' => 'Usuario delete',
            ], 200);

        } catch (\Throwable $exception) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Borrado fallido. Conflicto',
            ], 409);

        }
    }

    protected function clientInput(): array
    {
        return [
            "name" => request("name"),
            "email" => request("email"),
            "rolename" => request("rolename"),
        ];
    }

    public function recientes()
    {
        // $this->authorize('recientes', Client::class);

        $clients = Client::orderBy('created_at', 'DESC')
        ->get();

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'clients' => $clients
        ], 200);
    }

    public function search(Request $request){

        return Client::search($request->buscar);

    }


    public function showNdoc($n_doc)
    {
       
        $data_patient = [];
       
        
        $client = Client::where('n_doc', $n_doc)
        ->orderBy('id', 'desc')
        ->first();
        
            return response()->json([
                'code' => 200,
                'status' => 'Listar patient by n_doc',
                "user" => $client,
                "client" => $client,
                // "user" => PatientCollection::make($client) ,
                // "patient" => PatientCollection::make($patient) ,
            ], 200);
    }


    public function addClienttoUser(Request $request){
        $user = User::findOrFail($request->user_id);
        $client = Client::findOrFail($request->client_id);

        // Check if the client is already associated with the user
        $existingAssociation = ClientsUser::where('user_id', $request->user_id)
            ->where('client_id', $request->client_id)
            ->first();

        if ($existingAssociation) {
            return response()->json([
                'code' => 409,
                'status' => 'error',
                'message' => 'Client already associated with this user.',
            ], 409);
        }

        // Create a new association
        $association = new ClientsUser();
        $association->user_id = $request->user_id;
        $association->client_id = $request->client_id;
        $association->save();

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'message' => 'Client successfully added to user.',
            'association' => $association,
        ], 200);
    }

    public function removeClientFromUser($user_id, $client_id){
        $user = User::findOrFail($user_id);
        $client = Client::findOrFail($client_id);

        // Check if the client is associated with the user
        $association = ClientsUser::where('user_id', $user->id)
            ->where('client_id', $client->id)
            ->first();

        if (!$association) {
            return response()->json([
                'code' => 404,
                'status' => 'error',
                'message' => 'Client not associated with this user.',
            ], 404);
        }

        // Delete the association
        $association->delete();

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'message' => 'Client successfully removed from user.',
        ], 200);
    }



     /**
     * Get all unique clients associated with a specific user through solicitudes
     */

    //  lista de clientes por usuario
    public function clientesByUser($userId)
    {
        $user = User::findOrFail($userId);
        
        $clients = ClientsUser::where('user_id', $userId)
            ->with(['client' => function($query) {
                $query->select('id', 'username', 'email');
            }])
            ->get()
            ->pluck('client')
            ->unique('id')
            ->values();


        return response()->json([
            'code' => 200,
            'status' => 'success',
            'user' => $user,
            'clients' => $clients,
            
            
        ], 200);
    }
    // lista de contactos por cliente
    public function contactosByClient($clienteId)
    {
        $cliente = Client::findOrFail($clienteId);
        
        // Get all unique client users associated with this user through clientes
        $users = ClientsUser::where('user_id', $clienteId)
            ->get();
        // Get all unique client users associated with this user through solicitudes
        $users = ClientsUser::where('client_id', $clienteId)
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
