<?php

declare(strict_types=1);

namespace DixonsCarphone\Service;

use DixonsCarphone\DTO\Product;
use DixonsCarphone\Exception\NotFoundException;
use DixonsCarphone\IncrementStorage\IIncrementStorage;
use DixonsCarphone\Repository\ProductRepository;

class ProductService implements IProductService
{
    private ProductRepository $productRepository;
    private IIncrementStorage $productIncrement;

    public function __construct(ProductRepository $productRepository, IIncrementStorage $productIncrement)
    {
        $this->productRepository = $productRepository;
        $this->productIncrement  = $productIncrement;
    }

    /**
     * @param int $id
     *
     * @return Product
     * @throws NotFoundException
     */
    public function getById(int $id): Product
    {
        $product = $this->productRepository->findById($id);

        if ($product === null) {
            throw new NotFoundException(sprintf('Product by id %d not found', $id));
        }

        $this->productIncrement->increment($id);

        return $product;
    }


}
