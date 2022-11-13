<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    public function User()
    {
        return $this->belongsTo(User::class);
    }

    public function Unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function contents()
    {
        return $this->hasMany(Content::class);
    }

    public function coments()
    {
        return $this->hasMany(Coment::class);
    }
}