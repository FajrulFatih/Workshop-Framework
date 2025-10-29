<!-- Modal toggle -->
<button data-modal-target="detail-modal-{{ $employee->id }}" data-modal-toggle="detail-modal-{{ $employee->id }}" class="hover:underline text-black dark:text-white">
    Detail
</button>

<!-- Main modal -->
<div id="detail-modal-{{ $employee->id }}" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
            <!-- Modal header -->
            <div
                class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Detail Pegawai
                </h3>
                <button type="button"
                    class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-hide="detail-modal-{{ $employee->id }}">
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
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <tr>
                            <th scope="row" class="px-6 py-3 min-w-[150px]">
                                Nama Lengkap
                            </th>
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $employee->nama_lengkap }}
                            </td>
                        </tr>
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Email
                            </th>
                            <td class="px-6 py-4">
                                {{ $employee->email }}
                            </td>
                        </tr>
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Nomor Telepon
                            </th>
                            <td class="px-6 py-4">
                                {{ $employee->nomor_telepon }}
                            </td>
                        </tr>
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Tanggal Lahir
                            </th>
                            <td class="px-6 py-4">
                                {{ date('d/m/Y', strtotime($employee->tanggal_lahir)) }}
                            </td>
                        </tr>
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Alamat
                            </th>
                            <td class="px-6 py-4">
                                {{ $employee->alamat }}
                            </td>
                        </tr>
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Departemen
                            </th>
                            <td class="px-6 py-4">
                                {{ $employee->department->nama_department ?? '' }}
                            </td>
                        </tr>
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Jabatan
                            </th>
                            <td class="px-6 py-4">
                                {{ $employee->position->nama_jabatan ?? '' }}
                            </td>
                        </tr>
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Tanggal Masuk
                            </th>
                            <td class="px-6 py-4">
                                {{ date('d/m/Y', strtotime($employee->tanggal_masuk)) }}
                            </td>
                        </tr>
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Status
                            </th>
                            <td class="px-6 py-4">
                                {{ $employee->status }}
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
