<!-- Modal Edit -->
<div id="editModal" class="fixed z-50 inset-0 bg-black bg-opacity-50 hidden items-center justify-center">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-8">
        <h2 class="text-xl font-semibold mb-4">Edit Suppplier</h2>
        <form id="editForm" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="submission_token" value="{{ $submissionToken }}">
            <!-- Nama Supplier -->
            <div class="mb-4">
                <label id="editLabelName" class="block font-medium {{ $errors->has('name') ? 'text-red-500' : '' }} mb-2">Nama Supplier</label>
                <input type="text" name="name" id="editName"
                    class="w-full rounded-lg px-3 py-2 {{ $errors->has('name') ? 'border-red-500' : 'border-black' }} border-2 border-black bg-input" value="{{ old('name') }} ">
                <p id="editErrorName" class="text-red-500 text-sm mt-1 hidden" required></p>
            </div>

            <!-- Kontak Supplier -->
            <div class="mb-4">
                <label id="editLabelContact" class="block font-medium mb-2 {{ $errors->has('contact') ? 'text-red-500' : '' }}">Kontak Supplier</label>
                <input type="text" name="contact" id="editContact"
                    class="w-full px-3 py-2 {{ $errors->has('contact') ? 'border-red-500' : 'border-black' }} border-2 border-black bg-input rounded-lg" value="{{ old('contact') }}">
                <p id="editErrorContact" class="text-red-500 text-sm mt-1 hidden" required ></p>
            </div>

            {{-- Alamat Supplier --}}
            <div class="mb-4">
                <label id="editLabelAddress" class="block font-medium mb-2 {{ $errors->has('address') ? 'text-red-500' : '' }}">Alamat Supplier</label>
                <input type="text" name="address" id="editAddress"
                    class="w-full rounded-lg px-3 py-2 {{ $errors->has('address') ? 'border-red-500' : 'border-black' }} border-2 border-black bg-input" value="{{ old('address') }}">
                <p id="editErrorAddress" class="text-red-500 text-sm mt-1 hidden" required ></p>
            </div>

            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeModal('editModal')" class="px-4 py-2 bg-primary text-white rounded-lg">Batal</button>
                <button type="submit" class="px-4 py-2 bg-primary text-white rounded-lg">Update</button>
            </div>
        </form>
    </div>
</div>
