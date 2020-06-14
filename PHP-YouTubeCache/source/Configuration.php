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

    public function sortData(): void
    {
        $requestListCount = count($this->requestList);
        $requestList = [];

        while (count($requestList) !== $requestListCount) {
            $highestCount = 0;
            $selectedRequest = null;
            $selectedPointer = 0;

            $formattingPercentage = (count($requestList) / $requestListCount) * 100;
            echo 'Data formatting completed: ' . $formattingPercentage . '%' . PHP_EOL;

            /** @var Request $request */
            foreach ($this->requestList as $pointer => $request) {
                if ($request->count > $highestCount) {
                    $highestCount = $request->count;
                    $selectedRequest = $request;
                    $selectedPointer = $pointer;
                }
            }

            if ($selectedRequest instanceof Request) {
                unset($this->requestList[$selectedPointer]);
                $requestList[] = $selectedRequest;
            }
        }

        $this->requestList = $requestList;
    }

}