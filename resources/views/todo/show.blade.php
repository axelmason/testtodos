@extends('layouts.app')


@section('content')
    <div class="container">
        <div class="d-flex justify-content-center">
            <div class="col-lg-6 col-12">
                <div class="card">
                    <div class="card-header">{{ $todo->title }}</div>
                    <div class="card-body">
                        <div class="todo__image-wrapper">
                            <div class="todo-image">
                                @if ($todo->image)
                                    <img src="{{ asset('storage/' . $todo->image) }}" alt="">
                                @endif
                                @if ($rights)
                                <label for="image">
                                    <div class="btn btn-outline-dark btn-sm">{{ $todo->image ? 'Изменить' : 'Добавить' }}
                                    </div>
                                    <input type="file" name="image" id="image" accept="image/*"
                                        style="display: none;" class="add_image">
                                </label>
                                @endif
                                @if ($todo->image && $rights)
                                    <a href="{{ route('todo.deleteImage', $todo->id) }}" style="z-index: 1;"
                                        class="btn btn-outline-dark btn-sm">Удалить</a>
                                @endif
                            </div>
                        </div>
                        <p>{{ $todo->description ?? 'Описания нет' }}</p>
                        <div class="tags__block d-flex">
                            <p>Прикреплённые теги: </p>
                            <div class="tags__list">
                                <form action="{{ route('todo.detachTags', $todo->id) }}" method="POST">
                                    @csrf
                                    @foreach ($todo->tags as $tag)
                                        <label for="{{ $tag->id }}" class="tag-item mx-1">
                                            <span>{{ $tag->name }}</span>
                                            <input type="checkbox" name="{{ $tag->id }}" id="{{ $tag->id }}">
                                        </label>
                                    @endforeach
                                    @if ($rights)
                                        <button type="submit" class="btn btn-primary btn-sm">Убрать выбранные</button>
                                    @endif
                                </form>
                            </div>
                        </div>
                        @if ($rights)
                        <div class="tags__block d-flex">
                            <p>Все теги: </p>
                            <div class="tags__list">
                                <form action="{{ route('todo.attachTags', $todo->id) }}" method="POST">
                                    @csrf
                                    @foreach ($tags as $tag)
                                        <label for="{{ $tag->id }}" class="tag-item mx-1">
                                            <span>{{ $tag->name }}</span>
                                            <input type="checkbox" name="{{ $tag->id }}"
                                                id="{{ $tag->id }}">
                                        </label>
                                    @endforeach
                                    @if ($rights)
                                        <button type="submit" class="btn btn-primary btn-sm">Добавить выбранные</button>
                                    @endif
                                </form>
                            </div>
                        </div>
                        @endif
                        @if ($rights)
                            <div class="access-form-wrapper my-3">
                                <form action="{{ route('todo.giveAccess', $todo->id) }}" method="post">
                                    @csrf
                                    <div class="input-group d-flex flex-column">
                                        <label for="">Дать доступ к TODO</label>
                                        <input type="email" placeholder="Укажите email пользователя" name="email" class="form-control w-100">
                                        <button type="submit" class="btn btn-outline-dark my-1">Отправить</button>
                                    </div>
                                </form>
                                @if ($errors->has('msg'))
                                    <div class="text-danger">{{ $errors->first() }}</div>
                                @endif
                                @if (session()->has('msg'))
                                    <div class="text-success">{{ session()->get('msg') }}</div>
                                @endif
                                <table class="table table-bordered mt-2">
                                    <thead>
                                        <tr>
                                            <th colspan="3">Приглашенные участники</th>
                                        </tr>
                                        <tr>
                                            <th>#</th>
                                            <th>Email</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($todo->members as $member)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $member->email }}</td>
                                                <td>
                                                    <a href="{{ route('todo.removeAccess', [$todo->id, $member->id]) }}">Удалить</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p>Вы были приглашены как участник</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="todo-image-preview" style="display: none;">
        <div class="d-flex flex-column">
            <img src="" alt="" style="width: 150px; height: 150px;">
            <button class="upload btn btn-outline-dark my-3">Загрузить</button>
            <button class="cancel btn btn-outline-danger">отмена</button>
        </div>
    </div>
@endsection
