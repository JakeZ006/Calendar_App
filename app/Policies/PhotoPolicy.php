<?php

namespace App\Policies;

use App\Models\Photo;
use App\Models\User;

class PhotoPolicy
{
    public function delete(User $user, Photo $photo): bool
    {
        return $photo->user_id === $user->id;
    }
}
