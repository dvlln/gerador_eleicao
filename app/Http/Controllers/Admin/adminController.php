<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class adminController extends Controller
{
    public function index(){
        $users = User::find(Auth::id());

        return view('admin.dashboard.index', [
            'users' => $users,
            'flag' => 0
        ]);
    }
}
