<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
class PostController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth')->except('logout');
    // }

    public function index(){

        $posts = Post::orderBy('created_at', 'desc')->with(['user', 'likes'])->paginate(5); // get all post

        return view('posts.index', [
            'posts' => $posts
        ]);
    }

    public function store(Request $request){

        $this->validate($request, [
            'body' => 'required'
        ]);

        Post::create([
            'user_id' => auth()->user()->id,
            'body' => $request->body
        ]);

        return back();

        // auth()->user()->post()

    }

    public function delete(Post $post){

        

        $post->delete();
        return back();
    }

}
