<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Rating
 *
 * This class represents a rating given by a user to a book
 */
class Rating extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable
     *
     * @var array<string>
     */
    protected $fillable = ['user_id', 'book_id', 'rating', 'review'];

    /**
     * Get the user that gave the rating
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function User(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the book that was rated
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }
}
