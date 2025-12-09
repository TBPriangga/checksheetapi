<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required','string','max:255'],
            'email' => ['required','email','max:255','unique:users,email'],
            'username' => ['nullable','string','max:255','unique:users,username'],
            'npk' => ['nullable','string','max:255'],
            'dept_id' => ['nullable','integer'],
            'position_id' => ['nullable','integer'],
            'detail_dept_id' => ['nullable','integer'],
            'password' => ['required','string','min:8'],
        ];
    }
}