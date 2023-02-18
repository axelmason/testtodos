<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image',
        'created_by',
        'status',
    ];

    public function author()
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'todo_tags', 'todo_id', 'tag_id');
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'shared_todos', 'todo_id', 'user_id');
    }
}
