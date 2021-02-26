<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function like(Post $post, Request $request){



        $post->likes()->create([
            'user_id' => $request->user()->id,
        ]);

        return back();
    }


    public function unlike(Post $post, Request $request){
        $request->user()->likes()->where('post_id', $post->id)->delete();
        return back();
    }
}
