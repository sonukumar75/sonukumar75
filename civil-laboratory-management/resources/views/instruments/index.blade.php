@extends('layouts.app')

@section('content')
<h1>Instrument Management</h1>
<section class="card">
    <h2>Register Instrument</h2>
    <form method="post" action="{{ route('instruments.store') }}" class="grid">
        @csrf
        <label>Asset Code<input name="asset_code" required></label>
        <label>Name<input name="name" required></label>
        <label>Serial Number<input name="serial_number"></label>
        <label>Manufacturer<input name="manufacturer"></label>
        <label>Location<input name="location"></label>
        <label>Status<select name="status">@foreach ($statuses as $status)<option>{{ $status }}</option>@endforeach</select></label>
        <label>Purchase Date<input type="date" name="purchase_date"></label>
        <label>Next Calibration Due<input type="date" name="next_calibration_due"></label>
        <label>Maintenance Notes<textarea name="maintenance_notes"></textarea></label>
        <button>Register Instrument</button>
    </form>
</section>
<section class="card" style="margin-top: 1rem;">
    <h2>Instrument Register</h2>
    <table>
        <thead><tr><th>Asset</th><th>Name</th><th>Status</th><th>Location</th><th>Calibration Due</th><th>Calibration Entry</th></tr></thead>
        <tbody>
        @foreach ($instruments as $instrument)
            <tr>
                <td>{{ $instrument->asset_code }}</td>
                <td>{{ $instrument->name }}</td>
                <td>{{ str($instrument->status)->headline() }}</td>
                <td>{{ $instrument->location }}</td>
                <td>{{ $instrument->next_calibration_due?->toFormattedDateString() ?? 'Not set' }}</td>
                <td>
                    <form method="post" action="{{ route('instruments.calibrate', $instrument) }}" class="grid">
                        @csrf
                        <input type="date" name="calibrated_on" required>
                        <input type="date" name="due_on" required>
                        <input name="certificate_number" placeholder="Certificate" required>
                        <input name="agency_name" placeholder="Agency" required>
                        <select name="result"><option>pass</option><option>fail</option><option>conditional</option></select>
                        <button>Save</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $instruments->links() }}
</section>
@endsection
