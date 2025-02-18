@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-body p-5">
                    <h2 class="text-center mb-4">Login</h2>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email') }}" required autofocus>
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                   id="password" name="password" required>
                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label" for="remember">Ingat Saya</label>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Login</button>
                        </div>

                        <div class="text-center mt-4">
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-decoration-none">
                                    Lupa Password?
                                </a>
                            @endif
                        </div>

                        <hr class="my-4">

                        <div class="text-center">
                            Belum punya akun? 
                            <a href="{{ route('register') }}" class="text-decoration-none">Daftar sekarang</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
