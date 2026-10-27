@props(['action', 'placeholder' => 'Buscar...'])

<form method="GET" action="{{ $action }}" role="search" {{ $attributes->merge(['class' => 'flex items-center gap-2']) }}>
    <label for="q" class="sr-only">Buscar</label>
    <x-text-input id="q" name="q" type="search" class="block w-full sm:w-80" :value="request('q')" :placeholder="$placeholder" />
    <x-secondary-button type="submit">Buscar</x-secondary-button>
    @if (request()->filled('q'))
        <a href="{{ $action }}" class="text-sm text-gray-600 hover:text-gray-900 whitespace-nowrap">Limpiar</a>
    @endif
</form>
