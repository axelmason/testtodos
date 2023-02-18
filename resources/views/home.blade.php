@extends('layouts.app')

@section('content')
    <div class="container">
        @auth
            <div class="tags__block d-flex">
                @if (!$tags->count())
                    <i>Тегов пока нет...</i>
                @else
                    <div class="tags__list">
                        @foreach ($tags as $tag)
                            <span class="tag-item" data-tag="{{ $tag->id }}">
                                <span class="tag-name">{{ $tag->name }}</span>
                                <span class="delete-tag-button">&times;</span>
                            </span>
                        @endforeach
                    </div>
                @endif
                <div class="create-tag-block mx-4">
                    <span>#</span>
                    <input type="text" class="create-tag-input" placeholder="tag">
                    <span class="create-tag-button">+</span>
                </div>
            </div>
            <hr>
            <div class="todos__block mt-3">
                <a href="{{ route('todo.createPage') }}" class="btn btn-outline-dark">Создать TODO</a>
                <table class="todos__table table table-hover">
                    <tbody>
                        @forelse ($todos as $todo)
                            <tr>
                                <td style="width: 50px;">
                                    <div data-id="{{ $todo->id }}" data-status="{{ $todo->completed }}" class="status-button btn @if($todo->completed) btn-success @else btn-outline-success @endif rounded-circle"></div>
                                </td>
                                <td class="inline-block">
                                    <div class="todo-img-wrapper d-inline" style="max-width: 50px;">
                                        <img style="max-width: 50px;" src="{{ asset('storage/'.$todo->image) }}" alt="">
                                    </div>
                                    <span class="ms-1">
                                        {{ $todo->title }}
                                    </span>
                                </td>
                                <td>
                                    @foreach ($todo->tags as $tag)
                                        <span class="tag-item" data-tag="{{ $tag->id }}">
                                            <span class="tag-name">{{ $tag->name }}</span>
                                        </span>
                                    @endforeach
                                </td>
                                <td class="todo-actions">
                                    <a href="{{ route('todo.show', $todo->id) }}">Посмотреть</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" align="center"><i>У вас пока нет задач...</i></td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        @endauth
    </div>
@endsection
