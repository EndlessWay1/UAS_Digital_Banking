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
        'author_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [];

    /**
     * Merge the News author to user table
     * 
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id')->withDefault(['name' => '[Deleted]']);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'timestamp' => 'datetime',
        ];
    }
}
