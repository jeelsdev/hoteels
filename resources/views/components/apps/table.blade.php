<div class="flex flex-col my-6 mx-4 rounded-2xl shadow-xl shadow-gray-200">
    <div class="overflow-x-auto rounded-2xl">
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