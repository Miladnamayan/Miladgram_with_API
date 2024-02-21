<?php

namespace App\Http\Resources;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;


class PostResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return[
            'id'=>$this->id,
            'post_status'=>$this->post_status,
            'title'=>strtoupper($this->title),
            'body'=>$this->body,
            // 'picture'=>$this->picture,
            'picture'=> Storage::disk('public')->url($this->picture),
            'Number_of_likes' => $this->whenCounted('likes'),
            'Number_of_comments' =>  $this->whenCounted('comments'),
            'user_id'=>$this->user_id,
            'category_id'=>$this->category_id,
            'created_at'=>$this->created_at->format('Y-m-d'),
            'updated_at'=>$this->updated_at->format('Y-m-d'),
            'comments'=> $this->whenLoaded('comments')
        ];
    }
    public function with(Request $request)
    {
        return [
            'all' => [
                'key'=>'value',
            ]
        ];
    }



}
