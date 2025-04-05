<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Profile;
use App\Models\Speciality;
use Illuminate\Http\Request;
use App\Http\Resources\Profile\ProfileResource;
use App\Http\Resources\Profile\ProfileCollection;

class SpecialityController extends Controller
{
    public function index()
    {

        $specialities = Speciality::get();
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
        ->get();
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
            // 'users' => $users,
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
