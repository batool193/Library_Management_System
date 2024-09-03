<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Book
 *
 * This class represents a book in the library system
 */
class Book extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable
     *
     * @var array<string>
     */
    protected $fillable = [
        "title",
        "author",
        "type",
        "description",
        "published_at",
    ];

    /**
     * Get the borrow records associated with the book
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function BorrowRecords(): HasMany
    {
        return $this->hasMany(BorrowRecord::class);
    }
    /**
     * Get the ratings associated with the book
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function Ratings(): HasMany
    {
        return $this->hasMany(Rating::class);
    }

    /**
     * Scope a query to only include books by a specific author
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $author
     * @return \Illuminate\Database\Eloquent\Builder
     */

    public function scopeByAuthor($query, $author)
    {
        return $query->where('author', $author);
    }
    /**
     * Scope a query to only include books of a specific type
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }
}
