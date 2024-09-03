<?php

namespace App\Http\Controllers;

use App\Http\Requests\RatingFormRequest;
use App\Models\Rating;
use App\Services\RatingService;

/**
 * Class RatingController
 * 
 * This controller handles the CRUD operations for ratings
 */
class RatingController extends Controller
{
    protected $ratingservice;
    /**
     * RatingController constructor
     * 
     * @param RatingService $ratingservice
     */
    public function __construct(RatingService $ratingservice)
    {
        $this->ratingservice = $ratingservice;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly Rating in storage
     * 
     * @param RatingFormRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(RatingFormRequest $request)
    {
        $result = $this->ratingservice->createRating($request->validated());
        if ($result['success']) {
            return response()->json($result['rating'], $result['status']);
        }
        return response()->json($result['message'], $result['status']);
    }

    /**
     * Displays the rating details.
     * @param int $rating The rating identifier.
     * @return \Illuminate\Http\JsonResponse JSON response containing the rating data or an error message and the status code.
     */
    public function show($rating)
    {
        $result = $this->ratingservice->ShowRating($rating);
        if ($result['success']) {
            return response()->json($result['data'], $result['status']);
        }

        return response()->json($result['message'], $result['status']);
    }
    /**
     * Update the specified Rating in storage
     * 
     * @param RatingFormRequest $request
     * @param int $rating
     * @return \Illuminate\Http\JsonResponse
     */

    public function update(RatingFormRequest $request, $rating)
    {
        $result = $this->ratingservice->updateRating($request->validated(), $rating);
        if ($result['success']) {
            return response()->json($result['rating'], $result['status']);
        }
        return response()->json($result['message'], $result['status']);
    }
    /**
     * Remove the specified Rating from storage
     * 
     * @param int $rating
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($rating)
    {
        $result = $this->ratingservice->deleteRating($rating);
        return response()->json($result['message'], $result['status']);
    }
}
