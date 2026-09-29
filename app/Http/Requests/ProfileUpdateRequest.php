<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'nik' => ['nullable', 'string', 'max:16'],
            'phone' => ['nullable', 'string', 'max:20'],
            'pekerjaan' => ['nullable', 'string', 'max:255'],
            'alamat_kantor' => ['nullable', 'string', 'max:1000'],
            'alamat_ktp' => ['nullable', 'string'],
            'alamat_domisili' => ['nullable', 'string'],
            'sk_notaris' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:25600'],
        ];
    }
}
