<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'content',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'author_id',
    ];

    /**
     * Merge the News author to user table
     * 
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id')->withDefault(['name' => '[Deleted]']);
    }
}
