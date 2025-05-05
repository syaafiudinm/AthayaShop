@extends('layouts.app')

@section('content')

    <div class="flex-1 p-8">
        <h1 class="text-3xl font-semibold mb-6">Produk</h1>
        <div class="flex gap-4">
            <!-- Refresh Button -->
            <a href="{{ route('products') }}" class="flex items-center border border-gray-300 p-2 rounded-md gap-2 mt-1">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M11.15 3.36878C11.3254 3.48823 11.4461 3.67245 11.4856 3.88092C11.5252 4.08938 11.4803 4.30502 11.3608 4.48038C11.2413 4.65574 11.0571 4.77646 10.8487 4.816C10.6402 4.85553 10.4246 4.81063 10.2492 4.69118C9.51062 4.18909 8.62525 3.94861 7.73415 4.00805C6.84305 4.0675 5.99747 4.42345 5.33213 5.01919C4.66679 5.61494 4.21995 6.41621 4.06281 7.29536C3.90566 8.1745 4.04725 9.08096 4.46502 9.8703C4.88278 10.6596 5.55269 11.2865 6.36802 11.6509C7.18335 12.0154 8.0972 12.0965 8.96398 11.8814C9.83076 11.6662 10.6006 11.1672 11.1509 10.4638C11.7012 9.76039 12.0002 8.89306 12.0004 7.99998C12.0004 7.7878 12.0847 7.58432 12.2347 7.43429C12.3847 7.28426 12.5882 7.19998 12.8004 7.19998C13.0126 7.19998 13.2161 7.28426 13.3661 7.43429C13.5161 7.58432 13.6004 7.7878 13.6004 7.99998C13.6002 9.25037 13.1815 10.4647 12.4111 11.4496C11.6407 12.4344 10.5628 13.1331 9.34922 13.4342C8.13564 13.7354 6.85618 13.6218 5.71469 13.1114C4.57319 12.601 3.63534 11.7233 3.05056 10.6181C2.46578 9.51289 2.26772 8.24375 2.48792 7.0129C2.70813 5.78205 3.33394 4.66031 4.26564 3.82639C5.19734 2.99248 6.38134 2.49438 7.62897 2.41144C8.87661 2.32851 10.1161 2.66552 11.15 3.36878Z" fill="black"/>
                    <path d="M10.8319 10.0048C10.7434 10.0614 10.6446 10.1 10.5412 10.1185C10.4377 10.1369 10.3317 10.1348 10.229 10.1123C10.1264 10.0897 10.0292 10.0472 9.94303 9.98707C9.85685 9.92697 9.78334 9.85048 9.72672 9.76197C9.67009 9.67346 9.63145 9.57466 9.61301 9.47122C9.59456 9.36777 9.59668 9.26171 9.61922 9.15908C9.64177 9.05646 9.68431 8.95927 9.74441 8.87309C9.80451 8.7869 9.88101 8.71339 9.96952 8.65677L12.7551 6.87517C12.9338 6.76457 13.1489 6.72874 13.3538 6.77541C13.5587 6.82208 13.737 6.94751 13.8502 7.12459C13.9634 7.30167 14.0023 7.51617 13.9586 7.72174C13.915 7.9273 13.7921 8.10742 13.6167 8.22317L10.8319 10.0048Z" fill="black"/>
                    <path d="M15.123 9.92798C15.2047 10.1209 15.2074 10.3382 15.1306 10.5331C15.0538 10.728 14.9036 10.885 14.7123 10.9704C14.521 11.0558 14.3039 11.0627 14.1075 10.9897C13.9112 10.9167 13.7513 10.7696 13.6622 10.58L12.4558 7.87598C12.4106 7.77971 12.385 7.67539 12.3806 7.56913C12.3762 7.46286 12.393 7.35677 12.43 7.25708C12.4671 7.15738 12.5237 7.06608 12.5964 6.98851C12.6692 6.91094 12.7567 6.84865 12.8538 6.8053C12.9509 6.76195 13.0557 6.73841 13.1621 6.73604C13.2684 6.73367 13.3742 6.75253 13.4731 6.79152C13.5721 6.8305 13.6623 6.88883 13.7384 6.96308C13.8146 7.03734 13.8751 7.12604 13.9166 7.22398L15.123 9.92798Z" fill="black"/>
                </svg>
                Refresh                 
            </a>
            <a href="{{ route('categories') }}" class="flex items-center border border-gray-300 px-4 rounded-md gap-2 mt-1">
                semua                
            </a>
            <a href="{{ route('categories') }}" class="flex items-center border border-gray-300 px-4 rounded-md gap-2 mt-1">
                baju               
            </a>
            <a href="{{ route('categories') }}" class="flex items-center border border-gray-300 px-4 rounded-md gap-2 mt-1">
                celana                
            </a>
            <a href="{{ route('categories') }}" class="flex items-center border border-gray-300 px-4 rounded-md gap-2 mt-1">
                aksesoris                
            </a>
            <!-- Search Form (Move to the right) -->
            <form method="GET" action="{{ route('categories') }}" class="flex items-center border border-gray-300 rounded-lg p-2 ml-auto md:w-1/3">
                <!-- Search Icon -->
                <span class="text-gray-500 mr-2">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M13.0667 14L8.86667 9.8C8.53333 10.0667 8.15 10.2778 7.71667 10.4333C7.28333 10.5889 6.82222 10.6667 6.33333 10.6667C5.12222 10.6667 4.09733 10.2471 3.25867 9.408C2.42 8.56889 2.00044 7.544 2 6.33333C1.99956 5.12267 2.41911 4.09778 3.25867 3.25867C4.09822 2.41956 5.12311 2 6.33333 2C7.54356 2 8.56867 2.41956 9.40867 3.25867C10.2487 4.09778 10.668 5.12267 10.6667 6.33333C10.6667 6.82222 10.5889 7.28333 10.4333 7.71667C10.2778 8.15 10.0667 8.53333 9.8 8.86667L14 13.0667L13.0667 14ZM6.33333 9.33333C7.16667 9.33333 7.87511 9.04178 8.45867 8.45867C9.04222 7.87556 9.33378 7.16711 9.33333 6.33333C9.33289 5.49956 9.04133 4.79133 8.45867 4.20867C7.876 3.626 7.16756 3.33422 6.33333 3.33333C5.49911 3.33244 4.79089 3.62422 4.20867 4.20867C3.62644 4.79311 3.33467 5.50133 3.33333 6.33333C3.332 7.16533 3.62378 7.87378 4.20867 8.45867C4.79356 9.04356 5.50178 9.33511 6.33333 9.33333Z" fill="black"/>
                    </svg>                        
                </span>
                <!-- Search Input -->
                <input type="text" name="search" value="{{ request('search') }}" 
                    placeholder="Cari"
                    class="w-full bg-transparent border-none focus:ring-0 focus:outline-none placeholder-gray-500 text-gray-700" />
            </form>
        </div>
        {{-- End Search Form --}}

        <div class="mt-4">
            @include('components.alert')
        </div>

        {{-- Product List --}}
        <div class="mt-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                <!-- Add Product Card -->
                <button onclick="openModal()" class="p-4 rounded-lg shadow-lg border border-gray-300">
                    <div class="border-dashed border-2 border-gray-400 rounded-md h-[300px] mb-4 flex justify-center items-center">
                        <div class="text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10 mx-auto mb-2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class=" text-black font-semibold">Tambah Produk</span>
                        </div>
                    </div>
                </button>
            
                @foreach ($products as $product)
                    <div class="p-4 rounded-lg shadow-lg border border-gray-300">
                        <div class="bg-gray-200 rounded-md mb-4">
                            <img src="{{ asset('Uploads/produk/thumb/'.$product->image) }}" alt="{{ $product->name }}" class="object-cover rounded-md">
                        </div>
                        <h3 class="font-bold text-lg">{{ $product->name }}</h3>
                        <p class="text-sm text-black">{{ $product->description }}</p>
                        <div class="mb-9 mt-1">
                            <span class="bg-green-500 text-white px-3 py-2 rounded-full text-sm">{{ $product->stock }}</span>
                        </div>
                        <div class="flex justify-between">
                            <p class="font-semibold mt-2">Harga {{ $product->price }}</p>
                            <p class="text-xs text-gray-600 text-center mt-4">{{ $product->supplier->name }}</p>
                        </div>
                        <div class="flex justify-end mt-2 gap-2">
                            <a href="javascript:void(0)" onclick="openEditModal({
                                id: '{{ $product->id }}',
                                name: '{{ $product->name }}',
                                price: '{{ $product->price }}',
                                description: '{{ $product->description }}',
                                stock: '{{ $product->stock }}',
                                category_id: '{{ $product->category_id }}',
                                supplier_id: '{{ $product->supplier_id }}',
                                image: '{{ asset('Uploads/produk/thumb/'.$product->image) }}'
                            })" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                                Edit
                            </a>
                        </div>
                    </div>
                @endforeach
                <!-- Product Cards -->
                <!-- Duplicate above div for other cards -->
            </div>            
        </div>
        @include('components.createProductModal',['submissionToken' => $submissionToken])
        @include('components.editProductModal', ['submissionToken' => $submissionToken])
    </div>
    
    <script>
        // Open Create Modal
        function openModal() {
            document.getElementById('productModal').classList.remove('hidden');
        }
    
        // Close Create Modal
        function closeModal() {
            document.getElementById('productModal').classList.add('hidden');
            // Reset create form
            document.querySelector('#productModal form').reset();
            document.getElementById('preview').classList.add('hidden');
            document.getElementById('imagePreview').src = '';
            document.getElementById('message').textContent = '';
        }
    
        // Close Edit Modal
        function closeEditModal() {
            document.getElementById('editProductModal').classList.add('hidden');
            // Reset edit form
            document.querySelector('#editProductModal form').reset();
            document.getElementById('editPreview').classList.add('hidden');
            document.getElementById('editImagePreview').src = '';
            document.getElementById('editMessage').textContent = '';
        }
    
        // Open Edit Modal and Populate Fields
        function openEditModal(product) {
            const modal = document.getElementById('editProductModal');
            const form = document.getElementById('editProductForm');
            
            // Set form action to update route
            form.action = `/products/edit/${product.id}`;
    
            // Populate form fields
            document.getElementById('editProductName').value = product.name || '';
            document.getElementById('editProductCategory').value = product.category_id || '';
            document.getElementById('editProductPrice').value = product.price || '';
            document.getElementById('editProductStock').value = product.stock || '';
            document.getElementById('editProductSupplier').value = product.supplier_id || '';
            document.getElementById('editProductDescription').value = product.description || '';
    
            // Handle existing image preview
            const editPreview = document.getElementById('editPreview');
            const editImagePreview = document.getElementById('editImagePreview');
            if (product.image) {
                editPreview.classList.remove('hidden');
                editImagePreview.src = product.image;
            } else {
                editPreview.classList.add('hidden');
                editImagePreview.src = '';
            }
    
            // Show modal
            modal.classList.remove('hidden');
        }
    
        // Handle Drag and Drop for Create Modal
        const dropzone = document.getElementById('dropzone');
        const fileInput = document.getElementById('fileInput');
        const preview = document.getElementById('preview');
        const imagePreview = document.getElementById('imagePreview');
        const message = document.getElementById('message');
    
        if (dropzone && fileInput) {
            dropzone.addEventListener('dragover', (e) => {
                e.preventDefault();
                dropzone.classList.add('border-blue-500');
            });
    
            dropzone.addEventListener('dragleave', () => {
                dropzone.classList.remove('border-blue-500');
            });
    
            dropzone.addEventListener('drop', (e) => {
                e.preventDefault();
                dropzone.classList.remove('border-blue-500');
                const file = e.dataTransfer.files[0];
                handleFile(file);
            });
    
            fileInput.addEventListener('change', () => {
                const file = fileInput.files[0];
                handleFile(file);
            });
        }
    
        function handleFile(file) {
            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = () => {
                    preview.classList.remove('hidden');
                    imagePreview.src = reader.result;
                    message.textContent = file.name;
                };
                reader.readAsDataURL(file);
            } else {
                message.textContent = 'Please upload a valid image file';
            }
        }
    
        // Handle Drag and Drop for Edit Modal
        const editDropzone = document.getElementById('editDropzone');
        const editFileInput = document.getElementById('editFileInput');
        const editPreview = document.getElementById('editPreview');
        const editImagePreview = document.getElementById('editImagePreview');
        const editMessage = document.getElementById('editMessage');
    
        if (editDropzone && editFileInput) {
            editDropzone.addEventListener('dragover', (e) => {
                e.preventDefault();
                editDropzone.classList.add('border-blue-500');
            });
    
            editDropzone.addEventListener('dragleave', () => {
                editDropzone.classList.remove('border-blue-500');
            });
    
            editDropzone.addEventListener('drop', (e) => {
                e.preventDefault();
                editDropzone.classList.remove('border-blue-500');
                const file = e.dataTransfer.files[0];
                handleEditFile(file);
            });
    
            editFileInput.addEventListener('change', () => {
                const file = editFileInput.files[0];
                handleEditFile(file);
            });
        }
    
        function handleEditFile(file) {
            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = () => {
                    editPreview.classList.remove('hidden');
                    editImagePreview.src = reader.result;
                    editMessage.textContent = file.name;
                };
                reader.readAsDataURL(file);
            } else {
                editMessage.textContent = 'Please upload a valid image file';
            }
        }
    </script>
@endsection