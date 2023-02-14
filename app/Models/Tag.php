<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = ['created_by', 'name'];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function todos()
    {
        return $this->belongsToMany(Todo::class, 'todo_tags', 'tag_id', 'todo_id');
    }
}
