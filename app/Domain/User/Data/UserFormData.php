<?php

namespace Domain\User\Data;

use Spatie\LaravelData\Data;

/** @typescript */
class UserFormData extends Data
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password,
        public string $password_confirmation,
        public ?string $clinic_id,
        public ?bool $is_admin,
    ) {}

    public static function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'password_confirmation' => ['required'],
            'clinic_id' => ['nullable', 'required_unless:is_admin,true', 'uuid', 'exists:clinics,id'],
        ];
    }
}
