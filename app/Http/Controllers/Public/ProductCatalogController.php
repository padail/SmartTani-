<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Services\Product\ProductCatalogService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductCatalogController extends Controller
{
    public function index(Request $request, ProductCatalogService $service): View
    {
        $products = $service->getCatalogProducts($request);

        $categories = ProductCategory::query()
            ->where('status', 'active')
            ->orderBy('name')
            ->get(['id', 'name', 'slug']);

        return view('public.products.index', [
            'products' => $products,
            'categories' => $categories,
            'search' => $request->string('search')->toString(),
            'categoryId' => $request->string('category_id')->toString(),
            'sort' => $request->string('sort')->toString(),
        ]);
    }

    public function show(Product $product, ProductCatalogService $service): View
    {
        abort_unless($product->status === 'active' && $product->stock > 0, 404);

        $product->load(['category:id,name,slug', 'owner:id,name,email']);

        return view('public.products.show', [
            'product' => $product,
            'relatedProducts' => $service->getRelatedProducts($product),
        ]);
    }
}