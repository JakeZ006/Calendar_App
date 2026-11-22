<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['title', 'type', 'content', 'for_date', 'important', 'expirable', 'user_id'])]
class Note extends Model {}
