<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class BlogPostController extends Controller
{
    public function store(StorePostRequest $request) {
        try {
            $post = Post::create([
                'user_id' => Auth::user()->id,
                'title'          => $request->title,
                'author'           => $request->author,
                'content'               => $request->content,
            ]);

            return redirect()->route('home')->with('success', 'Post created successfully');
            
        } catch (\Throwable $th) {
            return redirect()->route('home')->with('error', $th->getMessage());
        }
        return redirect()->route('home');
    }
}
