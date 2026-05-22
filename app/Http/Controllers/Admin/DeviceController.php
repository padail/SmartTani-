<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Device\StoreDeviceRequest;
use App\Http\Requests\Device\UpdateDeviceRequest;
use App\Models\Device;
use App\Services\Device\DeviceApiKeyService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DeviceController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->string('search')->toString();
        $status = $request->string('status')->toString();
        $type = $request->string('type')->toString();

        $devices = Device::query()
            ->withCount(['soilReadings', 'waterReadings'])
            ->when($search, function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery
                        ->where('device_code', 'like', "%{$search}%")
                        ->orWhere('name', 'like', "%{$search}%")
                        ->orWhere('location_name', 'like', "%{$search}%");
                });
            })
            ->when($status, fn ($query) => $query->where('status', $status))
            ->when($type, fn ($query) => $query->where('type', $type))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.devices.index', compact('devices', 'search', 'status', 'type'));
    }

    public function create(): View
    {
        return view('admin.devices.create');
    }

    public function store(StoreDeviceRequest $request, DeviceApiKeyService $apiKeyService): RedirectResponse
    {
        $validated = $request->validated();

        $plainApiKey = $apiKeyService->generatePlainKey($validated['device_code']);

        $device = Device::create([
            ...$validated,
            'api_key_hash' => $apiKeyService->hashKey($plainApiKey),
            'created_by' => auth()->id(),
        ]);

        return redirect()
            ->route('admin.devices.show', $device)
            ->with('success', 'Device berhasil dibuat.')
            ->with('generated_api_key', $plainApiKey);
    }

    public function show(Device $device): View
    {
        $device->load('creator:id,name,email');

        $soilReadings = $device->soilReadings()
            ->latest('recorded_at')
            ->limit(10)
            ->get();

        $waterReadings = $device->waterReadings()
            ->latest('recorded_at')
            ->limit(10)
            ->get();

        return view('admin.devices.show', compact('device', 'soilReadings', 'waterReadings'));
    }

    public function edit(Device $device): View
    {
        return view('admin.devices.edit', compact('device'));
    }

    public function update(UpdateDeviceRequest $request, Device $device): RedirectResponse
    {
        $device->update($request->validated());

        return redirect()
            ->route('admin.devices.show', $device)
            ->with('success', 'Device berhasil diperbarui.');
    }

    public function destroy(Device $device): RedirectResponse
    {
        $totalReadings = $device->soilReadings()->count() + $device->waterReadings()->count();

        if ($totalReadings > 0) {
            return back()->with('error', 'Device tidak dapat dihapus karena sudah memiliki data monitoring. Nonaktifkan device sebagai alternatif.');
        }

        $device->delete();

        return redirect()
            ->route('admin.devices.index')
            ->with('success', 'Device berhasil dihapus.');
    }

    public function rotateKey(Device $device, DeviceApiKeyService $apiKeyService): RedirectResponse
    {
        $plainApiKey = $apiKeyService->generatePlainKey($device->device_code);

        $device->forceFill([
            'api_key_hash' => $apiKeyService->hashKey($plainApiKey),
        ])->save();

        return back()
            ->with('success', 'API key device berhasil dibuat ulang. API key lama tidak berlaku lagi.')
            ->with('generated_api_key', $plainApiKey);
    }

    public function toggleStatus(Device $device): RedirectResponse
    {
        $device->forceFill([
            'status' => $device->status === 'active' ? 'inactive' : 'active',
        ])->save();

        return back()->with('success', 'Status device berhasil diperbarui.');
    }
}