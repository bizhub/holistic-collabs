<?php

namespace App\Http\Middleware;

use Domain\Clinic\Data\SharedClinicData;
use Domain\User\Data\SharedUserData;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $user = $request->user();
        $user?->loadMissing('clinic');

        return [
            ...parent::share($request),
            'name' => config('app.name'),
            'auth' => [
                'user' => $user
                    ? new SharedUserData(
                        is_admin: (bool)$user->is_admin,
                        name: $user->name,
                        email: $user->email,
                    ) : [
                        'is_admin' => false,
                        'name' => null,
                        'email' => null,
                    ],
                'clinic' => $user?->clinic ? SharedClinicData::from($user->clinic) : SharedClinicData::empty(),
            ],
            'sidebarOpen' => ! $request->hasCookie('sidebar_state') || $request->cookie('sidebar_state') === 'true',
        ];
    }
}
