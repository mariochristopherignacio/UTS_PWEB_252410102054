
@extends('layouts.app')

@section('title', 'Login - SONORA')

@section('content')

    <div class="login-container">
        <div class="login-box">

            <h1>SONORA</h1>
            <p>Feel Every Frequency.</p>

            <h2>Welcome Back!</h2>
            <p>Masuk untuk menikmati musik favoritmu.</p>

            <form action="{{ route('login.process') }}" method="POST">
                @csrf

                <label>Username</label>

                <input
                    type="text"
                    name="username"
                    placeholder="Masukkan username"
                    required
                >

                <button type="submit">Masuk</button>
            </form>

        </div>
    </div>

@endsection
