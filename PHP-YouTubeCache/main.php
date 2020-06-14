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

$time = microtime(true);

// format data into easy understandable way

$dataset = '';

$dt = microtime(true);
$fileReader = new FileReader('D:/GoogleCode/YouTubeCache/PHP-YouTubeCache/data/' . $dataset . '.in');

$configuration = $fileReader->generateConfiguration();

echo 'Formatting dataset' . PHP_EOL;
$configuration->sortData();
echo 'Total dataset formatting time: ' . (microtime(true) - $dt) . 's' . PHP_EOL;
echo 'Dataset Formatted' . PHP_EOL;

// solve the problem

echo 'Solving Problem' . PHP_EOL;

$pt = microtime(true);
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
echo 'Total problem solving time: ' . (microtime(true) - $pt) . 's' . PHP_EOL;

echo 'Problem solved' . PHP_EOL;

// output data in Google's submission format

echo 'Generating output file' . PHP_EOL;

$ot = microtime(true);
$fileWriter = new FileWriter('D:/GoogleCode/YouTubeCache/PHP-YouTubeCache/data/' . $dataset . '.out');
$fileWriter->write($configuration);

echo 'Total output file generating time: ' . (microtime(true) - $ot) . 's' . PHP_EOL;
echo 'Output file generated and saved' . PHP_EOL;

echo 'Total script execution time: ' . (microtime(true) - $time) . 's';