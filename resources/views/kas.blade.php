<!DOCTYPE html>
<html lang="id">

<head>
    <title>Pencatatan Kas</title>
    @include('layout.head')
    <link href="//cdn.datatables.net/2.0.2/css/dataTables.dataTables.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        .dataTables_wrapper .dataTables_length select {
            padding-right: 2rem;
            border-radius: 0.5rem;
        }

        .dataTables_wrapper .dataTables_filter input {
            padding: 0.5rem;
            border-radius: 0.5rem;
            border: 1px solid #d1d5db;
        }

        table.dataTable.no-footer {
            border-bottom: 1px solid #e5e7eb;
        }
    </style>
</head>

<body class="bg-gray-50 font-sans">
    @include('layout.sidebar')

    <main class="md:ml-64 xl:ml-72 2xl:ml-72">
        @include('layout.navbar')
        <div class="p-6 space-y-6">

            <!-- Header -->
            <div
                class="md:flex justify-between items-center bg-white p-5 rounded-xl shadow-sm border border-gray-100 space-y-2 md:space-y-0">
                <div>
                    <h1 class="font-bold text-2xl text-gray-800 flex items-center gap-2">
                        <i class="fas fa-wallet text-sky-600"></i> Pencatatan Kas
                    </h1>
                    <p class="text-sm text-gray-500 mt-1">Kas masuk/keluar (cash basis) dan rekap saldo per periode</p>
                </div>
                <x-button id="addBtn" size="lg" variant="primary" class="shadow-md" icon="plus">Tambah Catatan</x-button>
            </div>

            <!-- KPI -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-sky-600 uppercase font-semibold tracking-wide">Saldo Kas</p>
                            <h3 class="text-2xl font-bold text-sky-700 mt-2">Rp {{ number_format($saldo, 0, ',', '.') }}</h3>
                            <p class="text-xs text-sky-600 mt-2">{{ $bulan ? 's/d akhir periode' : 'saldo terkini' }}</p>
                        </div>
                        <div class="text-4xl text-sky-300 opacity-50"><i class="fas fa-wallet"></i></div>
                    </div>
                </div>
                <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-green-600 uppercase font-semibold tracking-wide">Kas Masuk</p>
                            <h3 class="text-2xl font-bold text-green-700 mt-2">Rp {{ number_format($masuk, 0, ',', '.') }}</h3>
                            <p class="text-xs text-green-600 mt-2">periode terpilih</p>
                        </div>
                        <div class="text-4xl text-green-300 opacity-50"><i class="fas fa-arrow-down"></i></div>
                    </div>
                </div>
                <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-red-600 uppercase font-semibold tracking-wide">Kas Keluar</p>
                            <h3 class="text-2xl font-bold text-red-700 mt-2">Rp {{ number_format($keluar, 0, ',', '.') }}</h3>
                            <p class="text-xs text-red-600 mt-2">periode terpilih</p>
                        </div>
                        <div class="text-4xl text-red-300 opacity-50"><i class="fas fa-arrow-up"></i></div>
                    </div>
                </div>
                <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-gray-500 uppercase font-semibold tracking-wide">Arus Bersih</p>
                            <h3 class="text-2xl font-bold {{ $masuk - $keluar >= 0 ? 'text-gray-800' : 'text-red-700' }} mt-2">
                                Rp {{ number_format($masuk - $keluar, 0, ',', '.') }}
                            </h3>
                            <p class="text-xs text-gray-400 mt-2">masuk − keluar (periode)</p>
                        </div>
                        <div class="text-4xl text-gray-300 opacity-50"><i class="fas fa-scale-balanced"></i></div>
                    </div>
                </div>
            </div>

            <!-- Period filter -->
            <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                <form method="GET" class="flex flex-col md:flex-row md:items-end gap-3">
                    <div class="flex-1">
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Periode</label>
                        <select name="bulan" onchange="this.form.submit()"
                            class="mt-1 w-full p-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-sky-500 outline-none">
                            <option value="">Semua periode</option>
                            @foreach ($months as $m)
                                <option value="{{ $m }}" @selected($bulan === $m)>
                                    {{ \Carbon\Carbon::createFromFormat('Y-m', $m)->translatedFormat('F Y') }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex-1">
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Tipe</label>
                        <select id="filterTipe"
                            class="mt-1 w-full p-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-sky-500 outline-none">
                            <option value="">Semua</option>
                            <option value="in">Kas Masuk</option>
                            <option value="out">Kas Keluar</option>
                        </select>
                    </div>
                </form>
            </div>

            <!-- Table -->
            <div class="w-full bg-white rounded-xl shadow-md border border-gray-100">
                <div class="p-5 overflow-auto">
                    <table id="myTable" class="w-full text-left">
                        <thead class="bg-gray-100 text-gray-600 text-sm leading-normal">
                            <tr>
                                <th class="p-4 font-bold rounded-tl-lg text-center" width="5%">No</th>
                                <th class="p-4 font-bold">Tanggal</th>
                                <th class="p-4 font-bold text-center">Tipe</th>
                                <th class="p-4 font-bold">Kategori</th>
                                <th class="p-4 font-bold">Keterangan</th>
                                <th class="p-4 font-bold text-center">Sumber</th>
                                <th class="p-4 font-bold text-right">Jumlah</th>
                                <th class="p-4 font-bold text-center rounded-tr-lg" width="8%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700 text-sm">
                            @php $no = 1; @endphp
                            @foreach ($entries as $e)
                                <tr class="hover:bg-gray-50 transition duration-150" data-tipe="{{ $e->tipe }}">
                                    <td class="p-4 font-medium text-center">{{ $no++ }}</td>
                                    <td class="p-4 whitespace-nowrap">{{ $e->tanggal->translatedFormat('d M Y') }}</td>
                                    <td class="p-4 text-center">
                                        @if ($e->tipe === 'in')
                                            <span class="bg-green-100 text-green-700 text-xs px-3 py-1 rounded-full font-bold border border-green-200">Masuk</span>
                                        @else
                                            <span class="bg-red-100 text-red-700 text-xs px-3 py-1 rounded-full font-bold border border-red-200">Keluar</span>
                                        @endif
                                    </td>
                                    <td class="p-4 text-gray-700">{{ $e->kategori }}</td>
                                    <td class="p-4 text-xs text-gray-500">{{ $e->keterangan ?: '—' }}</td>
                                    <td class="p-4 text-center">
                                        @if ($e->isAuto())
                                            <span class="text-[11px] bg-gray-100 text-gray-500 px-2 py-0.5 rounded border border-gray-200">Otomatis</span>
                                        @else
                                            <span class="text-[11px] bg-sky-50 text-sky-600 px-2 py-0.5 rounded border border-sky-100">Manual</span>
                                        @endif
                                    </td>
                                    <td class="p-4 text-right font-mono whitespace-nowrap {{ $e->tipe === 'in' ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $e->tipe === 'in' ? '+' : '−' }}Rp {{ number_format($e->jumlah, 0, ',', '.') }}
                                    </td>
                                    <td class="p-4">
                                        <div class="flex justify-center">
                                            @if ($e->isAuto())
                                                <span class="w-8 h-8 inline-flex items-center justify-center text-gray-300" title="Otomatis dari pembayaran">
                                                    <i class="fas fa-lock text-sm"></i>
                                                </span>
                                            @else
                                                <form method="post" action="{{ route('kas.destroy', $e) }}" class="inline">
                                                    @csrf @method('delete')
                                                    <button type="button"
                                                        class="delete-confirm w-8 h-8 inline-flex items-center justify-center bg-red-500 text-white rounded-lg hover:bg-red-600 transition"
                                                        title="Hapus">
                                                        <i class="fas fa-trash text-sm"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <p class="text-xs text-gray-400">
                Kas masuk dibuat otomatis dari pembayaran terkonfirmasi. Sesuai prinsip cash basis, dana sebelum serah
                terima (BAST) secara akuntansi adalah uang muka — laporan keuangan akrual menyusul (fase lanjutan).
            </p>

        </div>
    </main>

    <!-- SCRIPTS -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="//cdn.datatables.net/2.0.2/js/dataTables.min.js"></script>
    <script src="{{ asset('modal/kas.js') }}"></script>

    @include('modal.kasAdd')

    @include('sweetalert::alert')
    @include('layout.loading')
</body>

</html>
