<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>@yield('title')</title>
</head>

<body>
    <div class="container mt-3 mb-3">
        <div class="row" >
            <h2 style="float: left">ITP 405</h2>
            <h3 style="float: left">Spring 2021</h3>
            <h6 style="float: left">Richard Hernandez</h6>
            <h6 style="float: right">hern784@usc.edu</h6>
        </div>
        <div class="row">
            <div class="col-3">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="/">
                            Home
                        </a>
                    </li>
                    @if (Auth::check())
                        <li class="nav-item">
                            <a href="{{ route('profile.index') }}" class="nav-link">
                                Profile
                            </a>
                        </li>
                        <li>
                            <form method="post" action="{{ route('auth.logout') }}">
                                @csrf
                                <button type="submit" class="btn btn-link">
                                    Logout
                                </button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item">
                            <a href="{{ route('registration.index') }}" class="nav-link">
                                Register
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('auth.loginForm') }}" class="nav-link">
                                Login
                            </a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('track.index') }}">
                            Tracks
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('album.index') }}">
                            Albums
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('ealbum.index') }}">
                            Albums (Eloquent)
                        </a>
                    </li>
                    @can ('viewAny', App\Models\Invoice::class)
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('invoice.index') }}">
                                Invoices
                            </a>
                        </li>
                    @endcan
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('playlist.index') }}">
                            Playlist
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.maintenance') }}">
                            Admin
                        </a>
                    </li>

                </ul>
            </div>
            <div class="col-9">
                <header>
                    <h2>@yield('title')</h2>
                </header>
                @if (session('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('error')}}
                    </div>
                    @endif
                <main>
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    @yield('content')
                </main>
            </div>
        </div>
    </div>
</body>

</html>
