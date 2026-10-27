{{-- El código es la llave primaria: solo se captura al crear. --}}
@if (! $pais)
<div>
    <x-input-label for="pais_codi" value="Código ISO (3 letras)" />
    <x-text-input id="pais_codi" name="pais_codi" type="text" class="mt-1 block w-full" :value="old('pais_codi', $pais?->pais_codi)" required maxlength="3" />
    <x-input-error :messages="$errors->get('pais_codi')" class="mt-2" />
</div>
@endif

<div>
    <x-input-label for="pais_nomb" value="Nombre" />
    <x-text-input id="pais_nomb" name="pais_nomb" type="text" class="mt-1 block w-full" :value="old('pais_nomb', $pais?->pais_nomb)" required maxlength="50" />
    <x-input-error :messages="$errors->get('pais_nomb')" class="mt-2" />
</div>

<div>
    <x-input-label for="pais_capi" value="Municipio capital" />
    <x-select-input id="pais_capi" name="pais_capi" class="mt-1 block w-full" :options="$municipios->pluck('muni_nomb', 'muni_codi')" :selected="old('pais_capi', $pais?->pais_capi)" placeholder="Sin capital" />
    <x-input-error :messages="$errors->get('pais_capi')" class="mt-2" />
</div>

<div class="flex items-center gap-4">
    <x-primary-button>Guardar</x-primary-button>
    <a href="{{ route('paises.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Cancelar</a>
</div>
