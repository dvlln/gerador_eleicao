<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Eleicao extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'start_date_eleicao', 'end_date_eleicao', 'start_date_inscricao', 'end_date_inscricao'];

    //relationships
    public function users(){
        return $this->belongsToMany(User::class)->withPivot('categoria', 'votacao_status', 'voto');
    }

    //mutators
    public function setStartDateEleicaoAttribute($value) {
        $this->attributes['start_date_eleicao'] = Carbon::createFromFormat('d/m/Y H:i', $value)->format('Y-m-d H:i:s');
    }

    public function setEndDateEleicaoAttribute($value) {
        $this->attributes['end_date_eleicao'] = Carbon::createFromFormat('d/m/Y H:i', $value)->format('Y-m-d H:i:s');
    }

    public function setStartDateInscricaoAttribute($value) {
        $this->attributes['start_date_inscricao'] = Carbon::createFromFormat('d/m/Y H:i', $value)->format('Y-m-d H:i:s');
    }

    public function setEndDateInscricaoAttribute($value) {
        $this->attributes['end_date_inscricao'] = Carbon::createFromFormat('d/m/Y H:i', $value)->format('Y-m-d H:i:s');
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
