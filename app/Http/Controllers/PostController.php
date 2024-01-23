<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Http\Resources\CommentResource;
use App\Http\Resources\PostResource;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends ApiController
{
    public function list()
    {
        $posts=post::paginate(3);
        return $this->SuccessResponse([
            'posts'=>PostResource::collection($posts),
            'links'=>PostResource::collection($posts)->response()->getData()->links,
            'meta'=>PostResource::collection($posts)->response()->getData()->meta
        ],'',200);
        // return $this->ErrorResponse('Error',500);
    }

    public function show(post $post)
    {
        return $this->SuccessResponse([
            'post'=>new PostResource($post),
            'Comments'=>CommentResource::collection($post->comments),
        ],'Show Post Successful',200);
    }

    public function Comment(Request $request,post $post)
    {
        $Comment= Comment::Create([
            // $Comment=$post->Comments()->Create([
            'user_id'=> Auth::user()->id,
            'post_id'=> $request->post_id,
            'content'=> $request->content,
        ]);
        return $this->SuccessResponse(new CommentResource($Comment),'Create Comment Successful',201);
    }

    public function Like(post $post)
    {
        $post->likes()->firstOrCreate([
            'user_id' => Auth::user()->id
        ]);
        return $this->SuccessResponse($post,'This post was liked',201);
    }
}
