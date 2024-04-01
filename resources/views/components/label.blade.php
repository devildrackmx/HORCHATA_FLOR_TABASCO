@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-white text-center']) }}>
    {{ $value ?? $slot }}
</label>
