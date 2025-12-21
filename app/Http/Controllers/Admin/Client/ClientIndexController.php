<?php

namespace App\Http\Controllers\Admin\Client;

use Domain\Client\Data\ClientData;
use Domain\Client\Models\Client;
use Inertia\Inertia;

class ClientIndexController
{
    public function __invoke()
    {
        $clients = Client::query()
            ->with('clinic')
            ->withCount('commissions')
            ->get();

        return Inertia::render('Admin/Client/Clients', [
            'clients' => ClientData::collect($clients),
        ]);
    }
}
