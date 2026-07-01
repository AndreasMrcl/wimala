<!-- ADD CASH ENTRY MODAL -->
<div id="addModal"
    class="hidden fixed inset-0 bg-gray-900/60 backdrop-blur-sm flex items-center justify-center z-50 overflow-y-auto px-4 py-6">
    <div class="bg-white rounded-2xl p-8 w-full max-w-lg shadow-2xl relative">
        <button id="closeAddModal" class="absolute top-5 right-5 text-gray-400 hover:text-gray-600 transition">
            <i class="fas fa-times text-xl"></i>
        </button>
        <h2 class="text-2xl font-bold mb-6 text-gray-800 flex items-center gap-2">
            <i class="fas fa-wallet text-sky-600"></i> Tambah Catatan Kas
        </h2>

        <form action="{{ route('kas.store') }}" method="POST" class="space-y-5">
            @csrf
            <div class="grid grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Tipe</label>
                    <select name="tipe"
                        class="w-full rounded-lg border-gray-300 shadow-sm p-2.5 border focus:ring-2 focus:ring-sky-500"
                        required>
                        <option value="out">Kas Keluar</option>
                        <option value="in">Kas Masuk</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Tanggal</label>
                    <input type="date" name="tanggal" value="{{ now()->format('Y-m-d') }}"
                        class="w-full rounded-lg border-gray-300 shadow-sm p-2.5 border focus:ring-2 focus:ring-sky-500" required>
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Kategori</label>
                <input type="text" name="kategori" list="kasKategori"
                    class="w-full rounded-lg border-gray-300 shadow-sm p-2.5 border focus:ring-2 focus:ring-sky-500"
                    required placeholder="mis. Operasional">
                <datalist id="kasKategori">
                    @foreach (\App\Models\CashEntry::KATEGORI_OUT as $label)
                        <option value="{{ $label }}"></option>
                    @endforeach
                    <option value="Pembayaran Unit"></option>
                    <option value="Pendapatan Lain"></option>
                </datalist>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Jumlah (Rp)</label>
                <input type="text" name="jumlah" value="0"
                    class="currency w-full rounded-lg border-gray-300 shadow-sm p-2.5 border focus:ring-2 focus:ring-sky-500"
                    placeholder="0">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Keterangan (opsional)</label>
                <input type="text" name="keterangan"
                    class="w-full rounded-lg border-gray-300 shadow-sm p-2.5 border focus:ring-2 focus:ring-sky-500">
            </div>

            <x-button type="submit" variant="primary" icon="save" class="w-full justify-center">Simpan</x-button>
        </form>
    </div>
</div>
