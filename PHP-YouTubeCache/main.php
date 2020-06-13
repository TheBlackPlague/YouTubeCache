<?php

declare(strict_types=1);

namespace YoutubeCache;

include 'D:/GoogleCode/YouTubeCache/PHP-YouTubeCache/source/FileReader.php';
include 'D:/GoogleCode/YouTubeCache/PHP-YouTubeCache/source/Configuration.php';
include 'D:/GoogleCode/YouTubeCache/PHP-YouTubeCache/source/Video.php';
include 'D:/GoogleCode/YouTubeCache/PHP-YouTubeCache/source/Cache.php';
include 'D:/GoogleCode/YouTubeCache/PHP-YouTubeCache/source/Endpoint.php';
include 'D:/GoogleCode/YouTubeCache/PHP-YouTubeCache/source/Request.php';
include 'D:/GoogleCode/YouTubeCache/PHP-YouTubeCache/source/FileWriter.php';

// format data into easy understandable way

$fileReader = new FileReader('D:/GoogleCode/YouTubeCache/PHP-YouTubeCache/data/data.in');

$configuration = $fileReader->generateConfiguration();
$configuration->sortData();

// solve the problem

/** @var Request $request */
foreach ($configuration->requestList as $request) {
    $video = $request->video;
    $endpoint = $request->endpoint;
    $lowestLatency = $endpoint->dataCenterLatency;
    $selectedCache = null;

    /**
     * @var int $id
     * @var Cache $connectedCache
     */
    foreach ($endpoint->connectedCaches as $id => $connectedCache) {
        $latency = $endpoint->connectedCachesLatency[$id];
        if ($latency < $lowestLatency && $connectedCache->canStore($video)) {
            $lowestLatency = $latency;
            $selectedCache = $connectedCache;
        }
    }

    if ($selectedCache instanceof Cache) {
        $selectedCache->store($video);
    }
}

// output data in Google's submission format
$fileWriter = new FileWriter('D:/GoogleCode/YouTubeCache/PHP-YouTubeCache/data/data.out');
$fileWriter->write($configuration);