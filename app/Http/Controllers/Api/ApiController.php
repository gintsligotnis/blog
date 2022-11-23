<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use App\Http\Resources\PostResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;


class ApiController
{
    private const POST_LIMIT = 5;

    public function getLatest(): AnonymousResourceCollection
    {
        $posts = Post::getPublicPosts(self::POST_LIMIT);

        return PostResource::collection($posts);
    }

}
