@extends(Auth::user()->isAdmin() ? 'layouts.master' : 'layouts.user')
@section('title', 'Daftar Kehadiran')
@section('Page-title', 'Daftar Kehadiran')
@section('content')
    @include('attendances.create')
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Pegawai
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Tanggal Kehadiran
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Waktu Masuk
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Waktu Keluar
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Status
                    </th>
                    @if(Auth::user()->isAdmin())
                    <th scope="col" class="px-6 py-3">
                        Aksi
                    </th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse ($attendances as $attendance)
                    <tr
                        class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $attendance->karyawan->nama_lengkap }}</td>
                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ date('d/m/Y', strtotime($attendance->tanggal)) }}</td>
                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ date('H:i:s', strtotime($attendance->waktu_masuk)) }}</td>
                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $attendance->waktu_keluar ? date('H:i:s', strtotime($attendance->waktu_keluar)) : '-' }}</td>
                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $attendance->status_absensi }}</td>
                        @if (Auth::user()->isAdmin())
                            <td class="px-6 py-4">
                                <form action="{{ route('attendances.destroy', $attendance->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline dark:text-red-400"
                                        onclick="return confirm('Yakin ingin menghapus?')">Delete</button>
                                </form>
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ Auth::user()->isAdmin() ? '6' : '5' }}" class="px-6 py-4 text-center text-gray-500">
                            Belum ada data kehadiran
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
