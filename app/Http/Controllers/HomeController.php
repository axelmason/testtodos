<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home()
    {
        if(auth()->check()) {
            $tags = auth()->user()->tags;
            $todos = auth()->user()->todos;

            return view('home', compact('tags', 'todos'));
        }

        return view('home');
    }
}
