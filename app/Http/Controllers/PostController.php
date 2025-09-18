<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        return response() -> json([
            'status' => 'success',
            'message' => 'All Posts Fetched Successfully',
            'data' => Post::all()
        ], 200);
    }

    public function store(Request $request)
    {
        $validatedFields = $request->validate([
            'title' => 'required|max:255',
            'body' => 'required'
        ]);
    
        $post = Post::create($validatedFields);

        return response() -> json([
            'status' => 'success',
            'message' => 'Post Created Successfully',
            'data' => $post
        ], 201);
    }

    public function show(Post $post)
    {
        return response() -> json([
            'status' => 'success',
            'message' => 'This Is Post Number ' . $post['id'],
            'data' => $post
        ], 200);
    }

    public function update(Request $request, Post $post)
    {
        $validatedFields = $request->validate([
            'title' => 'required|max:255',
            'body' => 'required'
        ]);
    
        $post->update($validatedFields);

        return response() -> json([
            'status' => 'success',
            'message' => 'Post Updated',
            'data' => $post
        ], 200);
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return response() -> json([
            'status' => 'success',
            'message' => 'Post Deleted Successfully',
            'data' => null
        ], 200);
    }
}
