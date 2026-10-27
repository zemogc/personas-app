<div>
    <x-input-label for="depa_nomb" value="Nombre" />
    <x-text-input id="depa_nomb" name="depa_nomb" type="text" class="mt-1 block w-full" :value="old('depa_nomb', $departamento?->depa_nomb)" required maxlength="50" />
    <x-input-error :messages="$errors->get('depa_nomb')" class="mt-2" />
</div>

<div>
    <x-input-label for="pais_codi" value="País" />
    <x-select-input id="pais_codi" name="pais_codi" class="mt-1 block w-full" :options="$paises->pluck('pais_nomb', 'pais_codi')" :selected="old('pais_codi', $departamento?->pais_codi)" placeholder="Seleccione una opción" required />
    <x-input-error :messages="$errors->get('pais_codi')" class="mt-2" />
</div>

<div class="flex items-center gap-4">
    <x-primary-button>Guardar</x-primary-button>
    <a href="{{ route('departamentos.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Cancelar</a>
</div>
