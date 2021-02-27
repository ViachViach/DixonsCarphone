<?php

declare(strict_types=1);

namespace DixonsCarphone\IncrementStorage;

interface IIncrementStorage
{
    /**
     * @param $id
     */
    public function increment(int $id): void;
}
