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
            'startDate' => ['required', 'date_format:d/m/Y'],
            'startTime' => ['required'],
            'endDate' => ['required', 'date_format:d/m/Y'],
            'endTime' => ['required']
        ];
    }

    public function attributes(){
        return [
            'name' => 'nome',
            'startDate' => 'data inicial',
            'startTime' => 'hora inicial',
            'endDate' => 'data final',
            'endTime' => 'hora inicial'
        ];
    }

    public function messages(){
        return[
            'date_format' => 'O campo :attribute não corresponde ao formato correto'
        ];
    }
}

