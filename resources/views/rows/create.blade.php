<x-app-layout>
    <h1 class="text-3xl font-bold">Upload excel file with rows</h1>
    @if($message = Session::get('success'))
        <div class="mt-8 font-bold text-green-700">
            {{ $message }}
        </div>
    @endif
    <form method="post" enctype="multipart/form-data" action="{{ route('rows.store') }}" class="mt-8">
        @csrf
        <label class="block space-y-1">
            <input type="file" class="block" name="excel-file"/>
            <p class="text-xs">Only .xlsx files</p>
            @error('excel-file')
                <p class="text-xs font-bold text-red-700">{{ $message }}</p>
            @enderror
        </label>
        <div class="mt-4">
            <button type="submit" class="shadow-lg hover:shadow px-4 py-2 bg-gray-700 hover:bg-gray-600 text-white rounded">
                Upload
            </button>
        </div>
    </form>
</x-app-layout>
