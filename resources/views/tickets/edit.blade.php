<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Edit Tiket — {{ $ticket->ticket_number }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 overflow-hidden bg-white shadow-sm sm:rounded-lg">

                @if ($errors->any())
                    <div class="p-4 mb-4 text-red-700 rounded bg-red-50">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('tickets.update', $ticket) }}" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Subjek</label>
                        <input type="text" name="subject" value="{{ old('subject', $ticket->subject) }}" class="block w-full mt-1 border-gray-300 rounded">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                        <textarea name="description" rows="4" class="block w-full mt-1 border-gray-300 rounded">{{ old('description', $ticket->description) }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Kategori</label>
                        <select name="category_id" class="block w-full mt-1 border-gray-300 rounded">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected(old('category_id', $ticket->category_id) == $category->id)>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Prioritas</label>
                        <select name="priority_id" class="block w-full mt-1 border-gray-300 rounded">
                            @foreach ($priorities as $priority)
                                <option value="{{ $priority->id }}" @selected(old('priority_id', $ticket->priority_id) == $priority->id)>
                                    {{ $priority->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex justify-end gap-2">
                        <a href="{{ route('tickets.show', $ticket) }}" class="px-4 py-2 border rounded">Batal</a>
                        <button type="submit" class="px-4 py-2 text-white bg-gray-800 rounded hover:bg-gray-700">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>