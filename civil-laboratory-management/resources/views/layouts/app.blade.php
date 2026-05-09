<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Civil Lab SaaS') }}</title>
    <style>
        body { margin: 0; font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif; background: #f5f7fb; color: #172033; }
        header { background: #12355b; color: white; padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center; }
        nav a { color: #dcecff; margin-left: 1rem; text-decoration: none; font-weight: 600; }
        main { max-width: 1180px; margin: 2rem auto; padding: 0 1rem; }
        .grid { display: grid; gap: 1rem; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); }
        .card { background: white; border-radius: 16px; padding: 1.25rem; box-shadow: 0 10px 30px rgba(18, 53, 91, .08); }
        .metric { font-size: 2rem; font-weight: 800; color: #12355b; }
        table { width: 100%; border-collapse: collapse; background: white; border-radius: 12px; overflow: hidden; }
        th, td { padding: .85rem; text-align: left; border-bottom: 1px solid #e8edf5; }
        th { background: #e9f2ff; color: #12355b; }
        input, select, textarea { width: 100%; padding: .7rem; border: 1px solid #cad5e2; border-radius: 10px; }
        button { background: #0f766e; color: white; border: 0; border-radius: 10px; padding: .75rem 1rem; font-weight: 700; cursor: pointer; }
        .status { background: #dcfce7; color: #166534; padding: .75rem 1rem; border-radius: 10px; margin-bottom: 1rem; }
    </style>
</head>
<body>
<header>
    <strong>Civil Laboratory SaaS</strong>
    <nav>
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <a href="{{ route('projects.index') }}">Projects</a>
        <a href="{{ route('lab-tests.index') }}">Lab Tests</a>
        <a href="{{ route('instruments.index') }}">Instruments</a>
    </nav>
</header>
<main>
    @if (session('status'))
        <div class="status">{{ session('status') }}</div>
    @endif
    @yield('content')
</main>
</body>
</html>
