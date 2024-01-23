<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AuthorController extends ApiController
{

    /**
     * Show the form for creating a new resource.
     */
    public function Create(PostRequest $request){
            //  چه کد زیر رو بزارم چه نزارم ، کد زیر اجرا میشه؟
            // if($request->failedValidation){
            //     return $this->ErrorResponse($request->messages(),422);
            // }
            // اسم عکس رو یونیک میکنه
        $pictureName=Carbon::now()->microsecond .'.' . $request->picture->extension();
        $request->picture->storeAs('picture/posts',$pictureName,'public');
            // حالا برای اینکه کاربر به پوشه استوریج دسترسی نداره و بیاد توی پابایک
            // php artisan storage:link
        $post= Post::Create([
            'title'=>  $request->title,
            'body'=> $request->body,
            'picture'=> $pictureName,
            'user_id'=> $request->user_id,
            'category_id'=> $request->category_id,
        ]);
        return $this->SuccessResponse(new PostResource($post),'Create Post Successful',201);

    }

 


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, post $post)
    {
        // dd($post);
        // dd($request);
        $pictureName=Carbon::now()->microsecond .'.' . $request->picture->extension();
        $request->picture->storeAs('picture/posts',$pictureName,'public');

        if (Gate::allows('delete', $post)) {
            $post->Update([
                'title'=>  $request->has('title')? $request->get('title') : $post->title,
                'body'=> $request->has('body')  ? $request->get('body') : $post->body,
                'picture'=> $request->has('picture')? $pictureName : $post->picture,
            ]);
            return $this->SuccessResponse(new PostResource($post),'Update Post Successful',200);
        } else {
            return $this->ErrorResponse('Only the post creator can Update this post',401);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(post $post)
    {
        if (Gate::allows('delete', $post)) {
            $post->delete();
            return $this->SuccessResponse(new PostResource($post),'Delete Post Successful',200);
        } else {
            return $this->ErrorResponse('Only the post creator can delete this post',401);

        }
    }


    public function Permission(post $post)
    {

        if (Gate::allows('update', $post)) {
            if ($post) {
                $post->post_status = $post->post_status ? 0 : 1;
                $post->save();
                return $this->SuccessResponse(new PostResource($post),'Permission to print the post was successful',200);
            }
        } else {
            return $this->ErrorResponse('Only the post creator can Permission to print this post',401);

        }
    }
}
