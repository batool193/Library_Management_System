<?php

namespace App\Http\Controllers;

use App\Http\Requests\BorrowRecordFormRequest;
use App\Models\Book;
use App\Models\BorrowRecord;
use App\Services\BorrowRecordService;

/**
 * Class BorrowRecordController
 * 
 * This controller handles the CRUD operations for borrow records
 */
class BorrowRecordController extends Controller
{
  protected $borrowrecordservice;
  /**
   * BorrowRecordController constructor
   * 
   * @param BorrowRecordService $borrowrecordservice
   */
  public function __construct(BorrowRecordService $borrowrecordservice)
  {
    $this->borrowrecordservice = $borrowrecordservice;
  }
  /**
   * Display a listing of all borrow records
   * 
   * @return \Illuminate\Http\JsonResponse
   */
  public function index()
  {
    $result = $this->borrowrecordservice->AllBorrowRecord();
    return response()->json($result['borrowrecords'], $result['status']);
  }
  /**
   * Store a newly created borrow record in storage
   * 
   * @param Book $book
   * @return \Illuminate\Http\JsonResponse
   */
  public function store($book)
  {
    $result = $this->borrowrecordservice->createBorrowRecord($book);
    if ($result['success']) {
      return response()->json($result['borrowrecord'], $result['status']);
    }
    return response()->json($result['message'], $result['status']);
  }
  /**
   * Display the specified borrow record
   * 
   * @param int $borrowRecord
   * @return \Illuminate\Http\JsonResponse
   */

  public function show($borrowRecord)
  {
    $result = $this->borrowrecordservice->showBorrowRecord($borrowRecord);
    if ($result['success']) {
      return response()->json($result['borrowrecord'], $result['status']);
    }

    return response()->json($result['message'], $result['status']);
  }
  /**
   * Update the specified borrow record in storage
   * used to change due_date to return book
   * @param BorrowRecordFormRequest $request
   * @param int $borrowrecord
   * @return \Illuminate\Http\JsonResponse
   */

  public function update(BorrowRecordFormRequest $request, $borrowrecord)
  {
    $result = $this->borrowrecordservice->updateBorrowRecord($request->validated(), $borrowrecord);
    if ($result['success']) {
      return response()->json($result['borrowrecord'], $result['status']);
    }
    return response()->json($result['message'], $result['status']);
  }
  /**
   * Remove the specified borrow record from storage
   * 
   * @param int $borrowRecord
   * @return \Illuminate\Http\JsonResponse
   */
  public function destroy($borrowRecord)
  {
    $result = $this->borrowrecordservice->deleteBorrowRecord($borrowRecord);
    return response()->json($result['message'], $result['status']);
  }
  /**
   * Handles the retrieval of books that have not been returned.
   *
   * This function calls the `notReturned` method from the `BorrowRecordService` to get a list of borrowed books
   * that have not been returned. It then returns this list as a JSON response.
   *
   * @return \Illuminate\Http\JsonResponse JSON response containing the list of borrowed books and the status code.
   */
  public function notReturned()
  {
    $result = $this->borrowrecordservice->notReturned();
    return response()->json($result['borrowedBooks'], $result['status']);
  }
}
