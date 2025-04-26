<div id="productModal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden">
    <div class="bg-white rounded-lg p-6 w-[400px]">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold">Tambah Produk</h2>
            <button onclick="closeModal()" class="text-gray-500 hover:text-gray-700">&times;</button>
        </div>
        <!-- Modal Form -->
        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="submission_token" value="{{ $submissionToken }}">
            <!-- Product Name -->
            <div class="mb-4">
                <label for="productName" class="block text-sm font-medium text-gray-700">Nama Produk</label>
                <input type="text" name="name" id="productName" class="w-full rounded-md border border-gray-300 px-3 py-2 mt-1 focus:outline-none focus:ring-1 focus:ring-blue-500" placeholder="Masukkan nama" required>
            </div>

            <!-- Category and Supplier -->
            <div class="flex justify-between gap-3 mb-4">
                <div class="w-1/2">
                    <label for="productCategory" class="block text-sm font-medium text-gray-700">Kategori</label>
                    <select name="category_id" id="productCategory" class="w-full rounded-md border border-gray-300 px-3 py-2 mt-1 focus:outline-none focus:ring-1 focus:ring-blue-500" required>
                        <option value="">Pilih kategori</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="w-1/2">
                    <label for="productPrice" class="block text-sm font-medium text-gray-700">Harga</label>
                    <input type="text" name="price" id="productPrice" class="w-full rounded-md border border-gray-300 px-3 py-2 mt-1 focus:outline-none focus:ring-1 focus:ring-blue-500" placeholder="Masukkan harga" required>
                </div>
            </div>

            <!-- Stock and Supplier -->
            <div class="flex justify-between gap-3 mb-4">
                <div class="w-1/2">
                    <label for="productStock" class="block text-sm font-medium text-gray-700">Stok</label>
                    <input type="number" name="stock" id="productStock" class="w-full rounded-md border border-gray-300 px-3 py-2 mt-1 focus:outline-none focus:ring-1 focus:ring-blue-500" placeholder="Masukkan stok">
                </div>
                <div class="w-1/2">
                    <label for="productSupplier" class="block text-sm font-medium text-gray-700">Supplier</label>
                    <select name="supplier_id" id="productSupplier" class="w-full rounded-md border border-gray-300 px-3 py-2 mt-1 focus:outline-none focus:ring-1 focus:ring-blue-500" required>
                        <option value="">Pilih supplier</option>
                        @foreach ($suppliers as $supplier)
                            <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Product Description -->
            <div class="mb-4">
                <label for="productDescription" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                <textarea name="description" id="productDescription" class="w-full rounded-md border border-gray-300 px-3 py-2 mt-1 focus:outline-none focus:ring-1 focus:ring-blue-500" placeholder="Masukkan deskripsi" rows="3" required></textarea>
            </div>

            <!-- Product Photo (Drag and Drop) -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Foto Produk</label>
                <div id="dropzone" class="relative border-2 border-dashed border-gray-300 rounded-lg p-6 flex items-center justify-center bg-gray-50 hover:bg-gray-100 transition-colors">
                    <p class="text-gray-500">Drop/masukkan foto ke sini</p>
                    <input type="file" name="image" id="fileInput" class="absolute inset-0 opacity-0 cursor-pointer" accept="image/*">
                    <div id="preview" class="hidden mt-4">
                        <img id="imagePreview" src="" alt="Preview" class="max-w-full h-auto rounded">
                    </div>
                </div>
                <p id="message" class="mt-2 text-center text-sm text-gray-600"></p>
            </div>

            <!-- Buttons -->
            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeModal()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">Batal</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Simpan</button>
            </div>
        </form>
    </div>
</div>