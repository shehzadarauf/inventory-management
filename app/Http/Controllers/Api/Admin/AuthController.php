<?php

namespace App\Http\Controllers\Api\Admin;

use App\Helpers\Api;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function forgetPassword(Request $request){
        $user = User::where('email',$request->email)->first();
        if($user){
            $user->code = rand(111111,999999);
            $user->save();
            $this->sendMail($user);
            return Api::setResponse('user',$user);
           
        }
        else{
            return Api::setError('Invalid email');
        }
    }

    private function sendMail($user){
        $data = ['code' => $user->code];
        Mail::send('email', $data, function ($message) use ($user){
            $message->from('support@mail.com', 'Shree Balaji Wirenetting');
            $message->to($user->email, $user->name)
            ->subject('Reset Password');
        });
    }

    public function resetPassword(Request $request){
        $user = User::where('email',$request->email)->first();
        // dd($request);
        if($user){
            if($user->code == $request->code){
                $user->password =$request->password;
                $user->code = null;
                $user->update();
            }
            else{
               return Api::setError('Invalid code please try again');
            }
        }
        else{
            return Api::setError('Invalid email please try again');
        }
        return Api::setMessage('Password reset successfuly');
    }
}
