<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Traits\ApiResponse;

class PostController extends Controller
{
    use ApiResponse;

    public function index()
    {
        $posts = Post::all();

        return $this->apiResponse('success', 'All Posts', $posts);
    }

    public function store(Request $request)
    {
        $validatedFields = $request->validate([
            'title' => 'required|max:255',
            'body' => 'required'
        ]);

        $post = Post::create($validatedFields);
        return $this->apiResponse('success', 'Post Created Successfully', $post, 201);
    }

    public function show(Post $post)
    {
        return $this->apiResponse('success', 'This is Post Number ' .  $post['id'], $post);
    }

    public function update(Request $request, Post $post)
    {
        $validatedFields = $request->validate([
            'title' => 'required|max:255',
            'body' => 'required'
        ]);
    
        $post->update($validatedFields);

        return $this->apiResponse('success', 'Post Updated', $post);
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return $this->apiResponse('success', 'Post Deleted Successfully', null);
    }
}
