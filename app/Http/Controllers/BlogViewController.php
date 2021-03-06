<?php

namespace App\Http\Controllers;

use App\Blog;
use Illuminate\Http\Request;

class BlogViewController extends Controller
{
    public function index()
    {
        // $blogs = Blog::get();
        $blogs = Blog::with('user')
        ->onlyOpen()
        ->withCount('comments')->orderByDesc('comments_count')->get();

        return view('index', compact('blogs'));
    }

    public function show(Blog $blog)
    {      
        if ($blog->isClosed()) {
            abort(403);
        }
        return view('blog.show', compact('blog'));
    }
}
