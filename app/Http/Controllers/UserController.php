<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;


class UserController extends Controller
{
    public function show (User $author)
    {
        return view('posts', [
            'posts' => $author->posts,
            'categories' => Category::all()
        ]);
    }
}
