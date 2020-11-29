<?php

namespace App\Http\Controllers\Api;

use App\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\ApiLoginRequest;
use App\Http\Requests\ApiRegisterRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Auth;

class AuthController extends Controller
{
	public function login(ApiLoginRequest $request) {
		$user=User::where('email', request('email'))->first();
		$credentials=request(['email', 'password']);
		if ($user->state==0) {
			return response()->json(['message' => 'Este usuario no tiene permitido ingresar.'], 401);
		} elseif(Auth::attempt($credentials)) {

			$user=$request->user();
			$tokenResult=$user->createToken('Personal Access Token');

			$token=$tokenResult->token;
			if (!is_null(request('remember'))) {
				$token->expires_at=Carbon::now()->addWeeks(1);
			}
			$token->save();

			return response()->json(['access_token' => $tokenResult->accessToken, 'token_type' => 'Bearer', 'expires_at' => Carbon::parse($token->expires_at)->toDateTimeString()]);
		}
		
		return response()->json(['message' => 'Las credenciales no coinciden.'], 401);
	}

	public function signUp(ApiRegisterRequest $request) {
		$count=User::where('name', request('name'))->where('lastname', request('lastname'))->count();
		$slug=Str::slug(request('name')." ".request('lastname'), '-');
		if ($count>0) {
			$slug=$slug."-".$count;
		}

        // Validación para que no se repita el slug
		$num=0;
		while (true) {
			$count2=User::where('slug', $slug)->count();
			if ($count2>0) {
				$slug=Str::slug(request('name')." ".request('lastname'), '-')."-".$num;
				$num++;
			} else {
				$data=array('name' => request('name'), 'lastname' => request('lastname'), 'slug' => $slug, 'email' => request('email'), 'password' => Hash::make(request('password')));
				break;
			}
		}

		$user=User::create($data);

		if ($user) {
			return response()->json(['message' => 'Registro de usuario exitoso.']);
		} else {
			return response()->json(['message' => 'Ha ocurrido un problema, inténtelo nuevamente.']);
		}
	}

	public function logout(Request $request) {
		$request->user()->token()->revoke();
		return response()->json(['message' => 'La sesión ha sido cerrada exitosamente.'], 200);
	}

	public function profile(Request $request) {
		$user=$request->user()->only("id", "name", "lastname", "slug", "photo", "email", "email_verified_at", "state", "type");
		$user["photo"]=asset('/admins/img/admins')."/".$user["photo"];
		$user["state"]=($user["state"]==1) ? "Activo" : "Inactivo";
		$user["type"]=typeUser($user["type"], 0);
		return response()->json(["data" => $user], 200);
	}

	// public function orders(Request $request) {
	// 	$orders=$request->user()->orders;
	// 	return response()->json(["data" => $orders], 200);
	// }

	// public function order(Request $request, $order) {
	// 	$order=$request->user()->orders->where("id", $order);
	// 	if (!is_null($order)) {
	// 		return response()->json(["data" => $orders], 200);
	// 	}
		
	// 	return response()->json(["message" => "Este pedido no pertenece a este usuario."], 404);
	// }
}
