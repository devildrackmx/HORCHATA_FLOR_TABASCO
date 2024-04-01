@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-yellow-400 focus:border-indigo-500 bg-black bg-opacity-60 rounded-md shadow-sm']) !!}>
