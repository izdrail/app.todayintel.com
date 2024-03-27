<?php

namespace App\Repositories;

use Waterhole\Models\Post;

class PostRepository
{
    final public function createPost(array $data): Post
    {
        return Post::findOrCreate($data);
    }
}