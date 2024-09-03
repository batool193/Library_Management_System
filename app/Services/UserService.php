<?php

namespace App\Services;

use App\Models\User;

class UserService
{

  /**
   * Retrieve all users.
   *
   * @return array The response containing the list of users and status code
   */
  public function AllUsers()
  {
    $users = User::all();
    return [
      'user' => $users,
      'status' => 201,
    ];
  }

  /**
   * Create a new user.
   *
   * @param array $data The data for creating a new user
   * @return array The response containing the created user and status code
   */
  public function createUser(array $data)
  {
    $user = User::create($data);
    return [
      'user' => $user,
      'status' => 201,
    ];
  }

  /**
   * Show a specific user.
   *
   * @param int $user
   * @return array The response containing the user and status code
   */
  public function showUser($user)
  {
    $user = User::findOrFail($user);

    if (!$user) {
      return [
        'success' => false,
        'message' => 'not found',
        'status' => 404,
      ];
    }

    return [
      'success' => true,
      'user' => $user,
      'status' => 201,
    ];
  }

  /**
   * Update a specific user.
   *
   * @param array $data The data for updating the
   * @param int $user the user to update
   * @return array The response containing the updated user and status code
   */
  public function updateUser(array $data, $user)
  {
    $user = User::findOrFail($user);
    $user->update($data);

    if (!$user) {
      return [
        'success' => false,
        'message' => 'not found',
        'status' => 404,
      ];
    }

    return [
      'success' => true,
      'user' => $user,
      'status' => 201,
    ];
  }

  /**
   * Delete a specific user.
   *
   * @param int $user the user to delete
   * @return array The response indicating success or failure and status code
   */
  public function deleteUser($user)
  {
    if (User::findOrFail($user)->delete()) {
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
}
