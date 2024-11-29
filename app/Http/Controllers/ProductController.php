<?php

namespace App\Http\Controllers;

use App\Service\ProductService\ProductService;
use Exception;
use Illuminate\Http\Request;
use App\Model\Product;

class ProductController extends Controller
{
    private ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index()
    {
        $products = Product::with('tags')->get();
        return view('products/index', compact('products'));
    }

    public function create(Request $request)
    {
        try {
            $name = $request->input('name');
            $description = $request->input('description');
            $tags = $request->input('tags');

            $product = $this->productService->createProduct($name, $description);
            $tagIds = $this->productService->createOrGetTagIds($tags);

            $product->tags()->attach($tagIds);

            return redirect('/products');

        } catch (Exception $e) {
            return redirect('/products')->with('error', $e->getMessage());
        }
    }

    public function delete(Request $request)
    {
        $id = $request->input('id');

        try {
            $this->productService->deleteProduct($id);

            return redirect('/products')->with('success', 'Product deleted successfully.');
        } catch (Exception $e) {
            return redirect('/products')->with('error', $e->getMessage());
        }
    }
}
