<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {

        // validar
        $request->validate([
            "email" => "required|email",
            "password" => "required"
        ]);

        // verificar
        $credenciales = request(["email", "password"]);

        //return $request->user();

        /* if (!Auth::attempt($credenciales)) {
            return response()->json([
                "mensaje" => "No Autorizado"
            ], 401);
        } */

        if (!Auth::attempt($credenciales)) {
            return response()->json([
                "mensaje" => "NoAutorizado"
            ]);
        }


        // generar tonken
        $usuario = $request->user();
        $tokenResult = $usuario->createToken("login");
        $token = $tokenResult->plainTextToken;

        // responder    
        return response()->json([
            "access_token" => $token,
            "token_type" => "Bearer",
            "usuario" => $usuario
        ]);
    }

    public function registro(Request $request)
    {
        // return $request;
        //validar
        $request->validate([
            "name" => "required",
            "email" => "required|email|unique:users",
            "password" => "required",
            // "c_password" => "required|same:password"
        ]);

        // registro
        $usuario = new User();

        $usuario->name = $request->name;
        $usuario->email = $request->email;
        // $usuario->rol = $request->rol;
        $usuario->password = bcrypt($request->password);

        $usuario->save();

        // responder
        return response()->json(["mensaje" => "Usuario Registrado"], 201);
    }

    public function logout(Request $request)
    {
        // Obtenemos el id del token
        // $id = strtok($request->token, "|");

        // A MI FORMA :V
        /* DB::table('personal_access_tokens')->delete($id); */

        // Revoke a specific token...
        /* $request->user()->tokens()->where('id', $id)->delete(); */

        // Revocar el token que se usó para autenticar la solicitud actual...
        $request->user()->currentAccessToken()->delete();

        // $request->user()->tokens()->delete()->where('id', $idToken); //Elimina todos los tokens del usuario

        return response()->json([
            "mensaje" => "Logout"
        ]);
    }

    public function perfil(Request $request)
    {
        return response()->json($request->user());
    }

    public function updatePhotoUser(Request $request)
    {
        // return $request;
        $request->validate([
            "photo" => "required",
            "user_id" => "required"
        ]);
        $user = User::find($request->user_id);
        $user->photo = $request->photo;
        $user->save();

        return response()->json(["mensaje" => "Foto de Perfil Actualizada!"], 200);
    }

    public function updateNameUser(Request $request)
    {
        // return $request;
        $request->validate([
            "nombres" => "required",
            "user_id" => "required"
        ]);
        $user = User::find($request->user_id);
        $user->name = $request->nombres;
        $user->save();

        return response()->json(["mensaje" => "Nombre Actualizado!"], 200);
    }

    public function updateEmailUser(Request $request)
    {
        // return $request;
        $request->validate([
            // "email" => "required|email|unique:users",
            "email" => "required|email|unique:users,email,$request->user_id",
            "user_id" => "required"
        ]);
        $user = User::find($request->user_id);
        $user->email = $request->email;
        $user->save();

        return response()->json(["mensaje" => "Email Actualizado!"], 200);
    }

    public function updatePasslUser(Request $request)
    {

        /* $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:50|unique:users,email,' . $id,
            'password' => $this->passwordRules(),
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('id_usuario', $id);
        }

        $user = User::find($id);

        $user->forceFill([
            'password' => Hash::make($request['password']),
        ])->save();
 */
        // =========================



        $userAct = User::find($request->user_id);

        // Verificando si la contraseña es la actual
        if (!Hash::check($request->password, $userAct->password)) {
            return response()->json(["mensaje" => "contrasenaIncorrecta"], 404);
        }
        // =========================

        $request->validate([
            'password' => "required",
            "new_password" => "required",
            "confirm_password" => "required|same:new_password"
        ]);

        // return $request;
        $user = User::find($request->user_id);

        $user->forceFill([
            'password' => Hash::make($request['new_password']),
        ])->save();

        $user->save();

        return response()->json(["mensaje" => "ContrasenaActualizada"], 200);
    }
}