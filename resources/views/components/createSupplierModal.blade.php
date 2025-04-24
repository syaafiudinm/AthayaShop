<div id="createSupplierModal" class="fixed inset-0 bg-black bg-opacity-50 {{ $errors->any() && session('modal') == 'create' ? 'flex' : 'hidden' }} justify-center items-center">
    <div class="bg-white rounded-lg p-6 w-[400px]">
        <h2 class="text-xl font-semibold mb-4">Tambah Supplier</h2>
        
        <!-- Modal Form -->
        <form action="{{ route('suppliers.store') }}" method="POST">
            @csrf

            <!-- Supplier Name -->
            <div class="mb-4">
                <label for="supplierName" class="block font-medium {{ $errors->has('name') ? 'text-red-500' : '' }} mb-2">Nama Supplier</label>
                <input type="text" name="name" id="supplierName" class="w-full rounded border px-3 py-2 mt-1 {{ $errors->has('name') ? 'border-red-500' : 'border-black'}} border-2 border-black rounded-lg bg-primary" value="{{ old('name') }}">
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Supplier contact -->
            <div class="mb-4">
                <label for="supplierContact" class="block font-medium {{ $errors->has('contact') ? 'text-red-500' : ''}} mb-2">Kontak Supplier</label>
                <input type="text" name="contact" id="suppliercontact" class="w-full rounded border px-3 py-2 mt-1 {{ $errors->has('contact') ? 'border-red-500' : 'border-black'}} border-2 border-black bg-primary rounded-lg" value="{{ old('contact') }}" placeholder="Telepon Supplier">
                @error('contact')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Supplier Address -->
            <div class="mb-4">
                <label for="supplierAddress" class="block font-medium {{ $errors->has('address') ? 'text-red-500' : ''}} mb-2">Alamat Supplier</label>
                <input type="text" name="address" id="supplierAddress" class="w-full rounded border px-3 py-2 mt-1 {{ $errors->has('address') ? 'border-red-500' : 'border-black'}} border-2 border-black bg-primary rounded-lg" value="{{ old('address') }}" placeholder="Alamat Supplier">
                @error('address')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>


            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeModal('createSupplierModal')" class="px-4 py-2 bg-primary text-black rounded-lg">Batal</button>
                <button type="submit" class="px-4 py-2 bg-primary text-black rounded-lg">Simpan</button>
            </div>
        </form>
    </div>
</div>
