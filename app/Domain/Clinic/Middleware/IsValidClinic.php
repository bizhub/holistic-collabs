<?php

namespace Domain\Clinic\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsValidClinic
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        abort_if(
            boolean: !$user || !$user->clinic_id,
            code: Response::HTTP_NOT_FOUND,
        );

        return $next($request);
    }
}
