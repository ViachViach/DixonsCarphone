<?php

declare(strict_types=1);

namespace DixonsCarphone\Service;

use DixonsCarphone\DTO\Product;

interface IProductService
{
    public function getById(int $id): Product;
}
