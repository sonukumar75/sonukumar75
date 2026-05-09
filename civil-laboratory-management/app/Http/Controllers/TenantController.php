<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TenantController extends Controller
{
    public function index(): View
    {
        return view('tenants.index', ['tenants' => Tenant::latest()->paginate(20)]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'billing_email' => ['required', 'email', 'max:255'],
            'plan' => ['required', 'in:starter,professional,enterprise'],
        ]);

        Tenant::create($data + [
            'slug' => Str::slug($data['name']).'-'.Str::lower(Str::random(5)),
            'trial_ends_at' => now()->addDays(14),
            'is_active' => true,
        ]);

        return back()->with('status', 'Laboratory tenant created.');
    }
}
