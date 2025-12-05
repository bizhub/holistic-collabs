<?php

namespace App\Http\Controllers\Client;

use Inertia\Inertia;

class ClientIndexController
{
    public function __invoke()
    {
        return Inertia::render('Client/Clients');
    }
}
