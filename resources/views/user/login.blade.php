@extends('layout.layout')
@section('title', 'Login')
@section('content')
    <div class="login-container">
        <div class="login-form">
            <h1 class="h3 mb-3 fw-normal text-center">Enter in system</h1>
            <form action="{{route('user.loginUser')}}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Login</button>
                <div class="mt-3 text-center">
                    <p class="mb-0">Don't have an account? <a href="{{route('user.register')}}" class="link-primary">Register</a>
                    </p>
                </div>
            </form>
        </div>
    </div>
@endsection
