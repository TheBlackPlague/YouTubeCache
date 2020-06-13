<?php

namespace YoutubeCache;

class Cache
{

    public $id;
    public $size;
    public $connectedEndpoints = [];
    public $connectedEndpointsLatency = [];
    public $currentSize = 0;
    public $videoStorage = [];

    public function __construct(int $id, int $size)
    {
        $this->id = $id;
        $this->size = $size;
    }

    public function addEndpoint(Endpoint $endpoint, int $latency): void
    {
        $this->connectedEndpoints[] = $endpoint;
        $this->connectedEndpointsLatency[] = $latency;
    }

    public function store(Video $video): void
    {
        $this->currentSize += $video->size;
        $this->videoStorage[] = $video;
    }

    public function canStore(Video $video): bool
    {
        return !($this->currentSize + $video->size > $this->size);
    }

}