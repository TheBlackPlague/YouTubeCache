<?php

declare(strict_types=1);

namespace YoutubeCache;

class FileWriter
{

    private $path;

    public function __construct(string $path)
    {
        $this->path = $path;
    }

    public function write(Configuration $configuration): void
    {
        $usedCacheCount = 0;
        $cacheInfoList = [];
        /** @var Cache $cache */
        foreach ($configuration->cacheList as $id => $cache) {
            if (count($cache->videoStorage) > 0) {
                ++$usedCacheCount;

                if (!array_key_exists($id, $cacheInfoList)) {
                    $cacheInfoList[$id] = [];
                }

                /** @var Video $video */
                foreach ($cache->videoStorage as $video) {
                    $cacheInfoList[$id][] = $video->id;
                }
            }
        }

        $lines = [
            (string)$usedCacheCount
        ];

        foreach ($cacheInfoList as $cacheId => $videoList) {
            $line = (string) $cacheId . ' ' .  implode(' ', $videoList);
            $lines[] = $line;
        }

        $content = implode(PHP_EOL, $lines);
        file_put_contents($this->path, $content);
    }

}