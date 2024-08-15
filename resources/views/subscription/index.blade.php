@extends('layout.layout')
@section('title', 'Product Subscription')
@section('content')
    <div class="form-container">
        <h1 class="text-center">Subscribe to price changes</h1>
        <form id="subscriptionForm" method="POST" action="{{ route('createSubscription') }}">
            @csrf
            <div class="form-group mb-2">
                <label for="url">Ad URL</label>
                <input type="url" class="form-control @error('url') is-invalid @enderror" id="url" name="url"
                       value="{{ old('url') }}" required placeholder="Enter ad URL">
                @error('url')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group mb-2">
                <label for="email">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                       value="{{ old('email') }}" required placeholder="Enter the email address to which notifications will be sent to you">
                @error('email')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary btn-block">Subscribe</button>
            {{-- Если есть сообщение об ошибке --}}
            @if (session('message'))
                <div class="alert alert-danger mt-3">
                    {{ session('message') }}
                </div>
            @endif
            @if (session('success'))
                <div class="alert alert-success mt-3">
                    {{ session('success') }}
                </div>
            @endif
        </form>
    </div>
@endsection
