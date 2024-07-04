<?php

namespace App\Interfaces;

interface FeedRepositoryInterface
{
    public function getMyFeed();
    public function LoadUpFeed($firstPostId);
    public function LoadDownFeed($lastPostId);
    public function getFeedByUser($userId);
}
