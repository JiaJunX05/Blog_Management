<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use App\Models\Image;

class GuestController extends Controller
{
    public function dashboard() {
        $posts = Post::with(['image', 'user'])
                    ->get();
        return view('dashboard', compact('posts'));
    }

    public function viewPost($id) {
        $post = Post::with('image')->find($id);
        return view('view', compact('post'));
    }
}
