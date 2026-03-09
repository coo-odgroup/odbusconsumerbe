<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $table = "blogs";
    use HasFactory;

    protected $guarded = [];

    public function tags()
    {
        return $this->belongsToMany(
            BlogTag::class,
            'blog_tag_map',
            'blog_id',
            'tag_id'
        );
    }
}
