<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Buat Tiket Baru
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 overflow-hidden bg-white shadow-sm sm:rounded-lg">

                {{-- Menampilkan pesan error validasi --}}
                @if ($errors->any())
                    <div class="p-4 mb-4 text-red-700 rounded bg-red-50">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form
                    method="POST"
                    action="{{ route('tickets.store') }}"
                    class="space-y-4"
                    enctype="multipart/form-data"
                >
                    @csrf

                    {{-- Customer --}}
                    @if ($customers->isNotEmpty())
                        <div>
                            <label for="customer_id"
                                class="block text-sm font-medium text-gray-700">
                                Customer
                            </label>

                            <select
                                id="customer_id"
                                name="customer_id"
                                class="block w-full mt-1 border-gray-300 rounded"
                                required
                            >
                                <option value="">-- Pilih Customer --</option>

                                @foreach ($customers as $customer)
                                    <option
                                        value="{{ $customer->id }}"
                                        @selected(old('customer_id') == $customer->id)
                                    >
                                        {{ $customer->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    {{-- Subjek --}}
                    <div>
                        <label for="subject"
                            class="block text-sm font-medium text-gray-700">
                            Subjek
                        </label>

                        <input
                            id="subject"
                            type="text"
                            name="subject"
                            value="{{ old('subject') }}"
                            class="block w-full mt-1 border-gray-300 rounded"
                            required
                        >
                    </div>

                    {{-- Deskripsi --}}
                    <div>
                        <label for="description"
                            class="block text-sm font-medium text-gray-700">
                            Deskripsi
                        </label>

                        <textarea
                            id="description"
                            name="description"
                            rows="4"
                            class="block w-full mt-1 border-gray-300 rounded"
                            required
                        >{{ old('description') }}</textarea>
                    </div>

                    {{-- Kategori --}}
                    <div>
                        <label for="category_id"
                            class="block text-sm font-medium text-gray-700">
                            Kategori
                        </label>

                        <select
                            id="category_id"
                            name="category_id"
                            class="block w-full mt-1 border-gray-300 rounded"
                            required
                        >
                            <option value="">-- Pilih Kategori --</option>

                            @foreach ($categories as $category)
                                <option
                                    value="{{ $category->id }}"
                                    @selected(old('category_id') == $category->id)
                                >
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Prioritas --}}
                    <div>
                        <label for="priority_id"
                            class="block text-sm font-medium text-gray-700">
                            Prioritas
                        </label>

                        <select
                            id="priority_id"
                            name="priority_id"
                            class="block w-full mt-1 border-gray-300 rounded"
                            required
                        >
                            <option value="">-- Pilih Prioritas --</option>

                            @foreach ($priorities as $priority)
                                <option
                                    value="{{ $priority->id }}"
                                    @selected(old('priority_id') == $priority->id)
                                >
                                    {{ $priority->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Lampiran --}}
                    <div>
                        <label for="attachments"
                            class="block text-sm font-medium text-gray-700">
                            Lampiran (opsional)
                        </label>

                        <input
                            id="attachments"
                            type="file"
                            name="attachments[]"
                            multiple
                            accept=".pdf,.jpg,.jpeg,.png,.docx"
                            class="block w-full mt-1 text-sm"
                        >

                        <p class="mt-1 text-xs text-gray-500">
                            Format: PDF, JPG, JPEG, PNG, DOCX.
                            Maksimal 5 MB per file.
                        </p>
                    </div>

                    {{-- Tombol --}}
                    <div class="flex justify-end gap-2">
                        <a
                            href="{{ route('tickets.index') }}"
                            class="px-4 py-2 border rounded hover:bg-gray-100"
                        >
                            Batal
                        </a>

                        <button
                            type="submit"
                            class="px-4 py-2 text-white bg-gray-800 rounded hover:bg-gray-700"
                        >
                            Simpan Tiket
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
