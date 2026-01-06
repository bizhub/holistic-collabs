<?php

namespace Domain\Invite\Data;

use Domain\User\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Spatie\LaravelData\Data;

/** @typescript */
class AcceptInviteData extends Data
{
    public function __construct(
        public $name,
        public $email,
        public $password,
    ) {}

    public static function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255'
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => [
                'required',
                'string',
                Password::default(),
                'confirmed'
            ],
        ];
    }
}
