<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class userController extends Controller
{
    public function index(){
        return view('user.dashboard.index');
    }

    public function viewEleicao(){
        return view ('user.eleicao.viewEleicao');
    }


}
