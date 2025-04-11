<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use Illuminate\Http\Request;
use App\Http\Resources\Favorite\FavoriteResource;
use App\Http\Resources\Favorite\FavoriteCollection;

class FavoriteController extends Controller
{
    public function index()
    {

        $favorites = Favorite::orderBy('id', 'ASC')
        ->get();
        
        return response()->json([
            'code' => 200,
            'status' => 'List favorites',
            // 'favorites' => $favorites,
            'favorites' => FavoriteCollection::make($favorites),
        ], 200);
    }

    public function show(Favorite $favorite)
    {

        if (!$favorite) {
            return response()->json([
                'message' => 'favorite not found.'
            ], 404);
        }

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'favorite' => $favorite,
        ], 200);
    }

    public function favoriteByUser ($user_id)
     {
         $favorite = Favorite::where('user_id', $user_id)->first();

         if (!$favorite) {
             return response()->json([
                 'message' => 'favorite not found.'
             ], 404);
         }

         return response()->json([
             'code' => 200,
             'status' => 'success',
            //  'favorite' => $favorite,
             'favorite' => FavoriteResource::make($favorite),
         ], 200);
     }
    public function favoriteByCliente ($cliente_id)
     {
         $favorite = Favorite::where('cliente_id', $cliente_id)->first();

         if (!$favorite) {
             return response()->json([
                 'message' => 'favorite not found.'
             ], 404);
         }

         return response()->json([
             'code' => 200,
             'status' => 'success',
            //  'favorite' => $favorite,
             'favorite' => FavoriteResource::make($favorite),
         ], 200);
     }

   

    public function favoriteStore(Request $request)
    {

        return Favorite::create($request->all());

    }

    public function favoriteUpdate(Request $request, $id)
    {
        $favorite = Favorite::findOrfail($id);
        $favorite->update();
        return $favorite;
    }

    public function favoriteDestroy(string $id)
    {
        $favorite = Favorite::findOrFail($id);
        $favorite->delete();

        return response()->json([
            "message" => 200
        ]);
    }

}
