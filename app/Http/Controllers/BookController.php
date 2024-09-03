<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Services\BookService;
use App\Http\Requests\BookFormRequest;

/**
 * Class BookController
 * 
 * This controller handles the CRUD operations for books
 */
class BookController extends Controller
{
    protected $bookservice;
    /**
     * BookController constructor
     * 
     * @param BookService $bookservice
     */
    public function __construct(BookService $bookservice)
    {
        $this->bookservice = $bookservice;
    }
    /**
     * Display a listing of all books
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $result = $this->bookservice->AllBooks($request);
        return response()->json($result['books'], $result['status']);
    }
    /**
     * Store a newly created book in storage
     * 
     * @param BookFormRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(BookFormRequest $request)
    {
        $result = $this->bookservice->createBook($request->validated());
        if ($result['success']) {
            return response()->json($result['book'], $result['status']);
        }
        return response()->json($result['message'], $result['status']);
    }
    /**
     * Display the specified book
     * 
     * @param int $book
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($book)
    {
        $result = $this->bookservice->showBook($book);
        if ($result['success']) {
            return response()->json($result['data'], $result['status']);
        }

        return response()->json($result['message'], $result['status']);
    }
    /**
     * Update the specified book in storage
     * 
     * @param BookFormRequest $request
     * @param int $book
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(BookFormRequest $request, $book)
    {
        $result = $this->bookservice->updateBook($request->validated(), $book);
        if ($result['success']) {
            return response()->json($result['book'], $result['status']);
        }

        return response()->json($result['message'], $result['status']);
    }
    /**
     * Remove the specified book from storage
     * 
     * @param int $book
     * @return \Illuminate\Http\JsonResponse
     */

    public function destroy($book)
    {
        $result = $this->bookservice->deleteBook($book);
        return response()->json($result['message'], $result['status']);
    }
    /**
     * Fetches the list of available books 
     *
     * @return \Illuminate\Http\JsonResponse JSON response containing the list of available books and status code.
     */
    public function available()
    {
        $result = $this->bookservice->available();
        return response()->json($result['availableBooks'], $result['status']);
    }
}
