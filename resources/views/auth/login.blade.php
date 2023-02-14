@extends('layouts.app')

@section('title', 'Авторизация')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-center">
            <div class="col-lg-4 col-12">
                <form action="{{ route('auth.login') }}" method="POST">
                    @csrf
                    <div class="d-flex flex-column mb-3">
                        <label for="email">Email</label>
                        <input name="email" type="email" class="form-control @error('email') is-invalid @enderror" placeholder="example@email.com">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="d-flex flex-column mb-3">
                        <label for="email">Пароль</label>
                        <input name="password" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="•••••••">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <button class="btn btn-outline-dark w-100">Войти</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
