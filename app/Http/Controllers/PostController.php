<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Media;
use App\Models\User;
use App\Models\FriendRequest;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
public function store(Request $request)
{
    $request->validate([
        'content' => 'required|string|max:2000',
        'media' => 'nullable|file|mimes:jpg,jpeg,png,gif,mp4,mov,avi|max:20480' // 20MB max
    ]);

    $post = new Post();
    $post->user_id = auth()->id();
    $post->content = $request->content;
    
    if ($request->hasFile('media')) {
        $file = $request->file('media');
        $path = $file->store('posts/media', 'public');
        
        $post->media_path = $path;
        $post->media_type = $file->getMimeType();
    }
    
    $post->save();

    return response()->json([
        'success' => true,
        'post' => $post->load('user')
    ]);
}

public function index()
{
    $posts = Post::with(['user', 'comments.user'])
                ->latest()
                ->paginate(10);
                
    return response()->json($posts);
}
}