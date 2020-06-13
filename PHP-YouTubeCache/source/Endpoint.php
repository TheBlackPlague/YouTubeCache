<?php

declare(strict_types=1);

namespace YoutubeCache;

class Endpoint
{

    public $dataCenterLatency;
    public $cacheCount;
    public $connectedCaches = [];
    public $connectedCachesLatency = [];

    public function __construct(int $dataCenterLatency, int $cacheCount)
    {
        $this->dataCenterLatency = $dataCenterLatency;
        $this->cacheCount = $cacheCount;
    }

    public function addCache(Cache $cache, int $cacheLatency): void
    {
        $this->connectedCaches[] = $cache;
        $this->connectedCachesLatency[] = $cacheLatency;
    }

}