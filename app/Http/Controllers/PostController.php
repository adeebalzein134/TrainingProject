<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Traits\ApiResponse;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;


class PostController extends Controller implements HasMiddleware
{
    public static function middleware() {
        return [
            new Middleware('auth:sanctum', except: ['index', 'show'])
        ];
    }

    use ApiResponse;

    public function index()
    {
        $posts = Post::all();

        if($posts->isEmpty())
            return $this->apiResponse('success', 'No Posts in database', null);

        return $this->apiResponse('success', 'All Posts', $posts);
    }

    public function store(Request $request)
    {
        $validatedFields = $request->validate([
            'title' => 'required|max:255',
            'body' => 'required'
        ]);

        $post = $request -> user() -> posts() -> create($validatedFields);
        return $this->apiResponse('success', 'Post Created Successfully', $post, 201);
    }

    public function show($id)
    {
        $post = Post::find($id);

        if (!$post) {
            return $this->apiResponse('error', 'No Post Found!', null, 404);
        }

        return $this->apiResponse('success', 'This is Post Number ' . $post->id, $post);
    }

    public function update(Request $request, $id)
    {
        $post = Post::find($id);
        if (!$post) {
            return $this->apiResponse('error', 'No Post Found!', null, 404);
        }

        $validatedFields = $request->validate([
            'title' => 'required|max:255',
            'body' => 'required'
        ]);
    
        $post->update($validatedFields);

        return $this->apiResponse('success', 'Post Updated', $post);
    }

    public function destroy($id)
    {
        $post = Post::find($id);
        if(!$post)
            return $this->apiResponse('error', 'No Psot Found!', null, 404);
        
        $post->delete();
        return $this->apiResponse('success', 'Post Deleted Successfully', null);
    }
}
