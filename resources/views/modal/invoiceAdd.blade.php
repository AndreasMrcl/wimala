<!-- ADD INVOICE MODAL -->
<div id="addModal"
    class="hidden fixed inset-0 bg-gray-900/60 backdrop-blur-sm flex items-center justify-center z-50 overflow-y-auto px-4 py-6">
    <div class="bg-white rounded-2xl p-8 w-full max-w-lg shadow-2xl relative">
        <button id="closeAddModal" class="absolute top-5 right-5 text-gray-400 hover:text-gray-600 transition">
            <i class="fas fa-times text-xl"></i>
        </button>
        <h2 class="text-2xl font-bold mb-6 text-gray-800 flex items-center gap-2">
            <i class="fas fa-file-invoice-dollar text-sky-600"></i> Buat Invoice
        </h2>

        @if ($transactions->isEmpty())
            <p class="text-sm text-gray-500">Belum ada transaksi aktif untuk ditagih.</p>
        @else
            <form action="{{ route('invoices.store') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Transaksi</label>
                    <select name="sale_transaction_id"
                        class="w-full rounded-lg border-gray-300 shadow-sm p-2.5 border focus:ring-2 focus:ring-sky-500"
                        required>
                        <option value="">— Pilih transaksi —</option>
                        @foreach ($transactions as $t)
                            <option value="{{ $t->id }}">{{ $t->unit?->kode }} — {{ $t->buyer?->nama }} ({{ $t->paymentLabel() }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Jenis Termin</label>
                        <select name="jenis_termin"
                            class="w-full rounded-lg border-gray-300 shadow-sm p-2.5 border focus:ring-2 focus:ring-sky-500"
                            required>
                            @foreach (\App\Models\Invoice::TERMIN_LABELS as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Jatuh Tempo</label>
                        <input type="date" name="jatuh_tempo" value="{{ now()->addDays(14)->format('Y-m-d') }}"
                            class="w-full rounded-lg border-gray-300 shadow-sm p-2.5 border focus:ring-2 focus:ring-sky-500"
                            required>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Jumlah (Rp)</label>
                    <input type="text" name="jumlah" value="0"
                        class="currency w-full rounded-lg border-gray-300 shadow-sm p-2.5 border focus:ring-2 focus:ring-sky-500"
                        placeholder="0">
                </div>

                <x-button type="submit" variant="primary" icon="save" class="w-full justify-center">Simpan</x-button>
            </form>
        @endif
    </div>
</div>
