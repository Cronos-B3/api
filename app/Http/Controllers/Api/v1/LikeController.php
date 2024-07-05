<?php

namespace App\Http\Controllers\Api\v1;

use App\Classes\ApiResponseClass;
use App\Http\Controllers\Controller;
use App\Interfaces\LikeRepositoryInterface;

class LikeController extends Controller
{
    private LikeRepositoryInterface $likeRepositoryInterface;

    public function __construct(LikeRepositoryInterface $likeRepositoryInterface)
    {
        $this->likeRepositoryInterface = $likeRepositoryInterface;
    }
    /**
     * Like post.
     */
    public function like($postId)
    {
        $this->likeRepositoryInterface->like($postId);
        return ApiResponseClass::sendSuccessResponse([], 'Post liked successfully.');
    }

    /**
     * Unlike Post.
     */
    public function unLike($postId)
    {
        $this->likeRepositoryInterface->unlike($postId);
        return ApiResponseClass::sendSuccessResponse([], 'Post unliked successfully.');
    }

    /**
     * Get all likes for a post.
     */
    public function showLikes($postId)
    {
        $likes = $this->likeRepositoryInterface->getLikes($postId);
        return ApiResponseClass::sendSuccessResponse($likes, 'Likes retrieved successfully.');
    }
}
