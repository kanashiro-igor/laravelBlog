<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Category;


class UserController extends Controller
{
    public function show (User $author)
    {
        return view('posts.index', [
            'posts' => $author->posts
        ]);
    }
}
