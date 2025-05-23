<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Patient\Patient;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\User\UserResource;
use App\Http\Resources\User\UserCollection;
use App\Http\Resources\Profile\ProfileResource;
use App\Http\Resources\Patient\PatientCollection;

class AdminUserController extends Controller
{
    // /**
    //  * Create a new AuthController instance.
    //  *
    //  * @return void
    //  */
    // public function __construct()
    // {
    //     $this->middleware('jwt.verify');
    // }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

       
        
        $users = User::select([
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
                'status' => 'Listar todos los Usuarios',
                'users' => $users,
            ], 200);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function userShow(User $user)
    {
        // $this->authorize('view', User::class);

        if (!$user) {
            return response()->json([
                'message' => 'User not found.'
            ], 404);
        }

        $user = User::select([
            "id", "username", "email", "created_at"
        ])
            // ->with([
            //     // "payments",
            //     "profiles",
            // ])
            // ->with([
            //     // "payments",
            //     "profile",
            // ])
            ->find($user);

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'user' => $user,
            // 'user' => UserResource::make($user),
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function userUpdate( $request, User $user)
    {
        // $this->authorize('update', User::class);

        try {
            DB::beginTransaction();

            $input = $this->userInput($user);
            $user->fill($input)->update();

            DB::commit();
            return response()->json([
                'code' => 200,
                'status' => 'Update user success',
                'user' => $user,
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
    public function userDestroy(User $user)
    {
        // $this->authorize('delete', User::class);
        
        try {
            DB::beginTransaction();

            $user->delete();

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

    protected function userInput(): array
    {
        return [
            "name" => request("name"),
            "email" => request("email"),
            "rolename" => request("rolename"),
        ];
    }

    public function recientes()
    {
        // $this->authorize('recientes', User::class);

        $users = User::orderBy('created_at', 'DESC')
        ->get();

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'users' => $users
        ], 200);
    }

    public function search(Request $request){

        return User::search($request->buscar);

    }


    public function showNdoc($n_doc)
    {
       
        $data_patient = [];
       
        
        $user = User::where('n_doc', $n_doc)
        ->orderBy('id', 'desc')
        ->first();;
        $patient = Patient::where('n_doc', $n_doc)
        ->orderBy('id', 'desc')
        ->first();;
        
            return response()->json([
                'code' => 200,
                'status' => 'Listar patient by n_doc',
                "user" => $user,
                "patient" => $patient,
                // "user" => PatientCollection::make($user) ,
                // "patient" => PatientCollection::make($patient) ,
            ], 200);
    }
}
