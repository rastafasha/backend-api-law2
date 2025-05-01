<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Client;
use App\Models\Message;
use App\Models\MessageUsers;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $messages = Message::orderBy('id', 'ASC')
        
        ->get();

        return response()->json([
            'code' => 200,
            'status' => 'Listar todos los messages',
            'messages' => $messages,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeMessage(Request $request)
    {
        
        $message = Message::create([
            'message' => $request->message,
        ]);

        MessageUsers::create([
            'message_id' => $message->id,
            'client_id' => $request->client_id,
            'user_id' => $request->user_id
        ]);

        return response()->json($message->load('messageUsers'), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getByCliente($clientId, $userId)
    {

        $client = Client::findOrFail($clientId);
        $user = User::findOrFail($userId);
        $messages = $client->messagesUsersAsCliente()
            ->where('user_id', $userId)
            ->with('message')
            ->get()
            ->pluck('message');

            return response()->json([
                'code' => 200,
                'status' => 'success',
                'messages' => $messages,
                'client' => $client,
                'user' => $user,
            ], 200);
    }
    public function getByUser($userId, $client_id)
    {
        $user = User::findOrFail($userId);
        $client = Client::findOrFail($client_id);
        //obtener los mensajes del cliente y del usuario
        $messages = $client->messagesUsersAsCliente()
            ->where('user_id', $userId)
            ->with('message')
            ->get()
            ->pluck('message');

        

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'messages' => $messages,
            'user' => $user,
            'client' => $client,
        ], 200);
    }
}
