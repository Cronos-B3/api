<?php

namespace App\Interfaces;

interface PostRepositoryInterface
{
    public function index();
    public function getMyPosts();
    public function getById($postId);
    public function getByUserId($userId);
    public function store($data);
    public function storeComment($data, $postId);
    public function getComments($postId);
}
