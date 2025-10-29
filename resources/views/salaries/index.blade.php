@extends('master')
@section('title', 'Daftar Bayaran')
@section('Page-title', 'Daftar Bayaran Pegawai')
@section('content')
    @include('salaries.create')
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Nama Pegawai
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Bulan
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Gaji Pokok
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Tunjangan
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Potongan
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Total Gaji
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($salaries as $salary)
                    <tr
                        class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $salary->karyawan->nama_lengkap ?? '-' }}</td>
                        <td class="px-6 py-4">{{ $salary->bulan }}</td>
                        <td class="px-6 py-4">{{ number_format($salary->gaji_pokok, 0, ',', '.') }}</td>
                        <td class="px-6 py-4">{{ number_format($salary->tunjangan, 0, ',', '.') }}</td>
                        <td class="px-6 py-4">{{ number_format($salary->potongan, 0, ',', '.') }}</td>
                        <td class="px-6 py-4">{{ number_format($salary->total_gaji, 0, ',', '.') }}</td>
                        <td class="px-6 py-4">
                            @include('salaries.edit', ['salary' => $salary]) |
                            <form action="{{ route('salaries.destroy', $salary->id) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-black hover:underline dark:text-white"
                                    onclick="return confirm('Yakin ingin menghapus?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
