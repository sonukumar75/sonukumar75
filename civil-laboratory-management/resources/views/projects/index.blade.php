@extends('layouts.app')

@section('content')
<h1>Civil Projects</h1>
<section class="card">
    <h2>Add Project</h2>
    <form method="post" action="{{ route('projects.store') }}" class="grid">
        @csrf
        <label>Code<input name="code" required></label>
        <label>Name<input name="name" required></label>
        <label>Client<input name="client_name" required></label>
        <label>Status<select name="status"><option>planned</option><option>active</option><option>on_hold</option><option>completed</option></select></label>
        <label>Site Address<input name="site_address"></label>
        <label>Contact Person<input name="contact_person"></label>
        <label>Start Date<input type="date" name="start_date"></label>
        <label>End Date<input type="date" name="end_date"></label>
        <button>Add Project</button>
    </form>
</section>
<section class="card" style="margin-top: 1rem;">
    <h2>Project Register</h2>
    <table>
        <thead><tr><th>Code</th><th>Name</th><th>Client</th><th>Status</th><th>Site</th></tr></thead>
        <tbody>
        @foreach ($projects as $project)
            <tr><td>{{ $project->code }}</td><td>{{ $project->name }}</td><td>{{ $project->client_name }}</td><td>{{ str($project->status)->headline() }}</td><td>{{ $project->site_address }}</td></tr>
        @endforeach
        </tbody>
    </table>
    {{ $projects->links() }}
</section>
@endsection
