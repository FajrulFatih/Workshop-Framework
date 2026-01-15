<!-- Modal toggle -->
<button data-modal-target="authentication-modal" data-modal-toggle="authentication-modal"
    class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
    type="button">
    Add Salaries
</button>

<!-- Main modal -->
<div id="authentication-modal" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%)] max-h-full bg-black/50">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
            <!-- Modal header -->
            <div
                class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Form Add Salaries
                </h3>
                <button type="button"
                    class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-hide="authentication-modal">
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
                <form class="space-y-4" action="{{ route('salaries.store') }}" method="POST">
                    @csrf
                    <div>
                        <label for="karyawan_id"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Pegawai</label>
                        <select name="karyawan_id" id="karyawan_id"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                            required>
                            <option value="">Pilih Pegawai</option>
                            @foreach ($employees as $karyawan)
                                <option value="{{ $karyawan->id }}">{{ $karyawan->nama_lengkap }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="bulan" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Bulan Gaji
                        </label>
                        <input type="month" name="bulan" id="bulan"
                            value="{{ old('bulan', now()->format('Y-m')) }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                            required>
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Format: YYYY-MM (contoh: 2025-12)</p>
                    </div>

                    <div class="grid grid-cols-1 gap-3 mt-3">
                        <div>
                            <label for="tunjangan"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tunjangan</label>
                            <input type="number" name="tunjangan" id="tunjangan" value="0" min="0"
                                step="1"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" />
                        </div>
                        <div>
                            <label for="potongan"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Potongan</label>
                            <input type="number" name="potongan" id="potongan" value="0" min="0"
                                step="1"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" />
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Add</button>

                    <input type="hidden" name="total_gaji" id="total_gaji" value="0" />
                </form>
            </div>
        </div>
    </div>
</div>
<!--
<script>
    (function() {
        // Elements
        const karyawanSelect = document.getElementById('karyawan_id');
        const gajiDisplay = document.getElementById('gaji_pokok_display');
        const tunjangan = document.getElementById('tunjangan');
        const potongan = document.getElementById('potongan');
        const totalDisplay = document.getElementById('total_gaji_display');
        const totalHidden = document.getElementById('total_gaji');

        function toNumber(v) {
            if (v === null || v === undefined || v === '') return 0;
            // accept numbers or formatted strings
            const n = Number(String(v).replace(/[^0-9.-]+/g, ''));
            return isNaN(n) ? 0 : n;
        }

        function formatID(n) {
            try {
                return Number(n).toLocaleString('id-ID');
            } catch (e) {
                return n;
            }
        }

        function updateTotals() {
            const selected = karyawanSelect && karyawanSelect.options[karyawanSelect.selectedIndex];
            const gaji = toNumber(selected ? selected.dataset.gaji : 0);
            const tun = toNumber(tunjangan ? tunjangan.value : 0);
            const pot = toNumber(potongan ? potongan.value : 0);
            const total = gaji + tun - pot;

            if (gajiDisplay) gajiDisplay.value = formatID(gaji);
            if (totalDisplay) totalDisplay.value = formatID(total);
            if (totalHidden) totalHidden.value = total;
        }

        // Attach listeners defensively
        if (karyawanSelect) karyawanSelect.addEventListener('change', updateTotals);
        if (tunjangan) tunjangan.addEventListener('input', updateTotals);
        if (potongan) potongan.addEventListener('input', updateTotals);

        // Initialize when modal is shown or on DOM ready
        document.addEventListener('DOMContentLoaded', function() {
            updateTotals();
        });

        // If modal toggle buttons are used, refresh shortly after click
        document.addEventListener('click', function(e) {
            const target = e.target;
            if (!target) return;
            if (target.dataset && (target.dataset.modalToggle !== undefined || target.dataset
                    .modalTarget !== undefined)) {
                setTimeout(updateTotals, 80);
            }
        });
    })();
</script>
-->
