<?php

declare(strict_types=1);

namespace DixonsCarphone\Controller;

use DixonsCarphone\Service\IProductService;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

class ProductController
{
    private IProductService $productService;
    private SerializerInterface $serializer;

    public function __construct(IProductService $productService, SerializerInterface $serializer)
    {
        $this->productService = $productService;
        $this->serializer     = $serializer;
    }

    /**
     * @param int $id
     *
     * @return string
     */
    public function detail(int $id): string
    {
        $product = $this->productService->getById($id);

        return $this->serializer->serialize($product, JsonEncoder::FORMAT);
    }
}
