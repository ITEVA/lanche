<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CargoRequest extends FormRequest
{
	public function authorize()
	{
		return true;
	}

	public function rules()
	{
		return [
			'nome' => 'required',
			'valor' => 'required'
		];
	}

	public function messages()
	{
		return [
			'required' => 'O campo :attribute não pode ser vazio.',
			'max' => 'O campo :attribute excedeu o valor máximo de caracteres.',
		];
	}
}
