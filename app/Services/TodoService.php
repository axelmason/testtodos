<?php

namespace App\Services;

use App\Models\Todo;
use Illuminate\Http\File;
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
        return $this->model->create($data+['created_by' => auth()->user()->id]);
    }

    public function toggleStatus($data)
    {
        $todo = Todo::find($data['todoId']);
        $todo->completed = !$todo->completed;
        $todo->save();
    }

    public function show($todoId)
    {
        return $this->model->with('tags')->find($todoId);
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
        $todo->tags()->attach(array_keys($tags));
    }

    public function detachTags(int $todoId, array $tags)
    {
        $todo = Todo::find($todoId);
        $todo->tags()->detach(array_keys($tags));
    }
}
