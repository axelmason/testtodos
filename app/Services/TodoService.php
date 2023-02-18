<?php

namespace App\Services;

use App\Models\Tag;
use App\Models\Todo;
use App\Models\User;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class TodoService
{
    protected $model;

    public function __construct(Todo $model)
    {
        $this->model = $model;
    }

    public function create($data)
    {
        $todo = $this->model->create($data+['created_by' => auth()->user()->id]);

        if(isset($data['image'])) {
            $this->upload($todo['id'], $data['image']);
        }
    }

    public function toggleStatus($data)
    {
        $todo = Todo::find($data['todoId']);
        $todo->completed = !$todo->completed;
        $todo->save();
    }

    public function show($todoId)
    {
        return $this->model->with('tags')
            ->where('created_by', auth()->user()->id)
            ->orWhereHas('members', function ($query) {
                $query->where('users.id', auth()->user()->id);
        })->find($todoId);
    }

    public function upload($todoId, UploadedFile $file)
    {
        $todo = Todo::find($todoId);

        if($todo->image) {
            $this->deleteImage($todoId);
        }

        $filename = 'todo_'.$todo->title.'.'.$file->getClientOriginalExtension();
        $file->storeAs('user_'.auth()->user()->id, $filename, ['disk' => 'public']);

        $todo->image = 'user_'.auth()->user()->id.'/'.$filename;
        $todo->save();
    }

    public function deleteImage($todoId)
    {
        $todo = Todo::find($todoId);
        Storage::disk('public')->delete($todo->image);
        $todo->image = null;
        $todo->save();
    }

    public function attachTags(int $todoId, array $tags)
    {
        $todo = Todo::find($todoId);
        $todo->tags()->syncWithoutDetaching(array_keys($tags));
    }

    public function detachTags(int $todoId, array $tags)
    {
        $todo = Todo::find($todoId);
        $todo->tags()->detach(array_keys($tags));
    }

    public function search(Request $data)
    {
        $query = Todo::query();

        $tags = array_keys($data->except('query'));
        $search = $data->input('query');

        if($tags) {
            $tagIds = Tag::whereIn('id', $tags)->pluck('id');

            $query->whereHas('tags', function ($query) use ($tagIds) {
                return $query->whereIn('tags.id', $tagIds);
            });
        }
        if($search) {
            $query->where('title', 'LIKE', "%$search%");
        }

        $query
            ->where('created_by', auth()->user()->id)
            ->orWhereHas('members', function($query) {
                $query->where('users.id', auth()->user()->id);
        });

        return $query->get();
    }

    public function giveAccess($email, $todoId)
    {
        $todo = Todo::find($todoId);
        $user = User::where('email', $email)->first();

        if($user) {
            $todo->members()->syncWithoutDetaching($user->id);

            return back()->with('msg', "Пользователь {$user->email} добавлен в список участников.");
        } else {
            return back()->withErrors(['msg' => 'Пользователя с таким email не существует']);
        }
    }

    public function removeAccess($todoId, $memberId)
    {
        $todo = Todo::find($todoId);
        $user = User::where('id', $memberId)->first();

        $todo->members()->detach($user->id);

        return back()->with('msg', "Пользователь $user->email удалён из участников.");
    }
}
