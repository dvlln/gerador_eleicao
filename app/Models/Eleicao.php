<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Eleicao extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'start_date_eleicao', 'end_date_eleicao', 'start_date_inscricao', 'end_date_inscricao'];

    //relationships
    public function users(){
        return $this->belongsToMany(User::class)->withPivot('categoria', 'votacao_status', 'voto', 'voto_datetime', 'doc_user', 'doc_user_status', 'doc_user_message');
    }

    //accessors
    public function getStartDateEleicaoFormattedAttribute() {
        return Carbon::parse($this->start_date_eleicao)->format('d/m/Y H:i');
    }

    public function getEndDateEleicaoFormattedAttribute() {
        return Carbon::parse($this->end_date_eleicao)->format('d/m/Y H:i');
    }

    public function getStartDateInscricaoFormattedAttribute() {
        return Carbon::parse($this->start_date_inscricao)->format('d/m/Y H:i');
    }

    public function getEndDateInscricaoFormattedAttribute() {
        return Carbon::parse($this->end_date_inscricao)->format('d/m/Y H:i');
    }
}
