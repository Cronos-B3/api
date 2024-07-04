<?php

namespace App\Http\Controllers\Api\v1;

use App\Classes\ApiResponseClass;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostCompleteResource;
use App\Interfaces\FeedRepositoryInterface;

class FeedController extends Controller
{

    private FeedRepositoryInterface $feedRepositoryInterface;

    public function __construct(FeedRepositoryInterface $feedRepositoryInterface)
    {
        $this->feedRepositoryInterface = $feedRepositoryInterface;
    }

    public function showMyFeed()
    {
        $feed = $this->feedRepositoryInterface->getMyFeed();
        return ApiResponseClass::sendSuccessResponse(PostCompleteResource::collection($feed), 'Feed retrieved successfully.');
    }

    public function LoadUpFeed($firstPostId)
    {
        $feed = $this->feedRepositoryInterface->LoadUpFeed($firstPostId);
        return ApiResponseClass::sendSuccessResponse(PostCompleteResource::collection($feed), 'Feed load up retrieved successfully.');
    }

    public function LoadDownFeed($lastPostId)
    {
        $feed = $this->feedRepositoryInterface->LoadDownFeed($lastPostId);
        return ApiResponseClass::sendSuccessResponse(PostCompleteResource::collection($feed), 'Feed load down retrieved successfully.');
    }

    public function getFeedByUser($userId)
    {
    }
}
