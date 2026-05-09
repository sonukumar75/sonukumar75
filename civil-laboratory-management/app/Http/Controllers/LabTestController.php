<?php

namespace App\Http\Controllers;

use App\Models\Instrument;
use App\Models\LabTest;
use App\Models\Sample;
use App\Models\TestMethod;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LabTestController extends Controller
{
    public function index(Request $request): View
    {
        $tenantId = $request->user()->tenant_id;

        return view('lab-tests.index', [
            'tests' => LabTest::with(['sample.project', 'method', 'instrument', 'technician'])
                ->where('tenant_id', $tenantId)
                ->latest()
                ->paginate(15),
            'samples' => Sample::where('tenant_id', $tenantId)->latest()->get(),
            'methods' => TestMethod::where('tenant_id', $tenantId)->where('is_active', true)->orderBy('name')->get(),
            'instruments' => Instrument::where('tenant_id', $tenantId)->whereIn('status', ['available', 'assigned'])->orderBy('name')->get(),
            'technicians' => User::where('tenant_id', $tenantId)->where('is_active', true)->orderBy('name')->get(),
            'statuses' => config('lab.test_statuses'),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $tenantId = $request->user()->tenant_id;
        $data = $request->validate([
            'sample_id' => ['required', Rule::exists('samples', 'id')->where('tenant_id', $tenantId)],
            'test_method_id' => ['required', Rule::exists('test_methods', 'id')->where('tenant_id', $tenantId)],
            'instrument_id' => ['nullable', Rule::exists('instruments', 'id')->where('tenant_id', $tenantId)],
            'assigned_to' => ['nullable', Rule::exists('users', 'id')->where('tenant_id', $tenantId)],
            'scheduled_at' => ['required', 'date'],
        ]);

        LabTest::create($data + [
            'tenant_id' => $tenantId,
            'status' => 'scheduled',
        ]);

        return back()->with('status', 'Lab test scheduled.');
    }

    public function updateResult(Request $request, LabTest $labTest): RedirectResponse
    {
        abort_unless($labTest->tenant_id === $request->user()->tenant_id, 403);

        $data = $request->validate([
            'result_value' => ['required', 'numeric'],
            'result_unit' => ['required', 'string', 'max:50'],
            'status' => ['required', Rule::in(['awaiting_review', 'approved', 'rejected'])],
            'review_notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $labTest->update($data + [
            'completed_at' => now(),
            'approved_by' => $data['status'] === 'approved' ? $request->user()->id : null,
        ]);

        return back()->with('status', 'Test result updated.');
    }
}
