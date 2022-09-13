<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Eleicao extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'startDate', 'endDate'];

    //mutators
    public function setStartDateAttribute($value) {
        $this->attributes['startDate'] = Carbon::createFromFormat('d/m/Y H:i', $value)->format('Y-m-d H:i:s');
    }

    public function setEndDateAttribute($value) {
        $this->attributes['endDate'] = Carbon::createFromFormat('d/m/Y H:i', $value)
        ->format('Y-m-d H:i:s');
    }

    //accessors
    public function getStartDateFormattedAttribute() {
        return Carbon::parse($this->startDate)->format('d/m/Y H:i');
    }

    public function getEndDateFormattedAttribute() {
        return Carbon::parse($this->endDate)->format('d/m/Y H:i');
    }
}
