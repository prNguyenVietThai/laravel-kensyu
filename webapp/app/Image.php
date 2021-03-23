<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'url', 'post_id', 'is_thumbnail'
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
