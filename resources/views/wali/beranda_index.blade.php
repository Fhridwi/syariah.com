@extends('template.app')

@section('content')
    <h1>Selamat Datang wali</h1>

    @auth
        <p>Halo, {{ Auth::user()->name }}!</p>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit">Logout</button>
        </form>
    @else
        <p><a href="{{ route('login') }}">Login</a></p>
    @endauth
@endsection