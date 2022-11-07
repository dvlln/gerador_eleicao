<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class eleicaoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'start_date_inscricao' => ['required'],
            'start_time_inscricao' => ['required'],
            'end_date_inscricao' => ['required'],
            'end_time_inscricao' => ['required'],
            'start_date_eleicao' => ['required'],
            'start_time_eleicao' => ['required'],
            'end_date_eleicao' => ['required'],
            'end_time_eleicao' => ['required']
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
            'date_format' => 'O campo :attribute não corresponde ao formato correto'
        ];
    }
}

