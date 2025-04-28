<?php

namespace App\Http\Controllers\Auth;

use App\Models\Role;
use App\Models\User;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Requests\AuthRequest;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\AuthLoginRequest;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\ChangePasswordRequest;
use Symfony\Component\HttpFoundation\Response;

;

class AuthController extends Controller
{
    // /**
    //  * Create a new AuthController instance.
    //  *
    //  * @return void
    //  */
    // public function __construct()
    // {
    //     $this->middleware('jwt.verify', ['except' => ['login', 'register']]);
    // }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = request()->only('email', 'password');

        if (! $token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized - Credenciales incorrectas'], 401);
        }

        $user = User::where('email', request('email'))->firstOrFail();

        $permissions = auth('api')->user()->getAllPermissions()->map(function($perm){
            return $perm->name;
        });
        return response()->json([
            'message' => "Inicio de sesión exitoso",
            'access_token' => $this->respondWithToken($token),
            'token_type' => 'Bearer',
            // 'user' => $user,
            'user'=>[
                "id"=>auth('api')->user()->id,
                "username"=>auth('api')->user()->username,
                // "avatar"=>auth('api')->user()->avatar,
                // "rolename"=>auth('api')->user()->rolename,
                "roles"=>auth('api')->user()->getRoleNames(),
                "email"=>auth('api')->user()->email,
                "permissions"=>$permissions,

            ],
        ], 201);
        
    }

    public function loginguest(Request $request)
    {
        $credentials = request()->only('email', 'password');

        if (! $token = auth('client-api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized - Credenciales incorrectas'], 401);
        }

        $user = Client::where('email', request('email'))->firstOrFail();

        $permissions = auth('client-api')->user()->getAllPermissions()->map(function($perm){
            return $perm->name;
        });
        return response()->json([
            'message' => "Inicio de sesión exitoso",
            'access_token' => $this->respondWithTokenClient($token),
            'token_type' => 'Bearer',
            // 'user' => $user,
            'user'=>[
                "id"=>auth('client-api')->user()->id,
                "username"=>auth('client-api')->user()->username,
                // "avatar"=>auth('client-api')->user()->avatar,
                // "rolename"=>auth('client-api')->user()->rolename,
                "roles"=>auth('client-api')->user()->getRoleNames(),
                "email"=>auth('client-api')->user()->email,
                "permissions"=>$permissions,

            ],
        ], 201);
        
    }

    /**
     * Register a User
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request) {

       // $data = $request->only('name', 'surname', 'email', 'password', 'n_doc');
       $data = $request->only('username',  'email', 'password', );

       $validator = Validator::make($data, [
           'username' => 'required|string|between:2,100',
           // 'name' => 'required|string|between:2,100',
           // 'surname' => 'required|string|between:2,100',
           // 'n_doc' => 'required',
           'email' => 'required|string|email|max:100|unique:users',
           'password' => 'required|string|min:5',
           'role' => Rule::in([User::GUEST]),
       ]);
       

       if($validator->fails()){
           return response()->json($validator->errors(), 422);
       }

       $user = User::create([
           'username' => $request->username,
           'email' => $request->email,
           'password' => Hash::make($request->password),
           'role' => User::GUEST,
       ]);

       $token = JWTAuth::fromUser($user);

       return response()->json([
           'message' => 'User registered successfully',
           'user' => $user,
           'access_token' => $token,
           'token_type' => 'Bearer',
       ], 201);

    }
    public function registerguest(Request $request) {

        // $data = $request->only('name', 'surname', 'email', 'password', 'n_doc');
        $data = $request->only('username',  'email', 'password', );

        $validator = Validator::make($data, [
            'username' => 'required|string|between:2,100',
            // 'name' => 'required|string|between:2,100',
            // 'surname' => 'required|string|between:2,100',
            // 'n_doc' => 'required',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|min:5',
            'role' => Rule::in([User::GUEST]),
        ]);
        

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        $user = Client::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => Client::GUEST,
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json([
            'message' => 'User registered successfully',
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer',
        ], 201);

    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth('api')->user());
    }
    
    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth('api')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        $permissions = auth('api')->user()->getAllPermissions()->map(function($perm){
            return $perm->name;
        });
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 180,
            // 'user'=>auth('api')->user(),
            'user'=>[
                // "avatar"=>auth('api')->user()->avatar,
                "username"=>auth('api')->user()->username,
                "email"=>auth('api')->user()->email,
                "permissions"=>$permissions,

            ],
        ]);
    }

    protected function respondWithTokenClient($token)
    {
        $permissions = auth('client-api')->user()->getAllPermissions()->map(function($perm){
            return $perm->name;
        });
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('client-api')->factory()->getTTL() * 180,
            // 'user'=>auth('client-api')->user(),
            'user'=>[
                // "avatar"=>auth('client-api')->user()->avatar,
                "username"=>auth('client-api')->user()->username,
                "email"=>auth('client-api')->user()->email,
                "permissions"=>$permissions,

            ],
        ]);
    }

    /**
     * Change password 
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function changePassword(ChangePasswordRequest $request)
    {
        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {

            return response()->json([
                'code' => 500,
                'status' => '¡La contraseña actual no coincide!',
                'user' => $user,
            ], 500);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json([
            'code' => 200,
            'status' => '¡Contraseña cambiada correctamente!',
            'user' => $user,
        ], 200);
    }
}
