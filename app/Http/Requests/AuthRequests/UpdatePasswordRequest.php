<?php

namespace App\Http\Requests\AuthRequests;

use App\Rules\CurrentPasswordCheck;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'current_password' => ['required', new CurrentPasswordCheck($this->user())],
            'password' => 'required|string|min:8|confirmed',
        ];
    }
}
