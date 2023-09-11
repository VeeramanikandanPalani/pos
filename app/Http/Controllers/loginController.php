<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class loginController extends Controller
{
    public function index(){
        return view('login');
    }

    public function addUser(Request $request){

        $request->validate(
            [
                'email' =>'required',
                'password' =>'required'
            ]
        );

        $user = new User;
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->save();
        Auth::login($user);
        return redirect('/home');
    }

    public function validateUser(Request $request){

        $request->validate(
            [
                'email' =>'required',
                'password' =>'required'
            ]
        );
        $email = $request->input('email');
        $password = $request->input('password');

        if(Auth::attempt(['email' => $email,'password' => $password,'status' => 1])) {
            $user = User::where('email',$email)->first();
            Auth::login($user);
            return redirect('/home');
        }else{
            return back()->withErrors(['Invalid Credentials']);
        }

    }

    public function logout(){
        Auth::logout();
        return redirect('/');
    }
}
