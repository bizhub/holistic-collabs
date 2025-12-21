<?php

namespace Domain\User\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        abort_if(
            boolean: !$user || !$user->is_admin,
            code: Response::HTTP_NOT_FOUND,
        );

        return $next($request);
    }
}
