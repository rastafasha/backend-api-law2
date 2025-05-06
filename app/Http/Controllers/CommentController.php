<?php

namespace App\Http\Controllers;

use App\Http\Resources\Comments\CommentResource;
use App\Models\Comments;
use App\Models\Solicitud;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\Comments\CommentCollection;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $this->authorize('index', User::class);

        $comments = Comments::orderBy('id', 'desc')
        ->paginate(10);
            // ->get();

            return response()->json([
                'code' => 200,
                'status' => 'Listar todos los Perfiles',
                'comments' => CommentCollection::make($comments),
            ], 200);
    }

    public function commentStore(Request $request)
    {
        $comment = null;
        $user = User::where('id', $request->user_id)->first();
        $client = User::where('id', $request->client_id)->first();
        if (!$user) {
            return response()->json([
                'message' => 'User not found.'
            ], 404);
        }
        if (!$client) {
            return response()->json([
                'message' => 'Client not found.'
            ], 404);
        }
        $solicitud = Solicitud::where('id', $request->solicitud_id)->first();
        if (!$solicitud) {
            return response()->json([
                'message' => 'Solicitud not found.'
            ], 404);
        }


        $comment = Comments::create($request->all());

        return response()->json([
            "message" => 200,
            "comment" => $comment,
        ]);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function commentShow(Comments $comment)
    {
        // $this->authorize('userShow', User::class);

        if (!$comment) {
            return response()->json([
                'message' => 'Comment not found.'
            ], 404);
        }

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'comment' => CommentResource::make($comment),
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function commentUpdate(Request $request,  string $id)
    {
        $comment = Comments::findOrFail($id);
        
        if (!$comment) {
            return response()->json([
                'message' => 'Comment not found.'
            ], 404);
        }
        $comment ->update($request->all());
        return response()->json([
            "message" => 200,
            // "comment" => $comment,
            "comment" => CommentResource::make($comment),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {

        $comment =  Comments::where('id', $id)->first();

        if(!empty($comment)){

             // borrar
             $comment->delete();
             // devolver respuesta
             $data = [
                 'code' => 200,
                 'status' => 'success',
                 'comment' => $comment
             ];
         }else{
             $data = [
                 'code' => 404,
                 'status' => 'error',
                 'message' => 'el comment no existe'
             ];
         }

         return response()->json($data, $data['code']);
    }




     public function commentByUser ($user_id)
     {
         $comment = Comments::where('user_id', $user_id)
         ->orderBy('created_at', 'ASC')
         ->get();

         if (!$comment) {
             return response()->json([
                 'message' => 'comment not found.'
             ], 404);
         }

         return response()->json([
             'code' => 200,
             'status' => 'success',
            //  'comment' => $comment,
             'comment' => CommentResource::make($comment),
         ], 200);
     }

     public function commentByClient ($client_id)
     {
         $comment = Comments::where('client_id', $client_id)
         ->orderBy('created_at', 'ASC')
         ->get();

         if (!$comment) {
             return response()->json([
                 'message' => 'comment not found.'
             ], 404);
         }

         return response()->json([
             'code' => 200,
             'status' => 'success',
            //  'comment' => $comment,
             'comment' => CommentResource::make($comment),
         ], 200);
     }

     public function commentBySolicitud (Request $request)
     {
         $comment = Comments::where('client_id', $request->client_id)
         ->where('user_id', $request->user_id)
         ->where('solicitud_id', $request->solicitud_id) 
         ->orderBy('created_at', 'ASC')
         ->get();

         if (!$comment) {
             return response()->json([
                 'message' => 'comment not found.'
             ], 404);
         }

         return response()->json([
             'code' => 200,
             'status' => 'success',
            //  'comment' => $comment,
             'comment' => CommentResource::make($comment),
         ], 200);
     }

     public function updateRating(Request $request)
    {
        
        $client = Comments::findOrfail($request->client_id);
        $user = Comments::findOrfail($request->user_id);
        $comment = Comments::where('user_id', $request->user_id)->where('client_id', $request->client_id)->first();
        
        $comment->rating = $request->rating;
        $comment->update();
        // if($request->status ===2){
        //     Mail::to($comment->email)->send(new UpdateStatusMail($user));
        // }

        return $comment;
        
    }

    public function recientes()
    {
       
        $recientes = Comments::orderBy('created_at', 'ASC')
            
            ->where('rating', '>', 0)
            ->paginate(10);

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'recientes' => $recientes,
            // 'recientes' => commentCollection::make($recientes),
        ], 200);
    }

    public function destacados()
    {

        $destacados = Comments::
                with(["users"])
                ->where('rating', '>', 0)
                ->where('status', 2)
                ->where('speciality_id', '>', 0)
                ->get();
            return response()->json([
                'code' => 200,
                'status' => 'Listar Post destacados',
                // 'destacados' => commentCollection::make($destacados),
                'destacados' => $destacados ->map(
                function ($item) {
                    return [
                        'id' => $item->id,
                        'user_id' => $item->user_id,
                        'nombre' => $item->nombre,
                        'rating' => $item->rating,
                        'surname' => $item->surname,
                        'speciality_id' => $item->speciality_id,
                         "avatar"=> $item->avatar ? env("APP_URL")."storage/".$item->avatar : NULL,
                        'created_at' => $item->created_at,
                        'updated_at' => $item->updated_at,
                        ];
                    }
                ),
            ], 200);
    }
}
