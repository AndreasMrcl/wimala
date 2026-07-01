<!DOCTYPE html>
<html lang="id">

<head>
    <title>Invoice & Pembayaran</title>
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

            @php
                $statusColor = [
                    'paid'   => 'bg-green-100 text-green-700 border-green-200',
                    'unpaid' => 'bg-blue-100 text-blue-700 border-blue-200',
                    'late'   => 'bg-red-100 text-red-700 border-red-200',
                ];
                $statusLabel = ['paid' => 'Lunas', 'unpaid' => 'Belum jatuh tempo', 'late' => 'Terlambat'];
            @endphp

            <!-- Header -->
            <div
                class="md:flex justify-between items-center bg-white p-5 rounded-xl shadow-sm border border-gray-100 space-y-2 md:space-y-0">
                <div>
                    <h1 class="font-bold text-2xl text-gray-800 flex items-center gap-2">
                        <i class="fas fa-file-invoice-dollar text-sky-600"></i> Invoice &amp; Pembayaran
                    </h1>
                    <p class="text-sm text-gray-500 mt-1">Penagihan termin dan pencatatan pembayaran masuk</p>
                </div>
                <x-button id="addBtn" size="lg" variant="primary" class="shadow-md" icon="plus">Buat Invoice</x-button>
            </div>

            <!-- KPI Summary -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-blue-600 uppercase font-semibold tracking-wide">Total Tertagih</p>
                            <h3 class="text-2xl font-bold text-blue-700 mt-2">Rp {{ number_format($totalTertagih, 0, ',', '.') }}</h3>
                            <p class="text-xs text-blue-600 mt-2">{{ $invoices->count() }} invoice</p>
                        </div>
                        <div class="text-4xl text-blue-300 opacity-50"><i class="fas fa-file-invoice"></i></div>
                    </div>
                </div>
                <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-green-600 uppercase font-semibold tracking-wide">Sudah Terbayar</p>
                            <h3 class="text-2xl font-bold text-green-700 mt-2">Rp {{ number_format($totalTerbayar, 0, ',', '.') }}</h3>
                            <p class="text-xs text-green-600 mt-2">
                                {{ $totalTertagih > 0 ? round($totalTerbayar / $totalTertagih * 100) : 0 }}% tertagih
                            </p>
                        </div>
                        <div class="text-4xl text-green-300 opacity-50"><i class="fas fa-circle-check"></i></div>
                    </div>
                </div>
                <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-amber-600 uppercase font-semibold tracking-wide">Belum Jatuh Tempo</p>
                            <h3 class="text-2xl font-bold text-amber-700 mt-2">Rp {{ number_format($belumJatuhTempo, 0, ',', '.') }}</h3>
                            <p class="text-xs text-amber-600 mt-2">sisa tagihan aktif</p>
                        </div>
                        <div class="text-4xl text-amber-300 opacity-50"><i class="fas fa-clock"></i></div>
                    </div>
                </div>
                <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-red-600 uppercase font-semibold tracking-wide">Terlambat</p>
                            <h3 class="text-2xl font-bold text-red-700 mt-2">Rp {{ number_format($terlambat, 0, ',', '.') }}</h3>
                            <p class="text-xs text-red-600 mt-2">lewat jatuh tempo</p>
                        </div>
                        <div class="text-4xl text-red-300 opacity-50"><i class="fas fa-triangle-exclamation"></i></div>
                    </div>
                </div>
            </div>

            <!-- Filter -->
            <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                <div class="flex flex-col md:flex-row md:items-end gap-3">
                    <div class="flex-1">
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Status</label>
                        <select id="filterStatus"
                            class="mt-1 w-full p-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-sky-500 outline-none">
                            <option value="">Semua Status</option>
                            <option value="unpaid">Belum jatuh tempo</option>
                            <option value="paid">Lunas</option>
                            <option value="late">Terlambat</option>
                        </select>
                    </div>
                    <div>
                        <x-button id="filterReset" variant="secondary" icon="rotate-left">Reset</x-button>
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="w-full bg-white rounded-xl shadow-md border border-gray-100">
                <div class="p-5 overflow-auto">
                    <table id="myTable" class="w-full text-left">
                        <thead class="bg-gray-100 text-gray-600 text-sm leading-normal">
                            <tr>
                                <th class="p-4 font-bold rounded-tl-lg text-center" width="5%">No</th>
                                <th class="p-4 font-bold">Invoice / Unit</th>
                                <th class="p-4 font-bold">Pembeli</th>
                                <th class="p-4 font-bold">Jenis Termin</th>
                                <th class="p-4 font-bold text-right">Jumlah</th>
                                <th class="p-4 font-bold text-center">Jatuh Tempo</th>
                                <th class="p-4 font-bold text-center">Status</th>
                                <th class="p-4 font-bold text-center rounded-tr-lg" width="12%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700 text-sm">
                            @php $no = 1; @endphp
                            @foreach ($invoices as $v)
                                @php $eff = $v->effectiveStatus(); @endphp
                                <tr class="hover:bg-gray-50 transition duration-150" data-status="{{ $eff }}">
                                    <td class="p-4 font-medium text-center">{{ $no++ }}</td>
                                    <td class="p-4">
                                        <a href="{{ route('invoices.show', $v) }}" class="font-bold text-gray-900 hover:text-sky-600">{{ $v->no_invoice }}</a>
                                        <div class="text-xs text-gray-400">Unit {{ $v->saleTransaction?->unit?->kode ?? '—' }}</div>
                                    </td>
                                    <td class="p-4 text-gray-700">{{ $v->saleTransaction?->buyer?->nama ?? '—' }}</td>
                                    <td class="p-4 text-gray-600">{{ $v->terminLabel() }}</td>
                                    <td class="p-4 text-right font-mono text-slate-600 whitespace-nowrap">
                                        Rp {{ number_format($v->jumlah, 0, ',', '.') }}
                                    </td>
                                    <td class="p-4 text-center">
                                        <span class="inline-flex items-center gap-1 text-xs text-gray-500 whitespace-nowrap">
                                            <i class="fas fa-calendar-day text-gray-400"></i> {{ $v->jatuh_tempo->translatedFormat('d M Y') }}
                                        </span>
                                    </td>
                                    <td class="p-4 text-center">
                                        <span class="{{ $statusColor[$eff] }} text-xs px-3 py-1 rounded-full font-bold border whitespace-nowrap">
                                            {{ $statusLabel[$eff] }}
                                        </span>
                                    </td>
                                    <td class="p-4">
                                        <div class="flex justify-center items-center gap-2">
                                            <a href="{{ route('invoices.show', $v) }}"
                                                class="w-10 h-10 flex items-center justify-center bg-sky-500 text-white rounded-lg shadow hover:bg-sky-600 hover:scale-105 transition"
                                                title="Lihat & Catat Pembayaran">
                                                <i class="fas fa-eye text-lg"></i>
                                            </a>
                                            <form method="post" action="{{ route('invoices.destroy', $v) }}" class="inline">
                                                @csrf @method('delete')
                                                <button type="button"
                                                    class="delete-confirm w-10 h-10 flex items-center justify-center bg-red-500 text-white rounded-lg shadow hover:bg-red-600 hover:scale-105 transition"
                                                    title="Hapus">
                                                    <i class="fas fa-trash text-lg"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <p class="text-xs text-gray-400">
                Sesuai kebutuhan klien, pembayaran dikonfirmasi manual dari bukti transfer — tanpa payment gateway.
            </p>

        </div>
    </main>

    <!-- SCRIPTS -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="//cdn.datatables.net/2.0.2/js/dataTables.min.js"></script>
    <script src="{{ asset('modal/invoice.js') }}"></script>

    @include('modal.invoiceAdd')

    @include('sweetalert::alert')
    @include('layout.loading')
</body>

</html>
