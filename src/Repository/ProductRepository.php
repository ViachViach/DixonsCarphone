<?php

declare(strict_types=1);

namespace DixonsCarphone\Repository;

use DixonsCarphone\Cache\ICache;
use DixonsCarphone\Driver\IElasticSearchDriver;
use DixonsCarphone\Driver\IMySQLDriver;
use DixonsCarphone\DTO\Product;
use DixonsCarphone\Exception\ConnectionException;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class ProductRepository
{
    private IElasticSearchDriver $elasticSearchDriver;
    private IMySQLDriver $mysqlDriver;
    private ICache $cache;
    private DenormalizerInterface $normalizer;

    public function __construct(
        IElasticSearchDriver $elasticSearchDriver,
        IMySQLDriver $mysqlDriver,
        ICache $cache,
        DenormalizerInterface $normalizer
    )
    {
        $this->elasticSearchDriver = $elasticSearchDriver;
        $this->mysqlDriver         = $mysqlDriver;
        $this->cache      = $cache;
        $this->normalizer = $normalizer;
    }

    public function findById(int $id): ?Product
    {
        $product = $this->findInCache($id);
        $product = $this->findInElastic($id, $product);
        $product = $this->findInMySql($id, $product);

        return $product;
    }

    /**
     * @param int $id
     *
     * @return Product|null
     */
    private function findInCache(int $id): ?Product
    {
        $product = $this->cache->get($id);

        if (empty($result)) {
            return null;
        }

        return $this->normalizer->denormalize($product, Product::class);
    }

    /**
     * @param int          $id
     * @param Product|null $product
     *
     * @return Product|null
     */
    private function findInElastic(int $id, Product $product=null): ?Product
    {
        if ($product !== null) {
            return $product;
        }

        try {
            $product = $this->elasticSearchDriver->findById($id);
        } catch (ConnectionException $e) {
            return null;
        }

        if (empty($result)) {
            return null;
        }

        $this->cache->push($id, $product);

        return $this->normalizer->denormalize($product, Product::class);
    }

    /**
     * @param int          $id
     * @param Product|null $product
     *
     * @return Product|null
     */
    private function findInMySql(int $id, Product $product=null): ?Product
    {
        if ($product !== null) {
            return $product;
        }

        $product = $this->mysqlDriver->findProduct($id);

        if (empty($result)) {
            return null;
        }

        $this->cache->push($id, $product);

        return $this->normalizer->denormalize($product, Product::class);
    }
}
