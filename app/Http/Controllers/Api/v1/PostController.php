<?php

namespace App\Http\Controllers\Api\v1;

use App\Classes\ApiResponseClass;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
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

    /**
     * Display the specified resource.
     */
    public function showById($postId)
    {
        $post = $this->postRepositoryInterface->getById($postId);
        return ApiResponseClass::sendSuccessResponse(new PostCompleteResource($post), 'Post retrieved successfully.');
    }

    /**
     * Display the user feed resource.
     */
    public function showMyFeed()
    {
        $posts = $this->postRepositoryInterface->getMyFeed();
        return ApiResponseClass::sendSuccessResponse(PostCompleteResource::collection($posts), 'Posts retrieved successfully.');
    }

    /**
     * Display the other user feed resource.
     */
    public function showFeedUser(int $userId)
    {
        $posts = $this->postRepositoryInterface->getFeedByUser($userId);
        return ApiResponseClass::sendSuccessResponse(PostSoftResource::collection($posts), 'Posts retrieved successfully.');
    }

 

    /**
     * Update the specified resource in storage.
     * Admin function to update a post.
     */
    // public function update(UpdatePostRequest $request, int $postId)
    // {
    //     DB::beginTransaction();
    //     try {
    //         $post = $this->postRepositoryInterface->update($request, $postId);
    //         DB::commit();
    //         return ApiResponseClass::sendResponse(new PostCompleteResource($post), 'Post updated successfully.');
    //     } catch (Exception $e) {
    //         return ApiResponseClass::rollback($e);
    //     }
    // }

    /**
     * Remove the specified resource from storage.
     * Admin function to delete a post.
     */
    // public function destroy(int $postId)
    // {
    //     DB::beginTransaction();
    //     try {
    //         $this->postRepositoryInterface->delete($postId);
    //         DB::commit();
    //         return ApiResponseClass::sendResponse(null, 'Post deleted successfully.', Response::HTTP_NO_CONTENT);
    //     } catch (Exception $e) {
    //         return ApiResponseClass::rollback($e);
    //     }
    // }
}
