<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Secretaria, User};

use Illuminate\Support\Facades\Auth;

class userController extends Controller
{
    public function index(){
        $users = User::find(Auth::id());

        return view('user.dashboard.index', [
            'users' => $users,
            'secretarias' => Secretaria::find(1)
        ]);
    }
}
