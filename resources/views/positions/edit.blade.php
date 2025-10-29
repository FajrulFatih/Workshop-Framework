<!-- Modal toggle -->
<button data-modal-target="edit-modal-{{ $position->id }}" data-modal-toggle="edit-modal-{{ $position->id }}"
    class="text-black hover:underline dark:text-white"
    type="button">
    Edit
</button>

<!-- Main modal -->
<div id="edit-modal-{{ $position->id }}" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
            <!-- Modal header -->
            <div
                class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Edit Jabatan
                </h3>
                <button type="button"
                    class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-hide="edit-modal-{{ $position->id }}">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-5">
                <form class="space-y-4" action="{{ route('positions.update', $position->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div>
                        <label for="nama_jabatan" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Jabatan</label>
                        <input type="text" name="nama_jabatan" id="nama_jabatan"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                            placeholder="Nama Jabatan" value="{{ old('nama_jabatan', $position->nama_jabatan) }}" required />
                    </div>
                    <div>
                        <label for="gaji_pokok" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Gaji Pokok</label>
                        <input type="number" name="gaji_pokok" id="gaji_pokok"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                            placeholder="Gaji Pokok" value="{{ old('gaji_pokok', $position->gaji_pokok) }}" required />
                    </div>
                    <button type="submit"
                        class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Edit</button>
                </form>
            </div>
        </div>
    </div>
</div>
