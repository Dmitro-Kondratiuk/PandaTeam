<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Подписка на изменение цены</title>
    <link href="{{ "http://".$_SERVER['HTTP_HOST'] }}/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .form-container {
            max-width: 500px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .form-container h1 {
            margin-bottom: 20px;
        }
        .invalid-feedback {
            display: block;
        }
    </style>
</head>
<body>
<div class="form-container">
    <h1 class="text-center">Подписка на изменение цены</h1>
    <form id="subscriptionForm" method="POST" action="{{ route('createSubscription') }}">
        @csrf
        <div class="form-group mb-2">
            <label for="url">URL объявления</label>
            <input type="url" class="form-control @error('url') is-invalid @enderror" id="url" name="url" value="{{ old('url') }}" required placeholder="Введите URL объявления">
            @error('url')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="form-group mb-2">
            <label for="email">Email</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required placeholder="Введите ваш email">
            @error('email')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary btn-block">Подписаться</button>
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
<script type="text/javascript" src="{{ "http://".$_SERVER['HTTP_HOST'] }}/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
