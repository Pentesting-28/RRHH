<?php

namespace App\Http\Controllers\API\Auth;

use Hash;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Auth\Role;
use App\User;
use Carbon\Carbon;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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

    /**
     * Registro de usuario
     */
    public function signup(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'role_id' => 'required',
            'password' => 'required|string|confirmed'
        ]);
        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'role_id' => $request->role_id,
            'password' => bcrypt($request->password)
            ]);

        $user->save();

            $user->company()->sync($request->company_id);
            $user->permission()->sync($request->permissions);

        $user_new = User::where('id', $user->id)->with('role','company','permission')->first();

            return response()->json([
                'data' => $user_new,
                'message' => 'Registro Exitoso'
        ], 201);
    }

    /**
     * Login user and create token
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [boolean] remember_me
     * @return [string] access_token
     * @return [string] token_type
     * @return [string] expires_at
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);

        $credentials = request(['email', 'password']);

        if (!Auth::attempt($credentials))
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);

        $user = $request->user();
        $permission = $request->user()->permission()->get();        
        $roles = $request->user()->role()->first();

        if ($roles->name == 'admin') {
            $tokenResult = $user->createToken('isAdmin');
        } else {
            $tokenResult = $user->createToken('simpleUser');
        }
        $token = $tokenResult->token;

        $token->save();
        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'user' => $user,
            'permission' => $permission,
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ]);
    }

    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Salida Exitosa'
        ]);
    }

    /**
     * Get the authenticated User
     *
     * @return [json] user object
     */
    public function user(Request $request)
    {
        $user = $request->user();
        $role = User::where('email', $user->email)->with('role')->get();
        return response()->json([
            "data" => $role
        ]);
    }

    public function me()
    {
        $user = Auth::user();
        return response()->json([
            "data" => $user
        ]);
    }

    /**
     * Modificar contraseña admin
     *
     * @param
     * @return \Illuminate\Http\Response
     */
    /**
     * Modificar contraseña usuario logueado
     *
     * @param
     * @return \Illuminate\Http\Response
     */
    public function changePasswordUser(Request $request)
    {
        $request->validate([
           'old_password' => 'required|string',
           'password' => 'required|confirmed|min:6',
        ]);

        try {
            if (Hash::check($request->old_password, Auth::user()->password)) {
                $user           = User::find(Auth::user()->id);
                $user->Password = bcrypt($request->password);
                $user->update();
                $relation = User::where('id', $user->id)->with(
                    'role'
                )->first();
                return response()->json([
                    'message' => 'Contraseña actualizada con exito!',
                    'user'   => $relation,
                ], 201);

            } else {
                return response()->json([
                    'message' => 'La contraseña introducida es incorrecta'
                ], 400);
            }
        } catch (Exception $e) {
          return response()->json([
                'message' => $e->getMessage()
          ], 400);
        }

    }

    /**
     * Modificar contraseña admin
     *
     * @param
     * @return \Illuminate\Http\Response
     */
    public function adminPasswordChange(Request $request)
    {
        $request->validate([
           //
           'id' => 'required',
           'password' => 'required|confirmed|min:8',
        ]);

        try {
          $user = User::find($request->id);
          $user->password = bcrypt($request->password);
          $user->save();
          $relation = User::where('id', $user->id)->with(
            'role'
          )->first();
            return response()->json([
                    'message' => 'Contraseña actualizada con exito!',
                    'user'   => $relation,
                ], 201);
        } catch (Exception $e) {
          return response()->json([
                'message' => $e->getMessage()
          ], 400);
        }
    }
}
