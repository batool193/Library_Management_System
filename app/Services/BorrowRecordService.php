<?php

namespace App\Services;

use App\Models\Book;
use App\Models\BorrowRecord;
use Carbon\Carbon;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class BorrowRecordService
{

  /**
   * Retrieve all borrow records.
   *
   *  @return array The response containing the list of borrow records and status code
   */
  public function AllBorrowRecord()
  {
    $borrowrecords = BorrowRecord::all();
    return [
      'borrowrecords' => $borrowrecords,
      'status' => 201,
    ];
  }

  /**
   * Create a new borrow record for a book
   *
   * @param int $book
   * @return array The response containing the created borrow record for a book and status code
   */
  public function createBorrowRecord($book)
  {
    $user = JwtAuth::user();
    $user_id = $user->id;
    $book = Book::findOrFail($book);
    // Check if the book is already borrowed or if the user has not returned all books
    $existingRecord = BorrowRecord::where('book_id', $book->id)->whereNotNull('returned_at')->first();
    $userReturnedAllBooks = BorrowRecord::where('user_id', $user_id)->whereNotNull('returned_at')->first();

    if ($existingRecord || $userReturnedAllBooks) {
      return [
        'success' => false,
        'message' => 'This book is already borrowed or you have not returned all your books',
        'status' => 400,
      ];
    }

    // Create a new borrow record
    $borrowrecord = new BorrowRecord([
      'user_id' => $user_id,
      'book_id' => $book->id,
      'borrowed_at' => Carbon::now(),
      'returned_at' => Carbon::now()->addDays(14),
    ]);
    $borrowrecord->save();

    return [
      'success' => true,
      'borrowrecord' => $borrowrecord,
      'status' => 201,
    ];
  }

  /**
   * Show a specific borrow record
   *
   * @param int  $borrowrecord
   * @return array The response containing the borrow record and status code.
   */
  public function showBorrowRecord($borrowrecord)
  {
    $borrowrecord = BorrowRecord::findOrFail($borrowrecord);

    if (!$borrowrecord) {
      return [
        'success' => false,
        'message' => 'not found',
        'status' => 404,
      ];
    }

    return [
      'success' => true,
      'borrowrecord' => $borrowrecord,
      'status' => 201,
    ];
  }

  /**
   * Update a specific borrow record.
   *
   * @param array $data The data for updating the borrow record
   * @param int $borrowrecord the borrow record to update
   * @return array The response containing the updated borrow record and status code
   */
  public function updateBorrowRecord(array $data, $borrowrecord)
  {
    $user = JWTAuth::user();
    $user_id = $user->id;
    $role = $user->role;
    // Find the rating
    $existingRecord = BorrowRecord::findOrFail($borrowrecord);

    // Check if rating exists and if user is allowed to update it
    if ($existingRecord->user_id == $user_id || $role == 'admin') {
      $existingRecord->update($data);
      $existingRecord->returned_at = null;
      $existingRecord->save();
      return [
        'success' => true,
        'borrowrecord' => $existingRecord,
        'status' => 201,
      ];
    }

    return [
      'success' => false,
      'message' => 'you can not return another user book',
      'status' => 400,
    ];
  }

  /**
   * Delete a specific borrow record.
   *
   * @param int $borrowrecord
   * @return array
   */
  public function deleteBorrowRecord($borrowrecord)
  {
    if (BorrowRecord::findOrFail($borrowrecord)->delete()) {
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
   * Retrieves all borrowed books that have not been returned.
   *
   * @return array An array containing the success status, the list of borrowed books, and the status code.
   */
  public function notReturned()
  {  // Query the BorrowRecord model to get all records where the returned_at field is not null
    $borrowedBooks = BorrowRecord::all()->whereNotNull('returned_at');
    return [
      'success' => true,
      'borrowedBooks' => $borrowedBooks,
      'status' => 201,
    ];
  }
}
