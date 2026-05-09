@extends('layouts.app')

@section('content')
<h1>SaaS Tenants</h1>
<section class="card">
    <h2>Create Laboratory Tenant</h2>
    <form method="post" action="{{ route('tenants.store') }}" class="grid">
        @csrf
        <label>Laboratory Name<input name="name" required></label>
        <label>Billing Email<input type="email" name="billing_email" required></label>
        <label>Plan<select name="plan"><option>starter</option><option>professional</option><option>enterprise</option></select></label>
        <button>Create Tenant</button>
    </form>
</section>
<section class="card" style="margin-top: 1rem;">
    <table>
        <thead><tr><th>Name</th><th>Plan</th><th>Billing Email</th><th>Active</th></tr></thead>
        <tbody>
        @foreach ($tenants as $tenant)
            <tr><td>{{ $tenant->name }}</td><td>{{ str($tenant->plan)->headline() }}</td><td>{{ $tenant->billing_email }}</td><td>{{ $tenant->is_active ? 'Yes' : 'No' }}</td></tr>
        @endforeach
        </tbody>
    </table>
    {{ $tenants->links() }}
</section>
@endsection
