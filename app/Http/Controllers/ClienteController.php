<?php

namespace App\Http\Controllers;

use App\Models\Client;
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


    
}
