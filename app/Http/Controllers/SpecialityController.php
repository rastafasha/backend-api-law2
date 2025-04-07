<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Profile;
use App\Models\Speciality;
use Illuminate\Http\Request;
use App\Http\Resources\Profile\ProfileResource;
use App\Http\Resources\Profile\ProfileCollection;
use App\Http\Resources\Speciality\SpecialityCollection;

class SpecialityController extends Controller
{
    public function index()
    {

        $specialities = Speciality::orderBy('id', 'ASC')
        ->get();
        //buscamos cuantos perfiles tiene cada especialidad
        $specialities = $specialities->map(function ($speciality) {
            $speciality->count_profiles = Profile::where('speciality_id', $speciality->
                id)
                ->where('status', 2)
                ->count();
            return $speciality;
        });
        return response()->json([
            'code' => 200,
            'status' => 'List specialities',
            'specialities' => $specialities,
            // 'specialities' => SpecialityCollection::make($specialities),
        ], 200);
    }

    public function filtradoMayorCero()
    {

        $specialities = Speciality::orderBy('id', 'ASC')
        ->get();
        //buscamos cuantos perfiles tiene cada especialidad
        $specialities = $specialities->map(function ($speciality) {
            $speciality->count_profiles = Profile::where('speciality_id', $speciality->
                id)
                ->where('status', 2)
                ->count();
            return $speciality;
        });
        //filtramos y mostramos las que tenga mas de 0
        $specialities = $specialities->filter(function ($speciality) {
            return $speciality->count_profiles > 0;
            });



        return response()->json([
            'code' => 200,
            'status' => 'List specialities',
            // 'specialities' => $specialities,
            'specialities' => SpecialityCollection::make($specialities),
        ], 200);
    }


    public function show(Speciality $speciality)
    {

        if (!$speciality) {
            return response()->json([
                'message' => 'speciality not found.'
            ], 404);
        }

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'speciality' => $speciality,
        ], 200);
    }

    public function showWithUsers(Speciality $speciality)
    {
        $users = Profile::where('speciality_id', $speciality->id)
        ->where('status', 2)
        ->paginate(10);
        // ->get();
        if (!$speciality) {
            return response()->json([
                'message' => 'speciality not found.'
            ], 404);
        }

        if (!$users) {
            return response()->json([
                'message' => 'users not found.'
            ], 404);
        }

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'speciality' => $speciality,
            // "users"=> $users
            // 'users' => $users ->map(
            //     function ($item) {
            //         return [
            //             'id' => $item->id,
            //             'nombre' => $item->nombre,
            //             'rating' => $item->rating,
            //             'surname' => $item->surname,
            //             'speciality_title' => $item->speciality_title,
            //              "avatar"=> $item->avatar ? env("APP_URL")."storage/".$item->avatar : NULL,
            //             'created_at' => $item->created_at,
            //             'updated_at' => $item->updated_at,
            //             ];
            //             }
            // ),
            "users" => ProfileCollection::make($users),
        ], 200);
    }

    public function specialityStore(Request $request)
    {

        return Speciality::create($request->all());

    }

    public function specialityUpdate(Request $request, $id)
    {
        $speciality = Speciality::findOrfail($id);
        $speciality->update();
        return $speciality;
    }

    public function specialityUpdateStatus(Request $request, $id)
    {
        $speciality = Speciality::findOrfail($id);
        $speciality->status = $request->status;
        $speciality->update();
        return $speciality;
    }

    public function destroy($id, Request $request)
    {

        $speciality =  Speciality::where('id', $id)->first();

        if(!empty($speciality)){

             // borrar
             $speciality->delete();
             // devolver respuesta
             $data = [
                 'code' => 200,
                 'status' => 'success',
                 'speciality' => $speciality
             ];
         }else{
             $data = [
                 'code' => 404,
                 'status' => 'error',
                 'message' => 'el speciality no existe'
             ];
         }

         return response()->json($data, $data['code']);
    }

    public function destacados()
    {

        $specialities = Speciality::
                where('isFeatured', $featured=true)
                ->get();
            return response()->json([
                'code' => 200,
                'status' => 'Listar specialities destacados',
                'specialities' => $specialities,
            ], 200);
    }

    public function search(Request $request){

        return Speciality::search($request->buscar);

    }

    
}
