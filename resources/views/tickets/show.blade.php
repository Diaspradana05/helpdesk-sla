<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Tiket — {{ $ticket->ticket_number }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 space-y-3">
                <p><strong>Subjek:</strong> {{ $ticket->subject }}</p>
                <p><strong>Deskripsi:</strong> {{ $ticket->description }}</p>
                <p><strong>Customer:</strong> {{ $ticket->customer->name }}</p>
                <p><strong>Agent:</strong> {{ $ticket->agent->name ?? 'Belum di-assign' }}</p>
                <p><strong>Kategori:</strong> {{ $ticket->category->name }}</p>
                <p><strong>Prioritas:</strong> {{ $ticket->priority->name }}</p>
                <p><strong>Status:</strong> {{ $ticket->status->label() }}</p>

                <a href="{{ route('tickets.index') }}" class="inline-block mt-4 text-blue-600 hover:underline">← Kembali ke daftar</a>
            </div>
        </div>
    </div>
</x-app-layout>