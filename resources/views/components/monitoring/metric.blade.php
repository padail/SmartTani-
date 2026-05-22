@props([
    'label',
    'valueId',
    'unit' => '',
])

<div class="rounded-2xl bg-slate-50 p-4 ring-1 ring-slate-200">
    <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">
        {{ $label }}
    </p>

    <div class="mt-2 flex items-end gap-1">
        <span id="{{ $valueId }}" class="text-xl font-bold text-slate-950">-</span>

        @if ($unit !== '')
            <span class="pb-0.5 text-xs font-medium text-slate-500">
                {{ $unit }}
            </span>
        @endif
    </div>
</div>