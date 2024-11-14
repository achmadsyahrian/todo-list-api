<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8',
        ];
    }

    // Custom validation rules
    // public function messages()
    // {
    //     return [
    //         'name.required' => 'Nama wajib diisi.',
    //         'email.required' => 'Email wajib diisi.',
    //         'email.email' => 'Email harus valid.',
    //         'email.unique' => 'Email telah dipakai.',
    //         'password.required' => 'Password wajib diisi.',
    //         'password.min' => 'Password minimal harus 8 karakter.',
    //     ];
    // }

}
