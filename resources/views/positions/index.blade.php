@extends('master')
@section('title', 'Daftar Jabatan')
@section('Page-title', 'Daftar Jabatan')
@section('content')
    @include('positions.create')
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Daftar Jabatan
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Gaji Pokok
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($positions as $position)
                    <tr
                        class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $position->nama_jabatan }}</td>
                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            Rp. {{ number_format($position->gaji_pokok, 2, ',', '.') }}</td>
                        <td class="px-6 py-4">
                            @include('positions.show', ['position' => $position]) |
                            @include('positions.edit', ['position' => $position]) |
                            <form action="{{ route('positions.destroy', $position->id) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-black hover:underline dark:text-white" onclick="return confirm('Yakin ingin menghapus?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
