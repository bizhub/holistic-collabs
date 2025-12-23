<?php

namespace Domain\User\Data;

use Spatie\LaravelData\Data;

class UserFormData extends Data
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password,
        public string $clinic_id,
    ) {}

    public static function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'password_confirmation' => ['required'],
            'clinic_id' => ['required', 'uuid', 'exists:clinics,id'],
        ];
    }
}
