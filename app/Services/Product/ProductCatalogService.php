<?php

namespace App\Services\Product;

use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class ProductCatalogService
{
    public function getCatalogProducts(Request $request, int $perPage = 12): LengthAwarePaginator
    {
        $search = $request->string('search')->toString();
        $categoryId = $request->string('category_id')->toString();
        $sort = $request->string('sort')->toString();

        return Product::query()
            ->with(['category:id,name,slug', 'owner:id,name'])
            ->published()
            ->search($search)
            ->when($categoryId, fn ($query) => $query->where('category_id', $categoryId))
            ->when($sort === 'price_low', fn ($query) => $query->orderBy('price'))
            ->when($sort === 'price_high', fn ($query) => $query->orderByDesc('price'))
            ->when($sort === 'newest' || $sort === '', fn ($query) => $query->latest())
            ->paginate($perPage)
            ->withQueryString();
    }

    public function getRelatedProducts(Product $product, int $limit = 4): Collection
    {
        return Product::query()
            ->with(['category:id,name,slug'])
            ->published()
            ->where('id', '!=', $product->id)
            ->when($product->category_id, fn ($query) => $query->where('category_id', $product->category_id))
            ->latest()
            ->limit($limit)
            ->get();
    }
}