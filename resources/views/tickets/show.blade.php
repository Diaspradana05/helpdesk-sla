<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Detail Tiket — {{ $ticket->ticket_number }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 space-y-3 overflow-hidden bg-white shadow-sm sm:rounded-lg">
                @if (session('success'))
    <div class="p-4 mb-4 text-green-700 rounded bg-green-50">
        {{ session('success') }}
    </div>
    @endif
    @if (session('error'))
    <div class="mb-4 p-4 bg-red-50 text-red-700 rounded">
        {{ session('error') }}
    </div>
@endif

@php
    $nextStatuses = $ticket->status->allowedTransitions();
@endphp

@if (auth()->user()->hasAnyRole(['admin', 'agent']) && count($nextStatuses) > 0)
    <div class="border-t pt-4 mt-4">
        <p class="font-medium mb-2">Ubah Status</p>
        <div class="flex gap-2">
            @foreach ($nextStatuses as $status)
                <form action="{{ route('tickets.updateStatus', $ticket) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="{{ $status->value }}">
                    <button type="submit" class="px-3 py-1.5 bg-gray-800 text-white rounded hover:bg-gray-700 text-sm">
                        → {{ $status->label() }}
                    </button>
                </form>
            @endforeach
        </div>
    </div>
@endif
                <p><strong>Subjek:</strong> {{ $ticket->subject }}</p>
                <p><strong>Deskripsi:</strong> {{ $ticket->description }}</p>
                <p><strong>Customer:</strong> {{ $ticket->customer->name }}</p>
                <p><strong>Agent:</strong> {{ $ticket->agent->name ?? 'Belum di-assign' }}</p>
                <p><strong>Kategori:</strong> {{ $ticket->category->name }}</p>
                <p><strong>Prioritas:</strong> {{ $ticket->priority->name }}</p>
                <p><strong>Status:</strong> {{ $ticket->status->label() }}</p>

             <div class="flex gap-4 mt-4">
                <a href="{{ route('tickets.index') }}" class="text-blue-600 hover:underline">← Kembali ke daftar</a>
                <a href="{{ route('tickets.edit', $ticket) }}" class="text-yellow-600 hover:underline">Edit Tiket</a>
            </div>
        </div>
    </div>
</x-app-layout>