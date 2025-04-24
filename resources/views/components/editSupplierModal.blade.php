<!-- Modal Edit -->
<div id="editModal" class="fixed z-50 inset-0 bg-black bg-opacity-50 hidden items-center justify-center">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-8">
        <h2 class="text-xl font-semibold mb-4">Edit Suppplier</h2>
        <form id="editForm" method="POST">
            @csrf
            @method('PUT')
            <!-- Nama Supplier -->
            <div class="mb-4">
                <label id="editLabelName" class="block font-medium mb-2">Nama Supplier</label>
                <input type="text" name="name" id="editName"
                    class="w-full rounded-lg px-3 py-2 border-2 border-black bg-primary" required>
                <p id="editErrorName" class="text-red-500 text-sm mt-1 hidden"></p>
            </div>

            <!-- Kontak Supplier -->
            <div class="mb-4">
                <label id="editLabelContact" class="block font-medium mb-2">Kontak Supplier</label>
                <input type="text" name="contact" id="editContact"
                    class="w-full px-3 py-2 border-2 border-black bg-primary rounded-lg">
                <p id="editErrorContact" class="text-red-500 text-sm mt-1 hidden" required ></p>
            </div>

            {{-- Alamat Supplier --}}
            <div class="mb-4">
                <label id="editLabelAddress" class="block font-medium mb-2">Alamat Supplier</label>
                <input type="text" name="address" id="editAddress"
                    class="w-full rounded-lg px-3 py-2 border-2 border-black bg-primary">
                <p id="editErrorAddress" class="text-red-500 text-sm mt-1 hidden" required ></p>
            </div>

            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeModal('editModal')" class="px-4 py-2 bg-primary text-black rounded-lg">Batal</button>
                <button type="submit" class="px-4 py-2 bg-primary text-black rounded-lg">Update</button>
            </div>
        </form>
    </div>
</div>
