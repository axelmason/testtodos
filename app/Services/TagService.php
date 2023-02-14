<?php

namespace App\Services;

use App\Models\Tag;

class TagService
{
    protected $model;

    public function __construct(Tag $model)
    {
        $this->model = $model;
    }

    public function createTag($data)
    {
        return $this->model->create($data+['created_by' => auth()->user()->id]);
    }

    public function delete($tagId)
    {
        $this->model->find($tagId)->delete();
    }

    public function userTags()
    {
        return auth()->user()->tags;
    }
}
