<?php

declare(strict_types=1);

namespace DixonsCarphone\Cache;

use DixonsCarphone\Service\FileService;

class FileCache implements ICache
{
    private FileService $fileService;
    private string $cacheFileDir;

    public function __construct(FileService $fileService, string $cacheFileDir)
    {
        $this->fileService  = $fileService;
        $this->cacheFileDir = $cacheFileDir;
        $this->fileService->createStore($this->cacheFileDir);
    }

    /**
     * @inheritDoc
     */
    public function get(int $id): array
    {
        $cache = file_get_contents($this->cacheFileDir);
        $data  = json_decode($cache);

        $result = [];
        if (isset($data[$id])) {
            $result = $data[$id];
        }

        return $result;
    }

    /**
     * @inheritDoc
     */
    public function push(int $id, array $value): void
    {
        $data = $this->get($id);
        if (!empty($data)) {
            return;
        }

        $cacheData[$id] = $value;
        $data           = json_encode($cacheData);
        file_put_contents($this->cacheFileDir, $data, FILE_APPEND);
    }
}
