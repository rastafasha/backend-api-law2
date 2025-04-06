<?php

namespace App\Http\Controllers;
use App\Http\Resources\Profile\ProfileCollection;
use App\Http\Resources\Profile\ProfileResource;
use App\Models\User;
use App\Models\Profile;
use App\Models\Speciality;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Support\Facades\Storage;


class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $this->authorize('index', User::class);

        $profiles = Profile::orderBy('id', 'desc')
            ->get();

            return response()->json([
                'code' => 200,
                'status' => 'Listar todos los Perfiles',
                'profiles' => ProfileCollection::make($profiles),
            ], 200);
    }

    public function profileStore(Request $request)
    {
        $profile = null;

        if($request->hasFile('imagen')){
            $path = Storage::putFile("users", $request->file('imagen'));
            $request->request->add(["avatar"=>$path]);
        }

        $request->request->add(["redessociales"=>json_encode($request->redessociales)]);
        $request->request->add(["precios"=>json_encode($request->precios)]);
        
        $profile = Profile::create($request->all());

        return response()->json([
            "message" => 200,
            "profile" => $profile,
        ]);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function profileShow(Profile $profile)
    {
        // $this->authorize('userShow', User::class);

        if (!$profile) {
            return response()->json([
                'message' => 'Profile not found.'
            ], 404);
        }

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'profile' => ProfileResource::make($profile),
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function profileUpdate(Request $request,  string $id)
    {
        $profile = Profile::findOrFail($id);
        

        if($request->hasFile('imagen')){
            if($profile->avatar){
                Storage::delete($profile->avatar);
            }
            $path = Storage::putFile("users", $request->file('imagen'));
            $request->request->add(["avatar"=>$path]);
        }

        $request->request->add(["redessociales"=>json_encode($request->redessociales)]);
        $request->request->add(["precios"=>json_encode($request->precios)]);
        

        $profile ->update($request->all());
        return response()->json([
            "message" => 200,
            // "profile" => $profile,
            "profile" => ProfileResource::make($profile),
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

        $profile =  Profile::where('id', $id)->first();

        if(!empty($profile)){

             // borrar
             $profile->delete();
             // devolver respuesta
             $data = [
                 'code' => 200,
                 'status' => 'success',
                 'profile' => $profile
             ];
         }else{
             $data = [
                 'code' => 404,
                 'status' => 'error',
                 'message' => 'el profile no existe'
             ];
         }

         return response()->json($data, $data['code']);
    }




     public function profileByUser ($user_id)
     {
         $profile = Profile::where('user_id', $user_id)->first();

         if (!$profile) {
             return response()->json([
                 'message' => 'Profile not found.'
             ], 404);
         }

         return response()->json([
             'code' => 200,
             'status' => 'success',
            //  'profile' => $profile,
             'profile' => ProfileResource::make($profile),
         ], 200);
     }

     public function updateStatus(Request $request, $id)
    {
        
        $profile = Profile::findOrfail($id);
        $profile->status = $request->status;
        $profile->update();
        // if($request->status ===2){
        //     Mail::to($profile->email)->send(new UpdateStatusMail($user));
        // }

        return $profile;
        
    }

    public function recientes()
    {
       
        $recientes = Profile::select('profiles.*', 'specialities.title as speciality_title')
            ->orderBy('profiles.created_at', 'DESC')
            ->join('specialities', 'profiles.speciality_id', '=', 'specialities.id')
            ->where('speciality_id', '>', 0)
            ->where('status', 2)
            ->get();

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'recientes' => ProfileCollection::make($recientes),
        ], 200);
    }

    public function destacados()
    {

        $destacados = Profile::
                with(["users"])
                ->where('rating', '>', 0)
                ->where('status', 2)
                ->where('speciality_id', '>', 0)
                ->get();
            return response()->json([
                'code' => 200,
                'status' => 'Listar Post destacados',
                'destacados' => ProfileCollection::make($destacados),
            ], 200);
    }
}
