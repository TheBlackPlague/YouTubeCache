<?php

declare(strict_types=1);

namespace YoutubeCache;

class Configuration
{

    public $videoCount;
    public $endPointCount;
    public $requestCount;
    public $cacheCount;
    public $cacheSize;

    public $videoList = [];
    public $endPointList = [];
    public $cacheList = [];
    public $requestList = [];

    public function __construct(int $videoCount, int $endPointCount, int $requestCount, int $cacheCount, int $cacheSize)
    {
        $this->videoCount = $videoCount;
        $this->endPointCount = $endPointCount;
        $this->requestCount = $requestCount;
        $this->cacheCount = $cacheCount;
        $this->cacheSize = $cacheSize;
    }

}