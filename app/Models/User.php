<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\CanResetPassword;

class User extends Authenticatable implements CanResetPassword
{
    use HasFactory;
    use Notifiable;

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
        return $this->belongsToMany(Eleicao::class)->withPivot('categoria', 'ocupacao', 'votacao_status', 'voto', 'voto_datetime', 'doc_user', 'doc_user_status', 'doc_user_message');
    }
}
