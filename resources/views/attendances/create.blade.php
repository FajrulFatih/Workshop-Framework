<div class="relative overflow-x-auto shadow-md sm:rounded-lg mb-4">
    <table class="w-full table-fixed text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <form action="{{ route('attendances.store') }}" method="POST">
            @csrf
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3 w-max">Nama Pegawai</th>
                    <th scope="col" class="px-6 py-3">Absen</th>
                </tr>
            </thead>
            <tbody>
                <tr
                    class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
                    <td class="px-6 py-4 align-top">
                        <label for="karyawan_id" class="sr-only">Pilih Pegawai</label>
                        <select name="karyawan_id" id="karyawan_id" required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                            <option value="">-- Pilih Pegawai --</option>
                            @foreach ($employees as $employee)
                                <option value="{{ $employee->id }}">{{ $employee->nama_lengkap }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td class="px-6 py-4 align-top">
                        <div class="flex flex-col md:flex-row md:items-end md:gap-3">
                            <div class="w-full md:w-40">
                                <label for="tanggal" class="sr-only">Tanggal</label>
                                <input type="date" name="tanggal" id="tanggal" required
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                    value="{{ old('tanggal', date('Y-m-d')) }}" />
                            </div>
                            <div class="w-full md:w-40">
                                <label for="status_absensi" class="sr-only">Status</label>
                                <select name="status_absensi" id="status_absensi" required
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                                    <option value="Hadir">Hadir</option>
                                    <option value="Sakit">Sakit</option>
                                    <option value="Izin">Izin</option>
                                    <option value="Alfa">Alfa</option>
                                </select>
                            </div>
                            <div class="w-full md:w-28">
                                <button type="submit"
                                    class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Absen</button>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </form>
    </table>
</div>
