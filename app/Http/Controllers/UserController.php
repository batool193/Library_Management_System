<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use App\Http\Requests\UserFormRequest;
use App\Models\User;

/**
 * Class UserController
 * 
 * This controller handles the CRUD operations for users
 */
class UserController extends Controller
{
  protected $userservice;
  /**
   * UserController constructor
   * 
   * @param UserService $userService
   */
  public function __construct(UserService $userService)
  {
    $this->userservice = $userService;
  }
  /**
   * Display a listing of the users
   * 
   * @return \Illuminate\Http\JsonResponse
   */
  public function index()
  {
    $result = $this->userservice->AllUsers();
    return response()->json($result['user'], $result['status']);
  }

  /**
   * Store a newly created user in storage
   * 
   * @param UserFormRequest $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function store(UserFormRequest $request)
  {
    $result = $this->userservice->createUser($request->validated());
    return response()->json($result['user'], $result['status']);
  }
  /**
   * Display the specified user
   * 
   * @param int $user
   * @return \Illuminate\Http\JsonResponse
   */

  public function show($user)
  {
    $result = $this->userservice->showUser($user);
    if ($result['success']) {
      return response()->json($result['user'], $result['status']);
    }

    return response()->json($result['message'], $result['status']);
  }
  /**
   * Update the specified user in storage
   * 
   * @param UserFormRequest $request
   * @param int $user
   * @return \Illuminate\Http\JsonResponse
   */

  public function update(UserFormRequest $request, $user)
  {
    $result = $this->userservice->updateUser($request->validated(), $user);
    if ($result['success']) {
      return response()->json($result['user'], $result['status']);
    }

    return response()->json($result['message'], $result['status']);
  }
  /**
   * Remove the specified user from storage
   * 
   * @param int $user
   * @return \Illuminate\Http\JsonResponse
   */

  public function destroy($user)
  {
    $result = $this->userservice->deleteUser($user);
    return response()->json($result['message'], $result['status']);
  }
}
