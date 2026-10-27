<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-2">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Hola, {{ $usuario->name }}
            </h2>
            <span @class([
                'inline-flex items-center rounded-full px-3 py-1 text-xs font-medium',
                'bg-indigo-100 text-indigo-800' => $usuario->esAdmin(),
                'bg-gray-100 text-gray-700' => ! $usuario->esAdmin(),
            ])>
                {{ $usuario->rol->etiqueta() }}
            </span>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                @foreach (config('geografia.menu') as $ruta => $etiqueta)
                    <a href="{{ route($ruta.'.index') }}"
                       class="group bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 transition hover:shadow-md hover:ring-1 hover:ring-indigo-200">
                        <p class="text-sm font-medium text-gray-500">{{ $etiqueta }}</p>
                        <p class="mt-2 text-3xl font-semibold text-gray-900">{{ number_format($totales[$ruta], 0, ',', '.') }}</p>
                        <p class="mt-4 text-sm text-indigo-600 group-hover:text-indigo-800">Ver listado &rarr;</p>
                    </a>
                @endforeach
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900">Departamentos con más municipios</h3>

                @if ($departamentosDestacados->isEmpty())
                    <p class="mt-4 text-sm text-gray-500">Todavía no hay departamentos registrados.</p>
                @else
                    @php($maximo = max($departamentosDestacados->max('municipios_count'), 1))
                    <ul class="mt-4 space-y-3">
                        @foreach ($departamentosDestacados as $departamento)
                            <li>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-700">{{ $departamento->depa_nomb }} <span class="text-gray-400">· {{ $departamento->pais->pais_nomb }}</span></span>
                                    <span class="font-medium text-gray-900">{{ $departamento->municipios_count }}</span>
                                </div>
                                <div class="mt-1 h-2 rounded-full bg-gray-100">
                                    <div class="h-2 rounded-full bg-indigo-500" style="width: {{ round($departamento->municipios_count / $maximo * 100) }}%"></div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

            @unless ($usuario->esAdmin())
                <p class="text-sm text-gray-500">
                    Tienes acceso de solo lectura. Pide a un administrador que te asigne el rol si necesitas modificar los catálogos.
                </p>
            @endunless
        </div>
    </div>
</x-app-layout>
