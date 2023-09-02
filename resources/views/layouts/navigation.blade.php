<nav class="bg-white border-b shadow">
    <div class="container">

        <div class="flex items-center space-x-4 py-4">

            <a href="{{ route('home') }}" @class([
                    'text-blue-700 underline hover:no-underline',
                    'text-black no-underline'=>\Route::is('home'),
                    ])>Home</a>

            <a href="{{ route('rows.index') }}" @class([
                    'text-blue-700 underline hover:no-underline',
                    'text-black no-underline'=>\Route::is('rows.index'),
                    ])>Rows</a>

            <a href="{{ route('rows.create') }}" @class([
                    'text-blue-700 underline hover:no-underline',
                    'text-black no-underline'=>\Route::is('rows.create'),
                    ])>Upload Excel</a>

        </div>

    </div>

</nav>
