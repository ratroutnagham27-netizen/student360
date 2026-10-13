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
     * Uses firstOrCreate so pressing the button twice does not
     * create duplicate rows or duplicate audit log entries.
     */
    public function store(Request $request): RedirectResponse
    {
        $parent = $request->user();

        $consent = ParentConsent::firstOrCreate(
            ['user_id' => $parent->id],
            ['agreed_at' => now()]
        );

        // Only log on the first creation
        if ($consent->wasRecentlyCreated) {
            AuditLog::create([
                'user_id'        => $parent->id,
                'auditable_type' => ParentConsent::class,
                'auditable_id'   => $consent->id,
                'field'          => 'agreed_at',
                'old_value'      => null,
                'new_value'      => $consent->agreed_at->toDateTimeString(),
            ]);
        }

        return redirect()->route('parent.dashboard');
    }
}