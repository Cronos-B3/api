<?php

namespace App\Http\Controllers\Api\v1;

use App\Classes\ApiResponseClass;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\StorePostRequest;
use App\Http\Resources\GetMyPostCompleteResource;
use App\Http\Resources\GetMyPostsCompleteCollection;
use App\Http\Resources\PostCompleteResource;
use App\Http\Resources\PostSoftResource;
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

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = $this->postRepositoryInterface->index();
        return ApiResponseClass::sendSuccessResponse(PostCompleteResource::collection($posts), 'Posts retrieved successfully.');
    }

    public function getMyPosts()
    {
        $posts = $this->postRepositoryInterface->getMyPosts();
        return ApiResponseClass::sendSuccessResponse(new GetMyPostsCompleteCollection($posts), 'User posts retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     */
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
        return ApiResponseClass::sendSuccessResponse(PostCompleteResource::collection($comments), 'Comments retrieved successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function showById($postId)
    {
        $post = $this->postRepositoryInterface->getById($postId);
        return ApiResponseClass::sendSuccessResponse(new PostCompleteResource($post), 'Post retrieved successfully.');
    }
}
