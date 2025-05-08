<div id="productDetailModal" class="hidden fixed inset-0 bg-black bg-opacity-50 items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 w-full max-w-fit">
        <div class="flex justify-between items-center mb-4">
            <button onclick="closeModalById('productDetailModal')" class="text-gray-500 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <div class="flex flex-row gap-3">
            <img id="detailImage" src="" alt="Product Image" class="h-48 object-cover rounded-md mb-4">
            <div class="flex-1">
                <h3 id="detailName" class="text-xl text-lead text-gray-800 font-bold"></h3>
                <p id="detailDescription" class="text-sm text-gray-600 mb-2"></p>
                <p id="detailStock" class="text-sm mb-2"><span class="font-semibold">Stok:</span> <span class="bg-[#C7EEFF] text-black px-2 py-1 rounded-lg text-xs"></span></p>
                <p id="detailPrice" class="text-sm mb-2"><span class="font-semibold">Harga:</span> </p>
                <p id="detailSupplier" class="text-sm mb-2"><span class="font-semibold">Supplier:</span> </p>
                <p id="detailCategory" class="text-sm mb-4"><span class="font-semibold">Kategori:</span> </p>
            </div>
        </div>
        <div class="flex justify-end">
            <button onclick="closeModalById('productDetailModal')" class="px-4 py-2 border border-1 border-gray-300 rounded-md">Tutup</button>
        </div>
    </div>
</div>