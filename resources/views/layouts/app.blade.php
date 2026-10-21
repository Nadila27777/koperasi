<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ config('app.name', 'Koperasi') }}</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
</head>

<body>

    <nav class="navbar navbar-expand-lg bg-dark navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('dashboard') }}">
                Koperasi
            </a>

            @auth
                <div class="d-flex align-items-center gap-2">
                    <a href="{{ route('users.index') }}" class="btn btn-outline-light btn-sm">
                        Users
                    </a>

                    <form action="{{ route('logout') }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm">
                            Logout
                        </button>
                    </form>
                </div>
            @endauth
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
    </script>

</body>
</html>
