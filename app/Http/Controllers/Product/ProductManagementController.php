<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\User;
use App\Services\Product\ProductService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductManagementController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        $search = $request->string('search')->toString();
        $status = $request->string('status')->toString();
        $categoryId = $request->string('category_id')->toString();

        $products = Product::query()
            ->with(['owner:id,name,email', 'category:id,name'])
            ->visibleForUser($user)
            ->when($search, function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery
                        ->where('name', 'like', "%{$search}%")
                        ->orWhere('sku', 'like', "%{$search}%")
                        ->orWhere('short_description', 'like', "%{$search}%");
                });
            })
            ->when($status, fn ($query) => $query->where('status', $status))
            ->when($categoryId, fn ($query) => $query->where('category_id', $categoryId))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $categories = ProductCategory::where('status', 'active')
            ->orderBy('name')
            ->get(['id', 'name']);

        return view('products.index', [
            'products' => $products,
            'categories' => $categories,
            'search' => $search,
            'status' => $status,
            'categoryId' => $categoryId,
            'routePrefix' => $this->routePrefix(),
        ]);
    }

    public function create(): View
    {
        return view('products.create', [
            'categories' => $this->categories(),
            'owners' => $this->owners(),
            'routePrefix' => $this->routePrefix(),
        ]);
    }

    public function store(StoreProductRequest $request, ProductService $service): RedirectResponse
    {
        $validated = $request->validated();
        $validated['is_featured'] = $request->boolean('is_featured');

        if ($request->user()->role === 'owner') {
            $validated['owner_id'] = $request->user()->id;
        }

        if ($request->user()->role === 'admin' && empty($validated['owner_id'])) {
            $validated['owner_id'] = $request->user()->id;
        }

        $product = $service->create($validated, $request->file('main_image'));

        return redirect()
            ->route($this->routePrefix().'.show', $product)
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    public function show(Request $request, Product $product): View
    {
        $this->ensureProductAccess($request, $product);

        $product->load(['owner:id,name,email', 'category:id,name']);

        return view('products.show', [
            'product' => $product,
            'routePrefix' => $this->routePrefix(),
        ]);
    }

    public function edit(Request $request, Product $product): View
    {
        $this->ensureProductAccess($request, $product);

        return view('products.edit', [
            'product' => $product,
            'categories' => $this->categories(),
            'owners' => $this->owners(),
            'routePrefix' => $this->routePrefix(),
        ]);
    }

    public function update(
        UpdateProductRequest $request,
        Product $product,
        ProductService $service
    ): RedirectResponse {
        $this->ensureProductAccess($request, $product);

        $validated = $request->validated();
        $validated['is_featured'] = $request->boolean('is_featured');

        if ($request->user()->role === 'owner') {
            $validated['owner_id'] = $request->user()->id;
        }

        if ($request->user()->role === 'admin' && empty($validated['owner_id'])) {
            $validated['owner_id'] = $product->owner_id;
        }

        $service->update($product, $validated, $request->file('main_image'));

        return redirect()
            ->route($this->routePrefix().'.show', $product)
            ->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Request $request, Product $product, ProductService $service): RedirectResponse
    {
        $this->ensureProductAccess($request, $product);

        $service->delete($product);

        return redirect()
            ->route($this->routePrefix().'.index')
            ->with('success', 'Produk berhasil dihapus.');
    }

    private function ensureProductAccess(Request $request, Product $product): void
    {
        $user = $request->user();

        if ($user->role === 'admin') {
            return;
        }

        if ((int) $product->owner_id !== (int) $user->id) {
            abort(403, 'Anda tidak memiliki akses ke produk ini.');
        }
    }

    private function routePrefix(): string
    {
        return auth()->user()->role === 'admin'
            ? 'admin.products'
            : 'owner.products';
    }

    private function categories()
    {
        return ProductCategory::where('status', 'active')
            ->orderBy('name')
            ->get(['id', 'name']);
    }

    private function owners()
    {
        if (auth()->user()->role !== 'admin') {
            return collect();
        }

        return User::where('role', 'owner')
            ->where('status', 'active')
            ->orderBy('name')
            ->get(['id', 'name', 'email']);
    }
}