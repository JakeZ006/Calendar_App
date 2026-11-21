<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['title', 'type', 'content', 'for_date', 'important', 'expirable', 'user_id'])]
class Note extends Model
{
    /** @return BelongsTo <User, $this> */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
