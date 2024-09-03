<?php

namespace App\Services;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Http\Requests\BookFormRequest;


/**
 * BookService
 * 
 * This service handles operations related to books, including fetching, creating, updating, and deleting books
 */
class BookService
{

  /**
   * Retrieve all books with optional filters for author, type
   *
   * @param Request $request The request containing optional filters
   * @return array The response containing the list of books and status code
   */
  public function allBooks(Request $request)
  {
    $books = Book::query();
    if ($request->has('author')) {
      $books = $books->ByAuthor($request->author);
    }
    if ($request->has('type')) {
      $books = $books->ByType($request->type);
    }
    $books = $books->withAvg('Ratings', 'rating')->get();
    return [
      'books' => $books,
      'status' => 201,
    ];
  }

  /**
   * Create a new book
   *
   * @param array $data The data for creating a new book
   * @return array The response containing the created book and status code
   */
  public function createBook(array $data)
  {
    $book = Book::create($data);
    return [
      'success' => true,
      'book' => $book,
      'status' => 201,
    ];
  }

  /**
   * Retrieve a specific book along with its ratings and average rating.
   *
   * @param int $book  the book to retrieve.
   * @return array The response containing the book, its ratings, average rating, and status code.
   */
  public function showBook($book)
  {
    $book = Book::findOrFail($book);
    $ratings = $book->ratings()->with('user')->get();
    $averageRating = $book->withAvg('ratings', 'rating');
    if (!$book) {
      return [
        'success' => false,
        'message' => 'not found',
        'status' => 404,
      ];
    }
    return [
      'success' => true,
      'data' => [
        'book' => $book,
        'ratings' => $ratings,
        'average rating' => $averageRating,
      ],
      'status' => 201,
    ];
  }

  /**
   * Update a specific book 
   *
   * @param array $data The data for updating the book
   * @param int $book  the book to update
   * @return array The response containing the updated book and status code
   */
  public function updateBook(array $data, $book)
  {
    $book = Book::findOrFail($book);
    $book->update($data);
    if (!$book) {
      return [
        'success' => false,
        'message' => 'not found',
        'status' => 404,
      ];
    }
    return [
      'success' => true,
      'book' => $book,
      'status' => 201,
    ];
  }

  /**
   * Delete a specific book 
   *
   * @param int $book  the book to delete
   * @return array The response indicating success or failure and status code
   */
  public function deleteBook($book)
  {
    $result = Book::findOrFail($book)->delete();
    if ($result) {
      return [
        'success' => true,
        'message' => 'deleted',
        'status' => 200,
      ];
    }
    return [
      'success' => false,
      'message' => 'not found',
      'status' => 404,
    ];
  }
  /**
   * Retrieves the list of available books
   *
   * @return array An array containing the list of available books and a status code
   */
  public function available()
  {
    // Query the Book model to find books without active borrow records
    $availableBooks = Book::whereDoesntHave('BorrowRecords', function ($query) {
      $query->whereNotNull('returned_at');
    })->get();

    return [
      'availableBooks' => $availableBooks,
      'status' => 201,
    ];
  }
}
