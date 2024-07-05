<?php

namespace App\Http\Controllers\Api\v1;

use App\Classes\ApiResponseClass;
use App\Http\Controllers\Controller;
use App\Http\Resources\UpvoteSoftResource;
use App\Interfaces\UpvoteRepositoryInterface;

class UpvoteController extends Controller
{
    private UpvoteRepositoryInterface $upvoteRepositoryInterface;

    public function __construct(UpvoteRepositoryInterface $upvoteRepositoryInterface)
    {
        $this->upvoteRepositoryInterface = $upvoteRepositoryInterface;
    }
    //
    public function upvote($postId)
    {
        $this->upvoteRepositoryInterface->upvote($postId);
        return ApiResponseClass::sendSuccessResponse([], 'Post upvoted successfully.');
    }

    public function undoUpvote($postId)
    {
        $this->upvoteRepositoryInterface->undoUpvote($postId);
        return ApiResponseClass::sendSuccessResponse([], 'Post upvote undone successfully.');
    }

    public function showUpvotes($postId)
    {
        $upvotes = $this->upvoteRepositoryInterface->getUpvotes($postId);
        return ApiResponseClass::sendSuccessResponse(UpvoteSoftResource::collection($upvotes), 'Upvotes retrieved successfully.');
    }
}
