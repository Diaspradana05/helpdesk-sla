<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Buat Tiket Baru
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

                <form method="POST" action="{{ route('tickets.store') }}" class="space-y-4">
                    @csrf

                    @if ($customers->isNotEmpty())
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Customer</label>
                            <select name="customer_id" class="block w-full mt-1 border-gray-300 rounded">
                                <option value="">-- Pilih Customer --</option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}" @selected(old('customer_id') == $customer->id)>
                                        {{ $customer->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Subjek</label>
                        <input type="text" name="subject" value="{{ old('subject') }}" class="block w-full mt-1 border-gray-300 rounded">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                        <textarea name="description" rows="4" class="block w-full mt-1 border-gray-300 rounded">{{ old('description') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Kategori</label>
                        <select name="category_id" class="block w-full mt-1 border-gray-300 rounded">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Prioritas</label>
                        <select name="priority_id" class="block w-full mt-1 border-gray-300 rounded">
                            <option value="">-- Pilih Prioritas --</option>
                            @foreach ($priorities as $priority)
                                <option value="{{ $priority->id }}" @selected(old('priority_id') == $priority->id)>
                                    {{ $priority->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex justify-end gap-2">
                        <a href="{{ route('tickets.index') }}" class="px-4 py-2 border rounded">Batal</a>
                        <button type="submit" class="px-4 py-2 text-white bg-gray-800 rounded hover:bg-gray-700">
                            Simpan Tiket
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>