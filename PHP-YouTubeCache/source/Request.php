<?php

declare(strict_types=1);

namespace YoutubeCache;

class Request
{

    public $video;
    public $endpoint;
    public $count;

    public function __construct(Video $video, Endpoint $endpoint, int $count)
    {
        $this->video = $video;
        $this->endpoint = $endpoint;
        $this->count = $count;
    }

}