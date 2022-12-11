<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\Date;

class eleicaoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required',
            'start_date_inscricao' => 'required',
            'start_time_inscricao' => 'required',
            'end_date_inscricao' => ['required', 'after_or_equal:start_date_inscricao'],
            'end_time_inscricao' => 'required',
            'start_date_homologacao' => ['required', 'after_or_equal:end_date_inscricao'],
            'start_time_homologacao' => 'required',
            'end_date_homologacao' => ['required', 'after_or_equal:start_date_homologacao'],
            'end_time_homologacao' => 'required',
            'start_date_eleicao' => ['required', 'after_or_equal:end_date_homologacao'],
            'start_time_eleicao' => 'required',
            'end_date_eleicao' => ['required', 'after_or_equal:start_date_eleicao'],
            'end_time_eleicao' => 'required'
        ];
    }

    public function attributes(){
        return [
            'name' => 'Nome',
            'start_date_inscricao' => 'Data Inicial da Inscrição',
            'start_time_inscricao' => 'Hora Inicial da Inscrição',
            'end_date_inscricao' => 'Data Final da Inscrição',
            'end_time_inscricao' => 'Hora Final da Inscrição',
            'start_date_eleicao' => 'Data Inicial da Eleição',
            'start_time_eleicao' => 'Hora Inicial da Eleição',
            'end_date_eleicao' => 'Data Final da Eleição',
            'end_time_eleicao' => 'Hora Final da Eleição'

        ];
    }

    public function messages(){
        return[
            'required' => 'O campo :attribute deve ser preenchido',
            'start_date_eleicao.after_or_equal' => 'A data inicial de eleição deve ser maior ou igual a data final de inscrição',
            'after_or_equal' => 'A data final deve ser maior ou igual a inicial'
        ];
    }
}

