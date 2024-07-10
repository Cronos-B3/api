<?php

namespace App\Http\Controllers\Api\v1;

use App\Classes\ApiResponseClass;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\StorePostRequest;
use App\Http\Resources\GetPostsCompleteCollectionWithPaginate;
use App\Http\Resources\PostCompleteResource;
use App\Interfaces\PostRepositoryInterface;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    private PostRepositoryInterface $postRepositoryInterface;

    public function __construct(PostRepositoryInterface $postRepositoryInterface)
    {
        $this->postRepositoryInterface = $postRepositoryInterface;
    }

    public function index()
    {
        $posts = $this->postRepositoryInterface->index();
        return ApiResponseClass::sendSuccessResponse(PostCompleteResource::collection($posts), 'Posts retrieved successfully.');
    }

    public function showMyPosts()
    {
        $posts = $this->postRepositoryInterface->getMyPosts();
        return ApiResponseClass::sendSuccessResponse(PostCompleteResource::collection($posts), 'User posts retrieved successfully.');
    }

    public function showByUserId($userId)
    {
        $posts = $this->postRepositoryInterface->getByUserId($userId);
        return ApiResponseClass::sendSuccessResponse(PostCompleteResource::collection($posts), 'User posts retrieved successfully.');
    }

    public function store(StorePostRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            $post = $this->postRepositoryInterface->store($data);
            DB::commit();
            return ApiResponseClass::sendSuccessResponse(new PostCompleteResource($post), 'Post created successfully.', Response::HTTP_CREATED);
        } catch (Exception $e) {
            DB::rollBack();
            return ApiResponseClass::sendErrorResponse($e, 'Post creation failed.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function storeComment(StoreCommentRequest $request, $postId)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            $post = $this->postRepositoryInterface->storeComment($data, $postId);
            DB::commit();
            return ApiResponseClass::sendSuccessResponse(new PostCompleteResource($post), 'Comment created successfully.', Response::HTTP_CREATED);
        } catch (Exception $e) {
            DB::rollBack();
            return ApiResponseClass::sendErrorResponse($e, 'Comment creation failed.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getComments($postId)
    {
        $comments = $this->postRepositoryInterface->getComments($postId);
        return ApiResponseClass::sendSuccessResponse(new GetPostsCompleteCollectionWithPaginate($comments), 'Comments retrieved successfully.');
    }


    public function showById($postId)
    {
        $post = $this->postRepositoryInterface->getById($postId);
        return ApiResponseClass::sendSuccessResponse(new PostCompleteResource($post), 'Post retrieved successfully.');
    }
}
