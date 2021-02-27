<?php

declare(strict_types=1);

namespace DixonsCarphone\Cache;

interface ICache
{
    /**
     * @param int $id
     *
     * @return array
     */
    public function get(int $id): array;

    /**
     * @param int   $id
     * @param array $value
     */
    public function push(int $id, array $value): void;
}
