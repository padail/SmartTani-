<?php

namespace App\Services\Product;

use App\Models\Product;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductService
{
    public function create(array $data, ?UploadedFile $image = null): Product
    {
        return DB::transaction(function () use ($data, $image) {
            $data['slug'] = $this->generateUniqueSlug($data['name']);
            $data['main_image'] = $image ? $this->storeImage($image) : null;

            return Product::create($data);
        });
    }

    public function update(Product $product, array $data, ?UploadedFile $image = null): Product
    {
        return DB::transaction(function () use ($product, $data, $image) {
            if ($product->name !== $data['name']) {
                $data['slug'] = $this->generateUniqueSlug($data['name'], $product->id);
            }

            if ($image) {
                $this->deleteImage($product->main_image);
                $data['main_image'] = $this->storeImage($image);
            }

            $product->update($data);

            return $product->fresh(['owner', 'category']);
        });
    }

    public function delete(Product $product): void
    {
        DB::transaction(function () use ($product) {
            $this->deleteImage($product->main_image);
            $product->delete();
        });
    }

    public function generateUniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($name);
        $slug = $baseSlug;
        $counter = 1;

        while (
            Product::query()
                ->where('slug', $slug)
                ->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $baseSlug.'-'.$counter;
            $counter++;
        }

        return $slug;
    }

    public function storeImage(UploadedFile $image): string
    {
        return $image->store('products', 'public');
    }

    public function deleteImage(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}