<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'writer', 'cover_image', 'description', 'rate'];

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}
