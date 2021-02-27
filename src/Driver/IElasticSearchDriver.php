<?php

declare(strict_types=1);

namespace DixonsCarphone\Driver;

use DixonsCarphone\Exception\ConnectionException;

interface IElasticSearchDriver
{
    /**
     * @param int $id
     *
     * @return array
     * @throws ConnectionException
     */
    public function findById(int $id): array;
}
