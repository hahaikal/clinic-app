<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Wilayah') }} : {{ $wilayah->nama_wilayah }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('admin.wilayah.update', $wilayah->id) }}">
                        @csrf
                        @method('PUT')

                        @include('admin.wilayah._form', ['tombol_submit' => 'Update Wilayah', 'wilayah' => $wilayah])
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>