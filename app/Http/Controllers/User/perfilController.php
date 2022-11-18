<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;

class perfilController extends Controller
{
    public function store(User $users, Request $request){
        $data = $request->all();
        $data['password'] = bcrypt($data['password']);
        return response()->json($data);
    }
}
