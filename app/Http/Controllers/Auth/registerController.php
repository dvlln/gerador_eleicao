<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Support\Facades\DB;

class registerController extends Controller
{
    public function create(){
        return view('auth.register');
    }

    public function store(RegisterRequest $request){
        $data = $request->all(); //validated?
        $data['role'] = 'user';

        DB::beginTransaction();
        try {
            User::create($data);
            DB::commit();

            return redirect()->route('auth.login.home')->with('success', 'Contra criada com sucesso');
        } catch (Exception $exception) {
            DB::rollBack();
            return 'Mensagem: '. $exception->getMessage();
        }
    }
}
