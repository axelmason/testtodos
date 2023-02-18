<?php

namespace App\Http\Controllers;

use App\Http\Requests\Todo\CreateRequest;
use App\Models\Tag;
use App\Models\Todo;
use App\Services\TagService;
use App\Services\TodoService;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    public function createPage()
    {
        return view('todo.create');
    }

    public function create(CreateRequest $request, TodoService $service)
    {
        $data = $request->validated();

        $service->create($data);

        return to_route('home')->with('success', 'Todo успешно создан');
    }

    public function statusToggler(Request $r, TodoService $service)
    {
        $data = $r->all();

        $service->toggleStatus($data);

        return response()->json('', 204);
    }

    public function show(TodoService $service, TagService $tagService, $todoId)
    {
        $todo = $service->show($todoId);
        if($todo) {
            $tags = $tagService->userTags();
            $rights = $todo->created_by == auth()->user()->id;

            return view('todo.show', compact('todo', 'tags', 'rights'));
        }
        return abort(404);
    }

    public function uploadImage(Request $r, TodoService $service, $todoId)
    {
        $service->upload($todoId, $r->file('file'));

        return response()->json('', 204);
    }

    public function deleteImage(TodoService $service, $todoId)
    {
        $service->deleteImage($todoId);

        return back();
    }

    public function attachTags(Request $request, TodoService $service, $todoId)
    {
        $tags = $request->except('_token');

        $service->attachTags($todoId, $tags);

        return back();
    }

    public function detachTags(Request $request, TodoService $service, $todoId)
    {
        $tags = $request->except('_token');

        $service->detachTags($todoId, $tags);

        return back();
    }

    public function search(Request $request, TodoService $service)
    {
        $todos = $service->search($request);

        $tags = auth()->user()->tags;

        return view('home', compact('tags', 'todos'));
    }

    public function giveAccess(Request $r, TodoService $service, $todoId)
    {
        $email = $r->input('email');

        return $service->giveAccess($email, $todoId);
    }

    public function removeAccess(Request $request, TodoService $service, $todoId, $memberId)
    {
        return $service->removeAccess($todoId, $memberId);
    }
}
