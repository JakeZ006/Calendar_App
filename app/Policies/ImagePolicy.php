<?php

namespace App\Policies;

use App\Models\Image;
use App\Models\User;

class ImagePolicy
{
    public function delete(User $user, Image $image): bool
    {
        return $image->user_id === $user->id;
    }
}
