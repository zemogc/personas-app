<div>
    <x-input-label for="muni_nomb" value="Nombre" />
    <x-text-input id="muni_nomb" name="muni_nomb" type="text" class="mt-1 block w-full" :value="old('muni_nomb', $municipio?->muni_nomb)" required maxlength="50" />
    <x-input-error :messages="$errors->get('muni_nomb')" class="mt-2" />
</div>

<div>
    <x-input-label for="depa_codi" value="Departamento" />
    <x-select-input id="depa_codi" name="depa_codi" class="mt-1 block w-full" :options="$departamentos->pluck('depa_nomb', 'depa_codi')" :selected="old('depa_codi', $municipio?->depa_codi)" placeholder="Seleccione una opción" required />
    <x-input-error :messages="$errors->get('depa_codi')" class="mt-2" />
</div>

<div class="flex items-center gap-4">
    <x-primary-button>Guardar</x-primary-button>
    <a href="{{ route('municipios.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Cancelar</a>
</div>
