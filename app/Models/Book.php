<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    protected $guarded = [];

    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(Genre::class, "books_genres", "book_id", "genre_id");
    }

    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(Author::class, "books_authors", "book_id", "author_id");
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }


}
