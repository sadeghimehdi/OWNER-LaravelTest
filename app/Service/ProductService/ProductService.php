<?php

namespace App\Service\ProductService;

use App\Events\ProductCreated;
use App\Model\Tag;
use Exception;
use App\Model\Product;

class ProductService
{
    public function createProduct($name, $description)
    {
        $product = new Product();
        $product->setName($name);
        $product->setDescription($description);
        $product->save();

        ProductCreated::dispatch($product);

        return $product;
    }

    public function createOrGetTagIds($tags)
    {
        $tagNames = explode(',', $tags);
        $tagNames = array_map('trim', $tagNames);
        $tagNames = array_filter($tagNames);

        $tagIds = [];
        foreach ($tagNames as $tagName) {
            $tag = Tag::firstOrCreate(['name' => $tagName]);
            $tagIds[] = $tag->getId();
        }
        return $tagIds;
    }

    public function deleteProduct(int $id): void
    {
        $product = Product::find($id);

        if (!$product) {
            throw new Exception('Product not found.');
        }

        $product->delete();
    }
}
