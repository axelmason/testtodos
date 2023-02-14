<?php

namespace App\Http\Controllers;

use App\Http\Requests\Tag\CreateRequest;
use App\Services\TagService;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function create(CreateRequest $request, TagService $service)
    {
        $data = $request->validated();

        $create = $service->createTag($data);

        if($create) return response()->json(['tag' => $create]);

        return response()->json(['error' => 'Something wents wrong...'], 422);
    }

    public function delete(Request $request, TagService $service)
    {
        $service->delete($request->tagId);

        return response()->json('', 204);
    }
}
