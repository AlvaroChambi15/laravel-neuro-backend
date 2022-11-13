<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GroupImage extends Model
{
    use HasFactory, SoftDeletes;

    public function content()
    {
        return $this->belongsTo(Content::class);
    }
}