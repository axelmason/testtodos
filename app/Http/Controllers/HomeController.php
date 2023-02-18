<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home()
    {
        if(auth()->check()) {
            $tags = auth()->user()->tags;
            $todos = Todo::query()
                ->where('created_by', auth()->user()->id)
                ->orWhereHas('members', function($query) {
                    $query->where('users.id', auth()->user()->id);
                })->get();

            return view('home', compact('tags', 'todos'));
        }

        return view('home');
    }
}
