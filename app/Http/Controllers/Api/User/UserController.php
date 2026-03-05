<?php

namespace App\Http\Controllers\Api\User;

use App\Helpers\Api;
use App\Helpers\ApiValidate;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function register(Request $request){
        $credentials = ApiValidate::register($request, User::class);
        $user = User::create($credentials);
        return Api::setResponse('user', $user->withToken());
    }

    public function updateFirebaseToken(Request $request){
        $user=User::find($request->user_id);
        $user->firebase_token=$request->firebase_token;
        $user->update();
        return Api::setMessage('token updated');
    }
}
