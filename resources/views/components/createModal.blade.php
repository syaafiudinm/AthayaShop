<!-- Modal Create -->
<div id="createModal" class="fixed z-50 inset-0 bg-black bg-opacity-50 {{ $errors->any() && session('modal') == 'create' ? 'flex' : 'hidden' }} items-center justify-center">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
        <h2 class="text-xl font-semibold mb-4">Tambah Kategori</h2>
        <form action="{{ route('categories.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="name" class="block font-medium {{ $errors->has('name') ? 'text-red-500' : '' }}">Nama</label>
                <input type="text" name="name" id="name"
                    class="w-full rounded px-3 py-2 border {{ $errors->has('name') ? 'border-red-500' : 'border-gray-300' }}"
                    value="{{ old('name') }}">
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="description" class="block font-medium {{ $errors->has('description') ? 'text-red-500' : '' }}">Deskripsi</label>
                <input type="text" name="description" id="description" class="w-full border border-gray-300 rounded px-3 py-2 {{ $errors->has('description') ? 'border-red-500' : '' }}" value="{{ old('description') }}">
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeModal('createModal')" class="px-4 py-2 bg-gray-400 text-white rounded">Batal</button>
                <button type="submit" class="px-4 py-2 bg-black text-white rounded">Simpan</button>
            </div>
        </form>
    </div>
</div>
