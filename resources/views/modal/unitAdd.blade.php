<!-- ADD MODAL -->
<div id="addModal"
    class="hidden fixed inset-0 bg-gray-900/60 backdrop-blur-sm flex items-center justify-center z-50 overflow-y-auto px-4 py-6">
    <div class="bg-white rounded-2xl p-8 w-full max-w-xl shadow-2xl relative">
        <button id="closeAddModal" class="absolute top-5 right-5 text-gray-400 hover:text-gray-600 transition">
            <i class="fas fa-times text-xl"></i>
        </button>
        <h2 class="text-2xl font-bold mb-6 text-gray-800 flex items-center gap-2">
            <i class="fas fa-house text-sky-600"></i> Tambah Unit
        </h2>

        <form action="{{ route('units.store') }}" method="POST" class="space-y-5">
            @csrf
            <div class="grid grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Kode Unit</label>
                    <input type="text" name="kode"
                        class="w-full rounded-lg border-gray-300 shadow-sm p-2.5 border focus:ring-2 focus:ring-sky-500"
                        required placeholder="mis. A-12">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Cluster</label>
                    <select name="cluster_id"
                        class="w-full rounded-lg border-gray-300 shadow-sm p-2.5 border focus:ring-2 focus:ring-sky-500"
                        required>
                        <option value="">— Pilih cluster —</option>
                        @foreach ($clusters as $c)
                            <option value="{{ $c->id }}">{{ $c->nama }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Tipe Rumah</label>
                <select name="house_type_id"
                    class="w-full rounded-lg border-gray-300 shadow-sm p-2.5 border focus:ring-2 focus:ring-sky-500"
                    required>
                    <option value="">— Pilih tipe —</option>
                    @foreach ($houseTypes as $ht)
                        <option value="{{ $ht->id }}">{{ $ht->nama }} (LT {{ $ht->luas_tanah }} / LB {{ $ht->luas_bangunan }})</option>
                    @endforeach
                </select>
                <p class="text-xs text-gray-400 mt-1">Luas tanah & bangunan mengikuti tipe yang dipilih.</p>
            </div>

            <div class="grid grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Blok</label>
                    <input type="text" name="blok"
                        class="w-full rounded-lg border-gray-300 shadow-sm p-2.5 border focus:ring-2 focus:ring-sky-500"
                        placeholder="mis. A">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Nomor</label>
                    <input type="text" name="nomor"
                        class="w-full rounded-lg border-gray-300 shadow-sm p-2.5 border focus:ring-2 focus:ring-sky-500"
                        placeholder="mis. 12">
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Harga (Rp)</label>
                <input type="text" name="harga" value="0"
                    class="currency w-full rounded-lg border-gray-300 shadow-sm p-2.5 border focus:ring-2 focus:ring-sky-500"
                    placeholder="0">
            </div>

            <div class="grid grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Jenis Unit</label>
                    <select name="delivery_type"
                        class="w-full rounded-lg border-gray-300 shadow-sm p-2.5 border focus:ring-2 focus:ring-sky-500"
                        required>
                        <option value="ready_stock">Ready stock</option>
                        <option value="indent">Indent</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Status</label>
                    <select name="status"
                        class="w-full rounded-lg border-gray-300 shadow-sm p-2.5 border focus:ring-2 focus:ring-sky-500"
                        required>
                        @foreach (\App\Models\Unit::STATUS_LABELS as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <x-button type="submit" variant="primary" icon="save"
                class="w-full justify-center">Simpan</x-button>
        </form>
    </div>
</div>
