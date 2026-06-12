<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\WallPost;
use App\Services\PusherService;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function get(Request $request) {
        $posts = WallPost::where('approved', $request->approved)->orderBy('id', 'DESC');

        return PostResource::collection($posts->get());
    }

    public function approve(WallPost $post) {
        $post->approved = 1;
        $post->visible = 1;
        $post->save();

        $resource = new PostResource($post);

        PusherService::sendNotification($resource, 'approve');

        return $resource;
    }

    public function revert(WallPost $post) {
        $post->approved = 0;
        $post->visible = 0;
        $post->save();

        $resource = new PostResource($post);

        PusherService::sendNotification($resource, 'remove');

        return $resource;
    }

    public function deny(WallPost $post) {
        $post->approved = -1;
        $post->visible = 0;
        $post->save();

        $resource = new PostResource($post);

        return $resource;
    }
}
