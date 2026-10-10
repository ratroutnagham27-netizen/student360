<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\ParentConsent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ParentConsentController extends Controller
{
    /**
     * Show the first-login consent page.
     */
    public function show(): View
    {
        return view('parent-consent');
    }

    /**
     * Record the parent's consent + audit log, then redirect.
     */
    public function store(Request $request): RedirectResponse
    {
        $parent = $request->user();

        $consent = ParentConsent::create([
            'user_id'   => $parent->id,
            'agreed_at' => now(),
        ]);

        AuditLog::create([
            'user_id'        => $parent->id,
            'auditable_type' => ParentConsent::class,
            'auditable_id'   => $consent->id,
            'field'          => 'agreed_at',
            'old_value'      => null,
            'new_value'      => $consent->agreed_at->toDateTimeString(),
        ]);

        return redirect()->route('parent.dashboard');
    }
}