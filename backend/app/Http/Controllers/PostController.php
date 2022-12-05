<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::query()
            ->onlyOpen()
            ->with('user')
            ->withCount('comments')
            ->orderByDesc('comments_count')
            ->get();

        return view('posts.index', compact('posts'));
    }

    public function show(Post $post)
    {
        if ($post->isClosed())
        {
            abort(403);
        }
        $comments = $post->comments()->oldest()->get();
        
        return view('posts.show', compact(['post', 'comments']));
    }
}
