<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Buyer\StoreBuyerAddressRequest;
use App\Http\Requests\Buyer\UpdateBuyerAddressRequest;
use App\Models\BuyerAddress;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BuyerAddressController extends Controller
{
    public function index(): View
    {
        $addresses = auth()->user()
            ->buyerAddresses()
            ->latest()
            ->get();

        return view('buyer.addresses.index', compact('addresses'));
    }

    public function create(): View
    {
        return view('buyer.addresses.create');
    }

    public function store(StoreBuyerAddressRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['is_default'] = $request->boolean('is_default');

        if ($data['is_default']) {
            auth()->user()->buyerAddresses()->update(['is_default' => false]);
        }

        $address = auth()->user()->buyerAddresses()->create($data);

        if (auth()->user()->buyerAddresses()->count() === 1) {
            $address->update(['is_default' => true]);
        }

        return redirect()
            ->route('buyer.addresses.index')
            ->with('success', 'Alamat berhasil ditambahkan.');
    }

    public function edit(BuyerAddress $address): View
    {
        $this->authorizeAddress($address);

        return view('buyer.addresses.edit', compact('address'));
    }

    public function update(UpdateBuyerAddressRequest $request, BuyerAddress $address): RedirectResponse
    {
        $this->authorizeAddress($address);

        $data = $request->validated();
        $data['is_default'] = $request->boolean('is_default');

        if ($data['is_default']) {
            auth()->user()->buyerAddresses()->whereKeyNot($address->id)->update(['is_default' => false]);
        }

        $address->update($data);

        return redirect()
            ->route('buyer.addresses.index')
            ->with('success', 'Alamat berhasil diperbarui.');
    }

    public function destroy(BuyerAddress $address): RedirectResponse
    {
        $this->authorizeAddress($address);

        $address->delete();

        return back()->with('success', 'Alamat berhasil dihapus.');
    }

    public function makeDefault(BuyerAddress $address): RedirectResponse
    {
        $this->authorizeAddress($address);

        auth()->user()->buyerAddresses()->update(['is_default' => false]);

        $address->update(['is_default' => true]);

        return back()->with('success', 'Alamat utama berhasil diperbarui.');
    }

    private function authorizeAddress(BuyerAddress $address): void
    {
        abort_unless((int) $address->user_id === (int) auth()->id(), 403);
    }
}