<!-- EDIT MODAL -->
<div id="editModal"
    class="hidden fixed inset-0 bg-gray-900/60 backdrop-blur-sm flex items-center justify-center z-50 overflow-y-auto px-4 py-6">
    <div class="bg-white rounded-2xl p-8 w-full max-w-lg shadow-2xl relative">
        <button id="closeModal" class="absolute top-5 right-5 text-gray-400 hover:text-gray-600 transition">
            <i class="fas fa-times text-xl"></i>
        </button>
        <h2 class="text-2xl font-bold mb-6 text-gray-800 flex items-center gap-2">
            <i class="fas fa-pen-to-square text-blue-600"></i> Ubah Tipe Rumah
        </h2>

        <form id="editForm" action="" method="POST" class="space-y-5">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Tipe</label>
                <input type="text" name="nama" id="editNama"
                    class="w-full rounded-lg border-gray-300 shadow-sm p-2.5 border focus:ring-2 focus:ring-sky-500"
                    required>
            </div>

            <div class="grid grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Luas Tanah (m²)</label>
                    <input type="number" name="luas_tanah" id="editLuasTanah" min="0"
                        class="w-full rounded-lg border-gray-300 shadow-sm p-2.5 border focus:ring-2 focus:ring-sky-500"
                        required>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Luas Bangunan (m²)</label>
                    <input type="number" name="luas_bangunan" id="editLuasBangunan" min="0"
                        class="w-full rounded-lg border-gray-300 shadow-sm p-2.5 border focus:ring-2 focus:ring-sky-500"
                        required>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Kamar Tidur</label>
                    <input type="number" name="kamar_tidur" id="editKamarTidur" min="0"
                        class="w-full rounded-lg border-gray-300 shadow-sm p-2.5 border focus:ring-2 focus:ring-sky-500"
                        required>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Kamar Mandi</label>
                    <input type="number" name="kamar_mandi" id="editKamarMandi" min="0"
                        class="w-full rounded-lg border-gray-300 shadow-sm p-2.5 border focus:ring-2 focus:ring-sky-500"
                        required>
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Harga Dasar (Rp)</label>
                <input type="text" name="harga_dasar" id="editHargaDasar" value="0"
                    class="currency w-full rounded-lg border-gray-300 shadow-sm p-2.5 border focus:ring-2 focus:ring-sky-500"
                    placeholder="0">
            </div>

            <x-button type="submit" variant="primary" icon="save"
                class="w-full justify-center bg-blue-600 hover:bg-blue-700">Perbarui</x-button>
        </form>
    </div>
</div>
