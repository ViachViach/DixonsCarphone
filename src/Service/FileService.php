<?php

declare(strict_types=1);

namespace DixonsCarphone\Service;

class FileService
{
    public function createStore(string $file): void
    {
        if (file_exists($file)) {
            return;
        }

        fclose(fopen($file, 'w'));
        @chmod($file, 0646);
    }
}
