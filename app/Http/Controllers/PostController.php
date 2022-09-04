<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
	// Return all posts
    public function index()
    {
        return Post::all();
    }

	// Return single post
    public function read($id)
    {
		$post = Post::findOrFail($id);
        return $post;
    }

	// Create single post
    public function create(Request $request)
    {
		$validated = $request->validate([
			'title' => 'required|min:6',
            'slug' => 'required|unique:posts',
            'guid' => 'required|unique:posts',
            'content' => 'required',
			'enabled' => 'boolean',
			'user_id' => 'required|exists:App\Models\User,id'
		]);

		$post = Post::create($request->all());
        return response()->json($post, 201);
	}

	// Update existing post
    public function update(Request $request, $id)
    {
		$post = Post::findOrFail($id);

		$validated = $request->validate([
			'title' => 'required|min:6',
			'slug' => 'required|unique:posts,slug,'.$id,
			'guid' => 'required|unique:posts,guid,'.$id,
			'content' => 'required',
			'enabled' => 'boolean'
		]);

		$post->update($request->all());
		return $post;
    }

	// Delete post
    public function delete($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();
       	return response()->json(['message' => 'Post Deleted'], 200);
    }

}
