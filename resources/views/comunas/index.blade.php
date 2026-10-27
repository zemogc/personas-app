<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Comunas
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-flash />

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <x-search-form :action="route('comunas.index')" placeholder="Buscar por comuna o municipio" />

                    <a href="{{ route('comunas.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                        Nueva comuna
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-left text-sm text-gray-700">
                        <thead class="border-b bg-gray-50 text-xs uppercase text-gray-500">
                            <tr>
                                <th scope="col" class="px-4 py-3">Código</th>
                                <th scope="col" class="px-4 py-3">Comuna</th>
                                <th scope="col" class="px-4 py-3">Municipio</th>
                                <th scope="col" class="px-4 py-3 text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            @forelse ($comunas as $comuna)
                                <tr>
                                    <td class="px-4 py-3">{{ $comuna->comu_codi }}</td>
                                    <td class="px-4 py-3">{{ $comuna->comu_nomb }}</td>
                                    <td class="px-4 py-3">{{ $comuna->municipio->muni_nomb }}</td>
                                    <td class="px-4 py-3 text-right whitespace-nowrap">
                                        <a href="{{ route('comunas.edit', $comuna) }}" class="text-indigo-600 hover:text-indigo-900">Editar</a>
                                        <form action="{{ route('comunas.destroy', $comuna) }}" method="POST" class="inline"
                                              onsubmit="return confirm('¿Seguro que desea eliminar este registro?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="ml-3 text-red-600 hover:text-red-900">Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-6 text-center text-gray-500">
                                        {{ request()->filled('q') ? 'No hay resultados para «'.request('q').'».' : 'No hay registros.' }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $comunas->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
