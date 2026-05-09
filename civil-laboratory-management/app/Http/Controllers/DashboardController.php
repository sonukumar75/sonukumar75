<?php

namespace App\Http\Controllers;

use App\Models\Instrument;
use App\Models\LabTest;
use App\Models\Project;
use App\Models\Sample;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request): View
    {
        $tenantId = $request->user()->tenant_id;

        return view('dashboard.index', [
            'projectCount' => Project::where('tenant_id', $tenantId)->count(),
            'sampleCount' => Sample::where('tenant_id', $tenantId)->count(),
            'pendingTests' => LabTest::where('tenant_id', $tenantId)->whereIn('status', ['scheduled', 'running', 'awaiting_review'])->count(),
            'calibrationDue' => Instrument::where('tenant_id', $tenantId)->whereDate('next_calibration_due', '<=', now()->addDays(30))->count(),
            'recentTests' => LabTest::with(['sample.project', 'method', 'instrument'])
                ->where('tenant_id', $tenantId)
                ->latest()
                ->limit(8)
                ->get(),
        ]);
    }
}
