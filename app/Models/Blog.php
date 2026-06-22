<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model
{
    protected $table = "blogs";
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    public function tags()
    {
        return $this->belongsToMany(
            BlogTag::class,
            'blog_tag_map',
            'blog_id',
            'tag_id'
        )->whereNull('blog_tag_map.deleted_at');
    }
}
