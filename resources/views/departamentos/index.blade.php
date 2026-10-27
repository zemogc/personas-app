<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Departamentos
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-flash />

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <x-search-form :action="route('departamentos.index')" placeholder="Departamento o país" />

                    @can('gestionar-geografia')
                        <a href="{{ route('departamentos.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                            Nuevo departamento
                        </a>
                    @endcan
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-left text-sm text-gray-700">
                        <thead class="border-b bg-gray-50 text-xs uppercase text-gray-500">
                            <tr>
                                <th scope="col" class="px-4 py-3">Código</th>
                                <th scope="col" class="px-4 py-3">Departamento</th>
                                <th scope="col" class="px-4 py-3">País</th>
                                @can('gestionar-geografia')
                                    <th scope="col" class="px-4 py-3 text-right">Acciones</th>
                                @endcan
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            @forelse ($departamentos as $departamento)
                                <tr>
                                    <td class="px-4 py-3">{{ $departamento->depa_codi }}</td>
                                    <td class="px-4 py-3">{{ $departamento->depa_nomb }}</td>
                                    <td class="px-4 py-3">{{ $departamento->pais->pais_nomb }}</td>
                                    @can('gestionar-geografia')
                                        <td class="px-4 py-3 text-right whitespace-nowrap">
                                            <a href="{{ route('departamentos.edit', $departamento) }}" class="text-indigo-600 hover:text-indigo-900">Editar</a>
                                            <form action="{{ route('departamentos.destroy', $departamento) }}" method="POST" class="inline"
                                                  onsubmit="return confirm('¿Seguro que desea eliminar este registro?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="ml-3 text-red-600 hover:text-red-900">Eliminar</button>
                                            </form>
                                        </td>
                                    @endcan
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ Gate::allows('gestionar-geografia') ? 4 : 3 }}" class="px-4 py-6 text-center text-gray-500">
                                        {{ request()->filled('q') ? 'No hay resultados para «'.request('q').'».' : 'No hay registros.' }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $departamentos->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
