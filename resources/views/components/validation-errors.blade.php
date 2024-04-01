@if ($errors->any())
    <div {{ $attributes }}>
        <div class="font-medium text-yellow-400">{{ __('¡Vaya! Algo salió mal.') }}</div>

        <ul class="mt-3 list-disc list-inside text-sm text-yellow-400">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
