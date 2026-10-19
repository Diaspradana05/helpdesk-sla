<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Daftar Tiket
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <a href="{{ route('tickets.create') }}" class="inline-block mb-4 px-4 py-2 bg-gray-800 text-white rounded hover:bg-gray-700">
                    + Buat Tiket Baru
                </a>

                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b">
                            <th class="py-2">No. Tiket</th>
                            <th class="py-2">Subjek</th>
                            <th class="py-2">Customer</th>
                            <th class="py-2">Agent</th>
                            <th class="py-2">Prioritas</th>
                            <th class="py-2">Status</th>
                            <th class="py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($tickets as $ticket)
                            <tr class="border-b">
                                <td class="py-2">{{ $ticket->ticket_number }}</td>
                                <td class="py-2">{{ $ticket->subject }}</td>
                                <td class="py-2">{{ $ticket->customer->name }}</td>
                                <td class="py-2">{{ $ticket->agent->name ?? '-' }}</td>
                                <td class="py-2">{{ $ticket->priority->name }}</td>
                                <td class="py-2">{{ $ticket->status->label() }}</td>
                            <td class="py-2 space-x-2">
                                <a href="{{ route('tickets.show', $ticket) }}" class="text-blue-600 hover:underline">Lihat</a>
                                @can('update', $ticket)
                                <a href="{{ route('tickets.edit', $ticket) }}" class="text-yellow-600 hover:underline">Edit</a>
                                @endcan
                                @can('delete', $ticket)
                                <form action="{{ route('tickets.destroy', $ticket) }}" method="POST" class="inline"
                                onsubmit="return confirm('Yakin ingin menghapus tiket ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                            </form>
                            @endcan
                        </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-4 text-center text-gray-500">Belum ada tiket.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $tickets->links() }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>