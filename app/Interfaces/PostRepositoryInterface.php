<?php

namespace App\Interfaces;

interface PostRepositoryInterface
{
    public function index();
    public function getMyPosts();
    public function getById($postId);
    public function getMyFeed();
    public function getFeedByUser($userId);
    public function store($data);
    public function storeComment($data, $postId);
    // public function update(UpdatePostRequest $request, $postId);
    // public function delete($postId);
}
