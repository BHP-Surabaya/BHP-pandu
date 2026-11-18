<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Validation\Rule;
use Throwable;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        if ($this->has('nik') && is_string($this->nik) && str_starts_with($this->nik, 'eyJ')) {
            try {
                $decrypted = $this->nik;
                while (str_starts_with($decrypted, 'eyJ')) {
                    $decrypted = Crypt::decryptString($decrypted);
                }
                $this->merge(['nik' => $decrypted]);
            } catch (Throwable) {
                // If invalid encrypted payload, leave as is
            }
        }
    }

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
            'foto_profil' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:5120'],
            'hapus_foto_profil' => ['nullable', 'boolean'],
            'sk_notaris' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:25600'],
            'sk_ppat' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:25600'],
            'berita_acara_sumpah' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:25600'],
            'id_card_pengacara' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:25600'],
        ];
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'foto_profil.image' => 'File foto profil harus berupa gambar.',
            'foto_profil.mimes' => 'Format foto profil harus JPG, JPEG, PNG, atau WEBP.',
            'foto_profil.max' => 'Ukuran foto profil maksimal 5MB.',
        ];
    }
}
