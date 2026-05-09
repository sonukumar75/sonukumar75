@extends('layouts.app')

@section('content')
<h1>{{ $currentTenant->name ?? 'Laboratory' }} Dashboard</h1>
<div class="grid">
    <div class="card"><span>Active Projects</span><div class="metric">{{ $projectCount }}</div></div>
    <div class="card"><span>Samples Received</span><div class="metric">{{ $sampleCount }}</div></div>
    <div class="card"><span>Pending Tests</span><div class="metric">{{ $pendingTests }}</div></div>
    <div class="card"><span>Calibration Due Soon</span><div class="metric">{{ $calibrationDue }}</div></div>
</div>

<section class="card" style="margin-top: 1rem;">
    <h2>Recent Lab Tests</h2>
    <table>
        <thead><tr><th>Sample</th><th>Project</th><th>Method</th><th>Instrument</th><th>Status</th></tr></thead>
        <tbody>
        @forelse ($recentTests as $test)
            <tr>
                <td>{{ $test->sample->sample_code }}</td>
                <td>{{ $test->sample->project->name }}</td>
                <td>{{ $test->method->name }}</td>
                <td>{{ $test->instrument?->name ?? 'Manual' }}</td>
                <td>{{ str($test->status)->headline() }}</td>
            </tr>
        @empty
            <tr><td colspan="5">No lab tests have been scheduled yet.</td></tr>
        @endforelse
        </tbody>
    </table>
</section>
@endsection
