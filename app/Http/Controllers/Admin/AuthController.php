<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function login(Request $request){
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,

        ];

        if (Auth::attempt($credentials)) {
            
            if(Auth::user()->type!='Admin'){
                Auth::logout();
                toastr()->error('Sorry you do not have sign in permissions');
                return redirect()->back()->withInput();
            }else{
                
                toastr()->success('Login successfull');
                return redirect()->route('admin.dashboard');
            }
            
        } else {
            toastr()->error('Incorrect email or password');
            return redirect()->back()->withInput();
        }
    }

    public function logout(){
        Auth::logout();
        toastr()->warning('You are logout successfully');
        return redirect('/');
    }

    // public function forgetPassword(Request $request){
    //     dd($request);
    // }
    // public function resetPassword(Request $request){
    //     dd($request);
    // }
    public function forgetPassword(Request $request){
        $user = User::where('email',$request->email)->first();
        if($user){
            $user->code = rand(111111,999999);
            $user->save();
            $this->sendMail($user);
            toastr()->success('Password Reset Link Has Been Sent To You. Please Check Your Email');
            return redirect()->back();
        }
        else{
            toastr()->error('Invalid email');
            return redirect()->back();
        }
    }

    private function sendMail($user){
        // $user->email = 'siddiqueakbar560@gmail.com';
        $data = ['code' => $user->code];
        Mail::send('admin.mail.email', $data, function ($message) use ($user){
            $message->from('support@mail.com', 'Shree Balaji Wirenetting');
            $message->to($user->email, $user->name)
            ->subject('Reset Password');
        });
    }

   

    public function resetPassword(Request $request){
        $user = User::where('email',$request->email)->first();
        // dd($request);
        if($user){
            if($user->code != null){
                $user->password =$request->password;
                $user->code = null;
                $user->update();
                $user->password =$request->password;
                $user->code = null;
                $user->update();

                toastr()->success('Password reset successfuly');
                return redirect()->route('admin.login');
            }
            else{
                toastr()->error('Reset password link has been expired');
                return redirect()->back();
            }
        }
        else{
            toastr()->error('Invalid email please try again');
            return redirect()->back();
        }
        toastr()->success('Password reset successfuly');
        return redirect('login');
    }
}
