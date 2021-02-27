<?php

declare(strict_types=1);

namespace DixonsCarphone\IncrementStorage;

use DixonsCarphone\Service\FileService;

class IncrementProductStorage implements IIncrementStorage
{
    private FileService $fileService;
    private string $storeFileDir;

    public function __construct(FileService $fileService, string $storeFileDir)
    {
        $this->storeFileDir = $storeFileDir;
        $this->fileService  = $fileService;
        $this->fileService->createStore($this->storeFileDir);
    }

    /**
     * @inheritDoc
     */
    public function increment(int $id): void
    {
        $cache = file_get_contents($this->storeFileDir);
        $data  = json_decode($cache);

        $increment = [];
        if (isset($data[$id])) {
            $increment = $data[$id];
        } else {
            $increment[$id] = 1;
        }

        $data = json_encode($increment);
        file_put_contents($this->fileService, $data, FILE_APPEND);
    }
}
