<!-- ADD TRANSACTION MODAL -->
<div id="addModal"
    class="hidden fixed inset-0 bg-gray-900/60 backdrop-blur-sm flex items-center justify-center z-50 overflow-y-auto px-4 py-6">
    <div class="bg-white rounded-2xl p-8 w-full max-w-xl shadow-2xl relative">
        <button id="closeAddModal" class="absolute top-5 right-5 text-gray-400 hover:text-gray-600 transition">
            <i class="fas fa-times text-xl"></i>
        </button>
        <h2 class="text-2xl font-bold mb-6 text-gray-800 flex items-center gap-2">
            <i class="fas fa-file-signature text-sky-600"></i> Transaksi Baru
        </h2>

        @if ($availableUnits->isEmpty())
            <p class="text-sm text-gray-500">Tidak ada unit yang tersedia untuk dijual saat ini.</p>
        @else
            <form action="{{ route('transactions.store') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Unit (tersedia)</label>
                    <select name="unit_id"
                        class="w-full rounded-lg border-gray-300 shadow-sm p-2.5 border focus:ring-2 focus:ring-sky-500"
                        required>
                        <option value="">— Pilih unit —</option>
                        @foreach ($availableUnits as $u)
                            <option value="{{ $u->id }}">{{ $u->kode }} — {{ $u->cluster?->nama }} ({{ $u->delivery_type === 'indent' ? 'Indent' : 'Ready stock' }})</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Pembeli</label>
                    <select name="buyer_id"
                        class="w-full rounded-lg border-gray-300 shadow-sm p-2.5 border focus:ring-2 focus:ring-sky-500"
                        required>
                        <option value="">— Pilih pembeli —</option>
                        @foreach ($buyers as $b)
                            <option value="{{ $b->id }}">{{ $b->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Cara Bayar</label>
                        <select name="payment_method" id="paymentMethod"
                            class="w-full rounded-lg border-gray-300 shadow-sm p-2.5 border focus:ring-2 focus:ring-sky-500"
                            required>
                            <option value="cash_keras">Cash keras</option>
                            <option value="cash_bertahap">Cash bertahap</option>
                            <option value="kpr">KPR</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Marketing (opsional)</label>
                        <select name="marketing_id"
                            class="w-full rounded-lg border-gray-300 shadow-sm p-2.5 border focus:ring-2 focus:ring-sky-500">
                            <option value="">— Tanpa marketing —</option>
                            @foreach ($marketings as $m)
                                <option value="{{ $m->id }}">{{ $m->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div id="bankField" class="hidden">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Bank (KPR)</label>
                    <select name="bank_id"
                        class="w-full rounded-lg border-gray-300 shadow-sm p-2.5 border focus:ring-2 focus:ring-sky-500">
                        <option value="">— Pilih bank —</option>
                        @foreach ($banks as $bank)
                            <option value="{{ $bank->id }}">{{ $bank->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <p class="text-xs text-gray-400">
                    Saat dibuat, unit langsung dikunci (BOOKED) dan 8 tahap diinstansiasi — tahap tak relevan otomatis dilewati.
                </p>

                <x-button type="submit" variant="primary" icon="save" class="w-full justify-center">Buat Transaksi</x-button>
            </form>
        @endif
    </div>
</div>
