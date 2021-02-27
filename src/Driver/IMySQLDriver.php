<?php

declare(strict_types=1);

namespace DixonsCarphone\Driver;

interface IMySQLDriver
{
    /**
     * @param int $id
     *
     * @return array
     */
    public function findProduct(int $id): array;
}
