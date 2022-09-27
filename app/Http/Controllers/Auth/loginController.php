<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\UserService;

class loginController extends Controller
{
    public function home(){
        return view('auth.login');
    }

    public function in(Request $request){
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if(Auth::attempt($credentials)){
            $userRole = auth()->user()->role;

            return redirect(UserService::getDashboardRouteBasedOnUserRole($userRole));
        }

        return  redirect()->route('auth.login.home')->with('warning', 'Autenticação falhou');
    }
    
    public function destroy(){
        Auth::logout();
        return redirect()->route('auth.login.home');
    }
}
