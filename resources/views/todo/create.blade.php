@extends('layouts.app')

@section('title', 'Создать TODO')

@section('content')
    <div class="container">
        <div class="card py-3">
            <div class="d-flex justify-content-center">
                <div class="col-lg-4 col-12">
                    <form action="{{ route('todo.create') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="d-flex flex-column mb-3">
                            <label for="title">Заголовок</label>
                            <input name="title" type="text" class="form-control @error('title') is-invalid @enderror" placeholder="Например, убраться">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="d-flex flex-column mb-3">
                            <label for="description">Описание (необязательно)</label>
                            <textarea name="description" style="resize: none;" class="form-control @error('description') is-invalid @enderror"></textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="d-flex flex-column mb-3">
                            <label for="image">Изображение</label>
                            <input name="image" accept="image/*" type="file" class="form-control @error('image') is-invalid @enderror" placeholder="Например, убраться">
                            <small class="form-text">Вы также можете прикрепить изображение позднее.</small>
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <button class="btn btn-outline-dark w-100">Добавить</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
