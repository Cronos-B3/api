<?php

namespace App\Http\Controllers\Api\v1;

use App\Classes\ApiResponseClass;
use App\Http\Controllers\Controller;
use App\Http\Resources\FriendSoftResource;
use App\Interfaces\FriendRepositoryInterface;

class FriendController extends Controller
{
    private  FriendRepositoryInterface $friendRepositoryInterface;

    public function __construct(FriendRepositoryInterface $friendRepositoryInterface)
    {
        $this->friendRepositoryInterface = $friendRepositoryInterface;
    }

    //
    public function showMyFollows()
    {
        $follows = $this->friendRepositoryInterface->getMyFollows();
        return ApiResponseClass::sendSuccessResponse(FriendSoftResource::collection($follows), 'Follows retrieved successfully.');
    }

    public function showMyFollowers()
    {
        $followers = $this->friendRepositoryInterface->getMyFollowers();
        return ApiResponseClass::sendSuccessResponse(FriendSoftResource::collection($followers), 'Followers retrieved successfully.');
    }

    public function follow($userId)
    {
        $this->friendRepositoryInterface->follow($userId);
        return ApiResponseClass::sendSuccessResponse([], 'Followed successfully.');
    }

    public function unFollow($userId)
    {
        $this->friendRepositoryInterface->unFollow($userId);
        return ApiResponseClass::sendSuccessResponse([], 'Unfollowed successfully.');
    }

    public function showFollowsByUser($userId)
    {
        $follows = $this->friendRepositoryInterface->getFollowsByUser($userId);
        return ApiResponseClass::sendSuccessResponse(FriendSoftResource::collection($follows), 'Follows retrieved successfully.');
    }

    public function showFollowersByUser($userId)
    {
        $followers = $this->friendRepositoryInterface->getFollowersByUser($userId);
        return ApiResponseClass::sendSuccessResponse(FriendSoftResource::collection($followers), 'Followers retrieved successfully.');
    }
}
