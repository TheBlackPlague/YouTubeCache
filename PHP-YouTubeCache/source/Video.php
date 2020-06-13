<?php

declare(strict_types=1);

namespace YoutubeCache;

class Video
{

    public $id;
    public $size;

    public function __construct(int $id, int $size)
    {
        $this->id = $id;
        $this->size = $size;
    }

}