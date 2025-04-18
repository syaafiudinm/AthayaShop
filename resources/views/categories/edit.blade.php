@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-slate-300 border-b border-gray-200 shadow-xl">
          <h1 class="text-3xl font-semibold mb-4">Edit Category</h1>
          <form action="{{ route('categories.update', ['id' => $category->id]) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
              <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
              <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}" class="p-2 mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
              @error('name')
              <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
              @enderror
            </div>
            <div class="mb-4">
              <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
              <textarea name="description" id="description" class="p-2 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" >{{old('description', $category->description)}}</textarea>
              @error('name')
              <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
              @enderror
            </div>
            <div class="flex justify-center">
              <button type="submit" class="px-4 py-2 bg-indigo-500 text-white rounded-md hover:bg-indigo-600">save</button>
            </div>
          </form>
        </div>
      </div>
    </div>
</div>
@endsection