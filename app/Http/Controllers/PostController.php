<?php

// app/Http/Controllers/PostController.php
namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::latest()->paginate(10);
        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'hindi_title' => 'required|string|max:255',
            'eng_title'   => 'required|string|max:255',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $oldPosts = Post::all();
        foreach ($oldPosts as $old) {
            $old->delete();
        }

        $data = $request->only('hindi_title', 'eng_title');

        if ($request->hasFile('image')) {
            $filename = time().'_'.$request->image->getClientOriginalName();
            $request->image->move(public_path('upload_documents'), $filename);
            $data['image'] = $filename;
        }

        Post::create($data);

        return redirect()->route('posts.index')->with('success','Post created successfully.');
    }

    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $request->validate([
            'hindi_title' => 'required|string|max:255',
            'eng_title'   => 'required|string|max:255',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only('hindi_title', 'eng_title');

        if ($request->hasFile('image')) {
            if ($post->image && file_exists(public_path('assets/images/'.$post->image))) {
                unlink(public_path('upload_documents/'.$post->image));
            }

            $filename = time().'_'.$request->image->getClientOriginalName();
            $request->image->move(public_path('assets/images'), $filename);
            $data['image'] = $filename;
        }

        $post->update($data);

        return redirect()->route('posts.index')->with('success','Post updated successfully.');
    }

    public function destroy(Post $post)
    {
        if ($post->image && file_exists(public_path('uploads/'.$post->image))) {
            unlink(public_path('uploads/'.$post->image));
        }
        $post->delete();
        return redirect()->route('posts.index')->with('success','Post deleted successfully.');
    }
}
