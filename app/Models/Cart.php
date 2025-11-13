<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Cart extends Model
{
    protected $guarded = [];

    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class, "carts_books", "cart_id", "book_id")->withPivot("count");
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }
}
