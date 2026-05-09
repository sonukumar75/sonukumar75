<?php

namespace App\Http\Controllers;

use App\Models\Calibration;
use App\Models\Instrument;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class InstrumentController extends Controller
{
    public function index(Request $request): View
    {
        return view('instruments.index', [
            'instruments' => Instrument::with('calibrations')
                ->where('tenant_id', $request->user()->tenant_id)
                ->orderBy('next_calibration_due')
                ->paginate(15),
            'statuses' => config('lab.instrument_statuses'),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'asset_code' => ['required', 'string', 'max:80'],
            'name' => ['required', 'string', 'max:255'],
            'serial_number' => ['nullable', 'string', 'max:120'],
            'manufacturer' => ['nullable', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
            'status' => ['required', Rule::in(config('lab.instrument_statuses'))],
            'purchase_date' => ['nullable', 'date'],
            'next_calibration_due' => ['nullable', 'date'],
            'maintenance_notes' => ['nullable', 'string', 'max:1000'],
        ]);

        Instrument::create($data + ['tenant_id' => $request->user()->tenant_id]);

        return back()->with('status', 'Instrument registered.');
    }

    public function calibrate(Request $request, Instrument $instrument): RedirectResponse
    {
        abort_unless($instrument->tenant_id === $request->user()->tenant_id, 403);

        $data = $request->validate([
            'calibrated_on' => ['required', 'date'],
            'due_on' => ['required', 'date', 'after:calibrated_on'],
            'certificate_number' => ['required', 'string', 'max:120'],
            'agency_name' => ['required', 'string', 'max:255'],
            'result' => ['required', 'in:pass,fail,conditional'],
            'remarks' => ['nullable', 'string', 'max:1000'],
        ]);

        Calibration::create($data + [
            'tenant_id' => $request->user()->tenant_id,
            'instrument_id' => $instrument->id,
        ]);

        $instrument->update([
            'next_calibration_due' => $data['due_on'],
            'status' => $data['result'] === 'pass' ? 'available' : 'maintenance',
        ]);

        return back()->with('status', 'Calibration history updated.');
    }
}
