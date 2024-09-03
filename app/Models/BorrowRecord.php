<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class BorrowRecord
 *
 * This class represents a record of a book being borrowed by a user
 */
class BorrowRecord extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable
     *
     * @var array<string>
     */
    protected $fillable = [
        "book_id",
        "user_id",
        "borrowed_at",
        "due_date",
        "returned_at",
    ];

    /**
     * Get the user that borrowed the book
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function User(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the book that was borrowed
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }
}
