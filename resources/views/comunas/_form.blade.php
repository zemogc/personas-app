<div>
    <x-input-label for="comu_nomb" value="Nombre" />
    <x-text-input id="comu_nomb" name="comu_nomb" type="text" class="mt-1 block w-full" :value="old('comu_nomb', $comuna?->comu_nomb)" required maxlength="50" />
    <x-input-error :messages="$errors->get('comu_nomb')" class="mt-2" />
</div>

<div>
    <x-input-label for="muni_codi" value="Municipio" />
    <x-select-input id="muni_codi" name="muni_codi" class="mt-1 block w-full" :options="$municipios->pluck('muni_nomb', 'muni_codi')" :selected="old('muni_codi', $comuna?->muni_codi)" placeholder="Seleccione una opción" required />
    <x-input-error :messages="$errors->get('muni_codi')" class="mt-2" />
</div>

<div class="flex items-center gap-4">
    <x-primary-button>Guardar</x-primary-button>
    <a href="{{ route('comunas.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Cancelar</a>
</div>
