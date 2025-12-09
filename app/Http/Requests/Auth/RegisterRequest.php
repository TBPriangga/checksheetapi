<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'name' => [
                'required',
                'string',
                'min:3',
                'max:255',
                'regex:/^[a-zA-Z\s]+$/', // Hanya huruf dan spasi
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email',
            ],
            'phone' => [
                'nullable',
                'regex:/^(\+62|0)[0-9]{9,12}$/', // Format nomor Indonesia
                'unique:users,phone',
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'max:255',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/', // Min 1 uppercase, 1 lowercase, 1 number, 1 special char
            ],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'Nama wajib diisi.',
            'name.string' => 'Nama harus berupa teks.',
            'name.min' => 'Nama minimal 3 karakter.',
            'name.max' => 'Nama tidak boleh melebihi 255 karakter.',
            'name.regex' => 'Nama hanya boleh mengandung huruf dan spasi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.max' => 'Email tidak boleh melebihi 255 karakter.',
            'email.unique' => 'Email sudah terdaftar.',
            'phone.regex' => 'Format nomor telepon tidak valid (gunakan format Indonesia).',
            'phone.unique' => 'Nomor telepon sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.max' => 'Password tidak boleh melebihi 255 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak sesuai.',
            'password.regex' => 'Password minimal mengandung 1 huruf besar, 1 huruf kecil, 1 angka, dan 1 karakter spesial.',
        ];
    }
}
