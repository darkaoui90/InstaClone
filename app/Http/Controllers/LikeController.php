<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request, Post $post)
    {
        $post->likes()->firstOrCreate([
            'user_id' => auth()->id(),
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'liked' => true,
                'likes_count' => $post->likes()->count(),
            ]);
        }

        return back();
    }

    public function destroy(Request $request, Post $post)
    {
        $post->likes()->where('user_id', auth()->id())->delete();

        if ($request->expectsJson()) {
            return response()->json([
                'liked' => false,
                'likes_count' => $post->likes()->count(),
            ]);
        }

        return back();
    }
}
