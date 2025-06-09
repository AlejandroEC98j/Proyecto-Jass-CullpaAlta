@props(['type' => 'primary'])

@php
$baseClasses = 'inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-offset-2 transition ease-in-out duration-150';

$classes = match ($type) {
    'danger' => 'bg-red-600 text-white hover:bg-red-500 active:bg-red-700 focus:ring-red-500 dark:focus:ring-offset-gray-800',
    'secondary' => 'bg-white text-gray-700 border-gray-300 dark:bg-gray-800 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 focus:ring-indigo-500',
    default => 'bg-gray-800 text-white hover:bg-gray-700 focus:ring-indigo-500 dark:bg-gray-200 dark:text-gray-800 dark:hover:bg-white',
};
@endphp

<button {{ $attributes->merge(['type' => 'submit', 'class' => "$baseClasses $classes"]) }}>
    {{ $slot }}