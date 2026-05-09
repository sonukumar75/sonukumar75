@extends('layouts.app')

@section('content')
<h1>Lab Test Workflow</h1>
<section class="card">
    <h2>Schedule Test</h2>
    <form method="post" action="{{ route('lab-tests.store') }}" class="grid">
        @csrf
        <label>Sample<select name="sample_id">@foreach ($samples as $sample)<option value="{{ $sample->id }}">{{ $sample->sample_code }} - {{ $sample->material_type }}</option>@endforeach</select></label>
        <label>Method<select name="test_method_id">@foreach ($methods as $method)<option value="{{ $method->id }}">{{ $method->standard_code }} - {{ $method->name }}</option>@endforeach</select></label>
        <label>Instrument<select name="instrument_id"><option value="">Manual / Not required</option>@foreach ($instruments as $instrument)<option value="{{ $instrument->id }}">{{ $instrument->asset_code }} - {{ $instrument->name }}</option>@endforeach</select></label>
        <label>Technician<select name="assigned_to"><option value="">Unassigned</option>@foreach ($technicians as $technician)<option value="{{ $technician->id }}">{{ $technician->name }}</option>@endforeach</select></label>
        <label>Scheduled At<input type="datetime-local" name="scheduled_at" required></label>
        <button>Schedule Test</button>
    </form>
</section>
<section class="card" style="margin-top: 1rem;">
    <h2>Test Register</h2>
    <table>
        <thead><tr><th>Sample</th><th>Method</th><th>Instrument</th><th>Technician</th><th>Status</th><th>Result</th></tr></thead>
        <tbody>
        @foreach ($tests as $test)
            <tr>
                <td>{{ $test->sample->sample_code }}</td>
                <td>{{ $test->method->name }}</td>
                <td>{{ $test->instrument?->name ?? 'Manual' }}</td>
                <td>{{ $test->technician?->name ?? 'Unassigned' }}</td>
                <td>{{ str($test->status)->headline() }}</td>
                <td>
                    <form method="post" action="{{ route('lab-tests.result', $test) }}" class="grid">
                        @csrf
                        @method('patch')
                        <input name="result_value" placeholder="Value" required>
                        <input name="result_unit" placeholder="Unit" required>
                        <select name="status"><option>awaiting_review</option><option>approved</option><option>rejected</option></select>
                        <button>Update</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $tests->links() }}
</section>
@endsection
