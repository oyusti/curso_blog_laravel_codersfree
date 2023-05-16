<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    public function author(User $user, Post $post){
        return $post->user_id == $user->id;
    }

    public function published(?User $user, Post $post){
        return $post->is_published;
    }

    /**
     * Create a new policy instance.
     *
     * @return void
     */
}
