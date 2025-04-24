<div id="productModal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden">
    <div class="bg-white rounded-lg p-6 w-[400px]">
        <h2 class="text-xl font-semibold mb-4">Tambah Produk</h2>
        
        <!-- Modal Form -->
        <form action="{{ route('products.store') }}" method="POST">
            @csrf
            <!-- Product Name -->
            <div class="mb-4">
                <label for="productName" class="block font-medium">Nama Produk</label>
                <input type="text" name="name" id="productName" class="w-full rounded border px-3 py-2 mt-1" placeholder="Nama Produk" required>
            </div>

            <!-- Product Description -->
            <div class="mb-4">
                <label for="productDescription" class="block font-medium">Deskripsi Produk</label>
                <textarea name="description" id="productDescription" class="w-full rounded border px-3 py-2 mt-1" placeholder="Deskripsi Produk" required></textarea>
            </div>

            <!-- Product Price -->
            <div class="mb-4">
                <label for="productPrice" class="block font-medium">Harga Produk</label>
                <input type="number" name="price" id="productPrice" class="w-full rounded border px-3 py-2 mt-1" placeholder="Harga Produk" required>
            </div>

            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeModal()" class="px-4 py-2 bg-gray-400 text-white rounded">Batal</button>
                <button type="submit" class="px-4 py-2 bg-black text-white rounded">Simpan</button>
            </div>
        </form>
    </div>
</div>