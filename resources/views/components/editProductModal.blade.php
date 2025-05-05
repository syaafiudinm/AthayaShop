<!-- Edit Product Modal -->
<div id="editProductModal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center {{ $errors->any() && session('modal') == 'edit' ? '' : 'hidden' }}">
    <div class="bg-white rounded-lg p-6 w-[400px]">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold">Edit Produk</h2>
            <button onclick="closeEditModal()" class="text-gray-500 hover:text-gray-700">×</button>
        </div>
        <!-- Edit Modal Form -->
        <form id="editProductForm" action="" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" name="submission_token" value="{{ $submissionToken }}">
            <!-- Product Name -->
            <div class="mb-4">
                <label for="editProductName" class="block text-sm font-medium text-gray-700">Nama Produk</label>
                <input type="text" name="name" id="editProductName" class="w-full rounded-md border border-gray-300 px-3 py-2 mt-1 focus:outline-none focus:ring-1 focus:ring-blue-500" placeholder="Masukkan nama" required>
            </div>

            <!-- Category and Price -->
            <div class="flex justify-between gap-3 mb-4">
                <div class="w-1/2">
                    <label for="editProductCategory" class="block text-sm font-medium text-gray-700">Kategori</label>
                    <select name="category_id" id="editProductCategory" class="w-full rounded-md border border-gray-300 px-3 py-2 mt-1 focus:outline-none focus:ring-1 focus:ring-blue-500" required>
                        <option value="">Pilih kategori</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="w-1/2">
                    <label for="editProductPrice" class="block text-sm font-medium text-gray-700">Harga</label>
                    <input type="text" name="price" id="editProductPrice" class="w-full rounded-md border border-gray-300 px-3 py-2 mt-1 focus:outline-none focus:ring-1 focus:ring-blue-500" placeholder="Masukkan harga" required>
                </div>
            </div>

            <!-- Stock and Supplier -->
            <div class="flex justify-between gap-3 mb-4">
                <div class="w-1/2">
                    <label for="editProductStock" class="block text-sm font-medium text-gray-700">Stok</label>
                    <input type="number" name="stock" id="editProductStock" class="w-full rounded-md border border-gray-300 px-3 py-2 mt-1 focus:outline-none focus:ring-1 focus:ring-blue-500" placeholder="Masukkan stok">
                </div>
                <div class="w-1/2">
                    <label for="editProductSupplier" class="block text-sm font-medium text-gray-700">Supplier</label>
                    <select name="supplier_id" id="editProductSupplier" class="w-full rounded-md border border-gray-300 px-3 py-2 mt-1 focus:outline-none focus:ring-1 focus:ring-blue-500" required>
                        <option value="">Pilih supplier</option>
                        @foreach ($suppliers as $supplier)
                            <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Product Description -->
            <div class="mb-4">
                <label for="editProductDescription" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                <textarea name="description" id="editProductDescription" class="w-full rounded-md border border-gray-300 px-3 py-2 mt-1 focus:outline-none focus:ring-1 focus:ring-blue-500" placeholder="Masukkan deskripsi" rows="3" required></textarea>
            </div>

            <!-- Product Photo (Drag and Drop) -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Foto Produk</label>
                <div id="editDropzone" class="relative border-2 border-dashed border-gray-300 rounded-lg p-6 flex items-center justify-center bg-gray-50 hover:bg-gray-100 transition-colors">
                    <p class="text-gray-500">Drop/masukkan foto ke sini</p>
                    <input type="file" name="image" id="editFileInput" class="absolute inset-0 opacity-0 cursor-pointer" accept="image/*">
                    <div id="editPreview" class="hidden mt-4">
                        <img id="editImagePreview" src="" alt="Preview" class="max-w-full h-auto rounded">
                    </div>
                </div>
                <p id="editMessage" class="mt-2 text-center text-sm text-gray-600"></p>
            </div>

            <!-- Buttons -->
            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeEditModal()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">Batal</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Simpan</button>
            </div>
        </form>
    </div>
</div>