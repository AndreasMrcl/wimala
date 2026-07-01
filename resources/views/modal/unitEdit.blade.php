<!-- EDIT MODAL -->
<div id="editModal"
    class="hidden fixed inset-0 bg-gray-900/60 backdrop-blur-sm flex items-center justify-center z-50 overflow-y-auto px-4 py-6">
    <div class="bg-white rounded-2xl p-8 w-full max-w-xl shadow-2xl relative">
        <button id="closeModal" class="absolute top-5 right-5 text-gray-400 hover:text-gray-600 transition">
            <i class="fas fa-times text-xl"></i>
        </button>
        <h2 class="text-2xl font-bold mb-6 text-gray-800 flex items-center gap-2">
            <i class="fas fa-pen-to-square text-blue-600"></i> Ubah Unit
        </h2>

        <form id="editForm" action="" method="POST" class="space-y-5">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Kode Unit</label>
                    <input type="text" name="kode" id="editKode"
                        class="w-full rounded-lg border-gray-300 shadow-sm p-2.5 border focus:ring-2 focus:ring-sky-500"
                        required>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Cluster</label>
                    <select name="cluster_id" id="editClusterId"
                        class="w-full rounded-lg border-gray-300 shadow-sm p-2.5 border focus:ring-2 focus:ring-sky-500"
                        required>
                        @foreach ($clusters as $c)
                            <option value="{{ $c->id }}">{{ $c->nama }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Tipe Rumah</label>
                <select name="house_type_id" id="editHouseTypeId"
                    class="w-full rounded-lg border-gray-300 shadow-sm p-2.5 border focus:ring-2 focus:ring-sky-500"
                    required>
                    @foreach ($houseTypes as $ht)
                        <option value="{{ $ht->id }}">{{ $ht->nama }} (LT {{ $ht->luas_tanah }} / LB {{ $ht->luas_bangunan }})</option>
                    @endforeach
                </select>
                <p class="text-xs text-gray-400 mt-1">Luas tanah & bangunan mengikuti tipe yang dipilih.</p>
            </div>

            <div class="grid grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Blok</label>
                    <input type="text" name="blok" id="editBlok"
                        class="w-full rounded-lg border-gray-300 shadow-sm p-2.5 border focus:ring-2 focus:ring-sky-500">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Nomor</label>
                    <input type="text" name="nomor" id="editNomor"
                        class="w-full rounded-lg border-gray-300 shadow-sm p-2.5 border focus:ring-2 focus:ring-sky-500">
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Harga (Rp)</label>
                <input type="text" name="harga" id="editHarga"
                    class="currency w-full rounded-lg border-gray-300 shadow-sm p-2.5 border focus:ring-2 focus:ring-sky-500">
            </div>

            <div class="grid grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Jenis Unit</label>
                    <select name="delivery_type" id="editDeliveryType"
                        class="w-full rounded-lg border-gray-300 shadow-sm p-2.5 border focus:ring-2 focus:ring-sky-500"
                        required>
                        <option value="ready_stock">Ready stock</option>
                        <option value="indent">Indent</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Status</label>
                    <select name="status" id="editStatus"
                        class="w-full rounded-lg border-gray-300 shadow-sm p-2.5 border focus:ring-2 focus:ring-sky-500"
                        required>
                        @foreach (\App\Models\Unit::STATUS_LABELS as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <x-button type="submit" variant="primary" icon="save"
                class="w-full justify-center bg-blue-600 hover:bg-blue-700">Perbarui</x-button>
        </form>
    </div>
</div>
