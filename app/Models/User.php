<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    protected $table = 'users';
    protected $fillable = ['name', 'email', 'cpf', 'password', 'role', 'foto'];

    //hidden - impede que o atributo apareça em uma consulta
    protected $hidden = ['password'];

    //mutators
    public function setPasswordAttribute($value){
        $this->attributes['password'] = bcrypt($value); //CRIPTOGRAFA A SENHA
    }

    //relationships
    public function eleicoes(){
        return $this->belongsToMany(Eleicao::class)->withPivot('categoria', 'votacao_status', 'voto', 'doc_user', 'doc_user_status', 'doc_user_message');
    }
}
