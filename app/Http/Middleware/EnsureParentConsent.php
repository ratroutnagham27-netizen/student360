<?php

namespace App\Http\Middleware;

use App\Enums\UserRole;
use App\Models\ParentConsent;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureParentConsent
{
    public function handle(
        Request $request,
        Closure $next
    ): Response {
        $user = $request->user();

        // Only parents require consent — teachers/admins pass through
        if ($user === null || $user->role !== UserRole::PARENT) {
            return $next($request);
        }

        $hasConsent = ParentConsent::where('user_id', $user->id)->exists();

        if (! $hasConsent) {
            return redirect()->route('parent.consent');
        }

        return $next($request);
    }
}