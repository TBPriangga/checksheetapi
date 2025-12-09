<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('user');
        if ($id instanceof \App\Models\User) {
            $id = $id->id;
        }

        return [
            'name' => ['sometimes','required','string','max:255'],
            'email' => ['sometimes','required','email','max:255','unique:users,email,'.$id],
            'username' => ['nullable','string','max:255','unique:users,username,'.$id],
            'npk' => ['nullable','string','max:255'],
            'dept_id' => ['nullable','integer'],
            'position_id' => ['nullable','integer'],
            'detail_dept_id' => ['nullable','integer'],
            'password' => ['nullable','string','min:8'],
        ];
    }
}