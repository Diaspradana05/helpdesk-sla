<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Detail Tiket — {{ $ticket->ticket_number }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 space-y-6 overflow-hidden bg-white shadow-sm sm:rounded-lg">

                {{-- Notifikasi sukses --}}
                @if (session('success'))
                    <div class="p-4 text-sm text-green-700 rounded-lg bg-green-50">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Notifikasi error --}}
                @if (session('error'))
                    <div class="p-4 text-sm text-red-700 rounded-lg bg-red-50">
                        {{ session('error') }}
                    </div>
                @endif

                {{-- Informasi tiket --}}
                <div>
                    <h3 class="mb-4 text-lg font-semibold text-gray-800">
                        Informasi Tiket
                    </h3>

                    <div class="space-y-4">

                        <div>
                            <p class="text-sm font-medium text-gray-500">
                                Nomor Tiket
                            </p>
                            <p class="mt-1 font-semibold text-gray-900">
                                {{ $ticket->ticket_number }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-500">
                                Subjek
                            </p>
                            <p class="mt-1 text-gray-900">
                                {{ $ticket->subject }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-500">
                                Deskripsi
                            </p>
                            <p class="mt-1 text-gray-900 whitespace-pre-line">{{ $ticket->description }}</p>
                        </div>

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">

                            <div>
                                <p class="text-sm font-medium text-gray-500">
                                    Customer
                                </p>
                                <p class="mt-1 text-gray-900">
                                    {{ $ticket->customer->name ?? 'Tidak tersedia' }}
                                </p>
                            </div>

                            <div>
                                <p class="text-sm font-medium text-gray-500">
                                    Agent
                                </p>
                                <p class="mt-1 text-gray-900">
                                    {{ $ticket->agent->name ?? 'Belum di-assign' }}
                                </p>
                            </div>

                            <div>
                                <p class="text-sm font-medium text-gray-500">
                                    Kategori
                                </p>
                                <p class="mt-1 text-gray-900">
                                    {{ $ticket->category->name ?? 'Tidak tersedia' }}
                                </p>
                            </div>

                            <div>
                                <p class="text-sm font-medium text-gray-500">
                                    Prioritas
                                </p>
                                <p class="mt-1 text-gray-900">
                                    {{ $ticket->priority->name ?? 'Tidak tersedia' }}
                                </p>
                            </div>

                            <div>
                                <p class="text-sm font-medium text-gray-500">
                                    Status
                                </p>
                                <p class="mt-1 font-medium text-gray-900">
                                    {{ $ticket->status->label() }}
                                </p>
                            </div>

                        </div>
                    </div>
                </div>

                {{-- Lampiran --}}
                @if ($ticket->attachments->isNotEmpty())
                    <div class="pt-5 border-t">
                        <h3 class="mb-3 text-lg font-semibold text-gray-800">
                            Lampiran
                        </h3>

                        <ul class="space-y-3">
                            @foreach ($ticket->attachments as $attachment)
                                <li class="flex flex-col justify-between gap-2 p-3 border rounded-lg sm:flex-row sm:items-center">
                                    <div class="min-w-0">
                                        <a
                                            href="{{ \Illuminate\Support\Facades\Storage::url($attachment->path) }}"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            class="font-medium text-blue-600 break-words hover:underline"
                                        >
                                            {{ $attachment->original_name }}
                                        </a>

                                        <p class="mt-1 text-xs text-gray-500">
                                            {{ number_format($attachment->size / 1024, 1) }} KB
                                        </p>
                                    </div>

                                    <a
                                        href="{{ \Illuminate\Support\Facades\Storage::url($attachment->path) }}"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="text-sm text-blue-600 hover:underline"
                                    >
                                        Lihat Lampiran
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Perubahan status --}}
                @php
                    $nextStatuses = $ticket->status->allowedTransitions();
                @endphp

                @can('updateStatus', $ticket)
                    @if (count($nextStatuses) > 0)
                        <div class="pt-5 border-t">
                            <h3 class="mb-3 text-lg font-semibold text-gray-800">
                                Ubah Status Tiket
                            </h3>

                            <p class="mb-3 text-sm text-gray-500">
                                Pilih status berikutnya sesuai proses penanganan tiket.
                            </p>

                            <div class="flex flex-wrap gap-2">
                                @foreach ($nextStatuses as $status)
                                    <form
                                        action="{{ route('tickets.updateStatus', $ticket) }}"
                                        method="POST"
                                    >
                                        @csrf
                                        @method('PATCH')

                                        <input
                                            type="hidden"
                                            name="status"
                                            value="{{ $status->value }}"
                                        >

                                        <button
                                            type="submit"
                                            class="px-4 py-2 text-sm font-medium text-white bg-gray-800 rounded-lg hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2"
                                        >
                                            Ubah ke {{ $status->label() }}
                                        </button>
                                    </form>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endcan

                {{-- Navigasi --}}
                <div class="flex flex-wrap items-center justify-between gap-3 pt-5 border-t">
                    <a
                        href="{{ route('tickets.index') }}"
                        class="text-sm font-medium text-blue-600 hover:underline"
                    >
                        &larr; Kembali ke Daftar Tiket
                    </a>

                    @can('update', $ticket)
                    <a href="{{ route('tickets.edit', $ticket) }}" class="text-yellow-600 hover:underline">Edit Tiket</a>
                    @endcan
                </div>

            </div>
        </div>
    </div>
</x-app-layout>