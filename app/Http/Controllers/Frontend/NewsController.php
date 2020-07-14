<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Post;

class NewsController extends Controller
{
    public function index()
    {
        $news = Post::paginate(10);
        return view('frontend.news.news', compact('news'));
    }

    public function newsDetail($slug)
    {
        $post = Post::where('slug', '=', $slug)->firstOrFail();
        return view('frontend.news.detail', compact('post'));
    }
}