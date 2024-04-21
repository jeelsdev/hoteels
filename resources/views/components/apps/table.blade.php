<div class="flex flex-col mx-4">
    <div class="overflow-x-auto">
        <div class="inline-block min-w-full align-middle">
            <div class="overflow-hidden shadow-lg">
                <table class="min-w-full divide-y divide-gray-200 table-fixed">
                    <thead class="bg-white">
                       {{ $head }}
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        {{ $slot }}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>