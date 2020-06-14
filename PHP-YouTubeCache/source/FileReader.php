<?php

declare(strict_types=1);

namespace YoutubeCache;

class FileReader
{

    private $path;
    private $lines;
    private $lineToRead = 0;

    public function __construct(string $path)
    {
        $this->path = $path;
        $this->readLines();
    }

    public function readLines(): void
    {
        // $content = file_get_contents($this->path);

        // $this->lines = explode(PHP_EOL, $content);

        // var_dump($this->lines);

        $file = fopen($this->path, 'rb');
        $this->lines = [];

        while (!feof($file)) {
            $this->lines[] = fgets($file);
        }

        fclose($file);
    }

    public function generateConfiguration(): Configuration
    {
        echo 'Generating Configuration' . PHP_EOL;

        $configuration = explode(' ', $this->lines[$this->lineToRead]);
        ++$this->lineToRead;

        $configuration = new Configuration(
            (int)$configuration[0],
            (int)$configuration[1],
            (int)$configuration[2],
            (int)$configuration[3],
            (int)$configuration[4]
        );

        echo 'Configuration Generated' . PHP_EOL;

        // cache
        echo 'Generating Caches' . PHP_EOL;
        for ($i = 0; $i < $configuration->cacheCount; $i++) {
            $configuration->cacheList[$i] = new Cache($i, $configuration->cacheSize);
        }
        echo 'Cache Generated' . PHP_EOL;

        echo 'Generating videos...' . PHP_EOL;
        $this->generateVideos($configuration);
        echo 'Videos Generated' . PHP_EOL;
        echo 'Generating Endpoints' . PHP_EOL;
        $this->generateEndpoints($configuration);
        echo 'Endpoints Generated' . PHP_EOL;
        echo 'Generating Requests' . PHP_EOL;
        $this->generateRequests($configuration);
        echo 'Requests Generated' . PHP_EOL;

        return $configuration;
    }

    public function generateVideos(Configuration $configuration): void
    {
        $videoSizes = explode(' ', $this->lines[$this->lineToRead]);
        ++$this->lineToRead;
        if (count($videoSizes) === $configuration->videoCount) {
            for ($i = 0; $i < $configuration->videoCount; $i++) {
                $configuration->videoList[$i] = new Video($i, (int)$videoSizes[$i]);
                echo "\t" . 'Video #' . $i . ' Generated' . PHP_EOL;
            }
        }
    }

    public function generateEndpoints(Configuration $configuration): void
    {
        for ($i = 0; $i < $configuration->endPointCount; $i++) {
            $endpointData = explode(' ', $this->lines[$this->lineToRead]);
            ++$this->lineToRead;

            $configuration->endPointList[$i] = new Endpoint((int)$endpointData[0], (int)$endpointData[1]);
            for ($c = 0; $c < $configuration->endPointList[$i]->cacheCount; $c++) {
                $cacheLatencyData = explode(' ', $this->lines[$this->lineToRead]);
                ++$this->lineToRead;

                /** @var Cache $cache */
                $cache = $configuration->cacheList[(int)$cacheLatencyData[0]];
                $configuration->endPointList[$i]->addCache(
                    $cache,
                    (int)$cacheLatencyData[1]
                );

                $cache->addEndpoint($configuration->endPointList[$i], (int)$cacheLatencyData[1]);
            }
        }
    }

    public function generateRequests(Configuration $configuration): void
    {
        for ($i = 0; $i < $configuration->requestCount; $i++) {
            $requestData = explode(' ', $this->lines[$this->lineToRead]);
            ++$this->lineToRead;

            $video = $configuration->videoList[(int)$requestData[0]];
            $endpoint = $configuration->endPointList[(int)$requestData[1]];

            $configuration->requestList[$i] = new Request($video, $endpoint, (int)$requestData[2]);
        }
    }

}