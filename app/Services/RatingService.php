<?php

namespace App\Services;


use App\Models\Rating;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class RatingService
{
  /**
   * Creates a new rating for a book.
   * 
   * @param array $request The request data containing book_id, rating, and review.
   * @return array An array containing the success status, message or rating, and the status code.
   */

  public function createRating($request)
  {
    // Get the authenticated user
    $user =  JWTAuth::user();
    $user_id = $user->id;
    // Check if the user has already rated this book
    $existingRating = Rating::where('user_id', $user_id)
      ->where('book_id', $request['book_id'])->first();
    if ($existingRating) {
      return [
        'success' => false,
        'message' => 'You have already rated this book',
        'status' => 400,
      ];
    }
    $rating = new Rating([
      'user_id' => $user_id,
      'book_id' => $request['book_id'],
      'rating' => $request['rating'],
      'review' => $request['review'],
    ]);
    $rating->save();
    return [
      'success' => true,
      'rating' => $rating,
      'status' => 201,
    ];
  }
  /**
   * Shows the details of a specific rating.
   *
   *
   * @param int $rating The rating identifier.
   * @return array An array containing the success status, data or message, and the status code.
   */

  public function ShowRating($rating)
  { {
      $rating = Rating::findOrFail($rating);
      $book = $rating->Book()->get();
      if (!$rating) {
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
          'rating' => $rating,
        ],
        'status' => 201,
      ];
    }
  }

  /**
   * Updates an existing rating.
   *
   * This function updates the rating if the user is the owner or an admin.
   *
   * @param array $data The data to update the rating with.
   * @param int $rating The rating identifier.
   * @return array An array containing the success status, message or rating, and the status code.
   */
  public function updateRating(array $data, $rating)
  {

    $user = JWTAuth::user();
    $user_id = $user->id;
    $role = $user->role;
    // Find the rating
    $existingRating = Rating::findOrFail($rating);

    // Check if rating exists and if user is allowed to update it
    if ($existingRating->user_id == $user_id || $role == 'admin') {
      $existingRating->update($data);
      return [
        'success' => true,
        'rating' => $existingRating,
        'status' => 201,
      ];
    }
    return [
      'success' => false,
      'message' => 'Cannot update another user rating',
      'status' => 404,
    ];
  }
  /**
   * Deletes an existing rating.
   *
   * This function deletes the rating if the user is the owner or an admin.
   *
   * @param int $rating The rating identifier.
   * @return array An array containing the success status, message, and the HTTP status code.
   */

  public function deleteRating($rating)
  {
    $user = JWTAuth::user();
    $user_id = $user->id;
    $role = $user->role;
    // Find the rating
    $rating = Rating::findOrFail($rating);

    // Check if rating exists and if user is allowed to delete it
    if ($rating->user_id == $user_id || $role == 'admin') {
      $rating->delete();
      return [
        'success' => true,
        'message' => 'Rating deleted',
        'status' => 200,
      ];
    }
    return [
      'success' => false,
      'message' => 'Cannot delete another user rating',
      'status' => 404,
    ];
  }
}
