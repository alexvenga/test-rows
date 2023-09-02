<x-app-layout>
    <h1 class="text-3xl font-bold">Uploaded excel rows</h1>
    @if($message = Session::get('success'))
        <div class="mt-8 font-bold text-green-700">
            {{ $message }}
        </div>
    @endif

    <div x-data="excelRowsTable(@js($excelRows))">

        <table class="table-auto mt-8">
            <thead>
            <tr>
                <th class="text-center px-4 py-2">Date</th>
                <th class="text-center px-4 py-2">Count</th>
            </tr>
            </thead>
            <tbody>
            <template x-for="(excelRowCount, excelRowDate) in excelRows">
                <tr class="border-t" x-transition>
                    <td x-text="excelRowDate" class="text-center text-sm px-4 py-2"></td>
                    <td x-text="excelRowCount" class="text-center px-4 py-2"></td>
                </tr>
            </template>
            </tbody>
        </table>

    </div>
</x-app-layout>
