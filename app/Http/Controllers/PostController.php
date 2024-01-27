<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommentResource;
use App\Http\Resources\PostResource;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends ApiController
{
    public function list()
    {
        //TODO give the pagination count as a get request query string.
        // if it does not set then use a constant
        //TODO filter posts bsed on title
        //TODO order posts based on created_at or published_at
        $pageCount = request()->get('page_count') ?? 3;

        // create a query
        $query = Post::query();

        // check filter
        if(request()->has('search')){
            $search = request()->get('search');
            $query->where('title', 'like', "%$search%");
        }

        $orderBy = request()->get('order_by') ?? 'created_at';
        $orderDir = request()->get('order_dir') ?? 'desc';
        $query->orderBy($orderBy, $orderDir);

        $posts= $query->paginate($pageCount);
        return PostResource::collection($posts);
    }

    public function show(Post $post)
    {

        //TODO use paginaion for comments or limit comments then create anther route
        // to paginate comments of a post
        // $pageCount = request()->get('page_count') ?? 3;
        // $query = Post::query();

        $post->load('comments');
        $post->loadCount('comments', 'likes');
        // $post= $query->paginate($pageCount);
        // $post=Post:: paginate($pageCount);
        return new PostResource($post);
        // return $this->SuccessResponse([
        //     'post'=>new PostResource($post),
        //     // 'Comments'=>CommentResource::collection($post->comments),
        // ],'Show Post Successful',200);
    }

    public function Comment(Request $request,Post $post)
    {
        // it's better use another controller for this function like CommentController
        $Comment=$post->Comments()->Create([
            'user_id'=> Auth::user()->id,
            'content'=> $request->content,
        ]);
        return $this->SuccessResponse(new CommentResource($Comment),'Create Comment Successful',201);
    }

    public function Like(Post $post)
    {
        $post->likes()->firstOrCreate([
            'user_id' => Auth::user()->id
        ]);
        return $this->SuccessResponse($post,'This post was liked',201);
    }
}
