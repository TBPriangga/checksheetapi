<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Factory as ValidationFactory;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'username' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * Support login dengan username ATAU email.
     */
    public function credentials(): array
    {
        $username = $this->get('username');

        // Jika input adalah email → gunakan kolom email
        if ($this->isEmail($username)) {
            return [
                'email' => $username,
                'password' => $this->get('password'),
            ];
        }

        // Jika bukan email → anggap username
        return [
            'username' => $username,
            'password' => $this->get('password'),
        ];
    }

    /**
     * Validate apakah input adalah format email yang valid.
     */
    private function isEmail(mixed $value): bool
    {
        if (! is_string($value)) {
            return false;
        }

        $factory = $this->container->make(ValidationFactory::class);

        return ! $factory->make(
            ['username' => $value],
            ['username' => 'email']
        )->fails();
    }

    /**
     * Custom error messages (opsional, lebih user-friendly)
     */
    public function messages(): array
    {
        return [
            'username.required' => 'Username atau email wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ];
    }
}