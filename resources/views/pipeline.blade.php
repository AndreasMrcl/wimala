<!DOCTYPE html>
<html lang="id">

<head>
    <title>Tracking Penjualan</title>
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

        .stage-chip.active {
            background-color: #0284c7;
            border-color: #0284c7;
            color: #fff;
        }

        .stage-chip.active .chip-count {
            background-color: rgba(255, 255, 255, .25);
            color: #fff;
        }
    </style>
</head>

@php
    $dotClass = [
        'done'    => 'bg-green-500',
        'active'  => 'bg-sky-500 ring-2 ring-sky-200',
        'pending' => 'bg-gray-200',
        'skip'    => 'bg-white border border-dashed border-gray-300',
    ];
    $stateText = ['done' => 'Selesai', 'active' => 'Sedang berjalan', 'pending' => 'Menunggu', 'skip' => 'Dilewati'];
@endphp

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
                        <i class="fas fa-diagram-project text-sky-600"></i> Tracking Penjualan
                    </h1>
                    <p class="text-sm text-gray-500 mt-1">Setiap baris adalah satu transaksi yang bergerak menuruni 8 tahap</p>
                </div>
                <x-button id="addBtn" size="lg" variant="primary" class="shadow-md" icon="plus">Transaksi Baru</x-button>
            </div>

            <!-- Stage summary (clickable filter) -->
            <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                <div class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-3">
                    Ringkasan Tahap — klik untuk menyaring
                </div>
                <div class="flex flex-wrap gap-2">
                    <button
                        class="stage-chip active flex items-center gap-2 px-3 py-1.5 rounded-lg border border-gray-200 text-sm text-gray-600 hover:border-sky-300 transition"
                        data-stage="">
                        Semua
                        <span class="chip-count bg-gray-100 text-gray-600 text-xs font-bold px-2 py-0.5 rounded-full">{{ count($deals) }}</span>
                    </button>
                    @foreach ($stages as $i => $st)
                        <button
                            class="stage-chip flex items-center gap-2 px-3 py-1.5 rounded-lg border border-gray-200 text-sm text-gray-600 hover:border-sky-300 transition"
                            data-stage="{{ $i }}">
                            <span class="font-semibold">{{ $i + 1 }}.</span> {{ $st['t'] }}
                            @if ($st['tag'] === 'kpr')
                                <span class="text-[10px] bg-sky-100 text-sky-600 px-1.5 rounded">KPR</span>
                            @elseif ($st['tag'] === 'indent')
                                <span class="text-[10px] bg-emerald-100 text-emerald-600 px-1.5 rounded">indent</span>
                            @endif
                            <span class="chip-count bg-gray-100 text-gray-600 text-xs font-bold px-2 py-0.5 rounded-full">{{ $counts[$i] }}</span>
                        </button>
                    @endforeach
                </div>

                <!-- Legend -->
                <div class="flex flex-wrap items-center gap-4 mt-4 pt-3 border-t border-gray-100 text-xs text-gray-500">
                    <span class="font-semibold text-gray-400 uppercase">Progres:</span>
                    <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-green-500"></span> Selesai</span>
                    <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-sky-500 ring-2 ring-sky-200"></span> Berjalan</span>
                    <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-gray-200"></span> Menunggu</span>
                    <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-white border border-dashed border-gray-300"></span> Dilewati</span>
                </div>
            </div>

            <!-- Table -->
            <div class="w-full bg-white rounded-xl shadow-md border border-gray-100">
                <div class="p-5 overflow-auto">
                    <table id="myTable" class="w-full text-left">
                        <thead class="bg-gray-100 text-gray-600 text-sm leading-normal">
                            <tr>
                                <th class="p-4 font-bold rounded-tl-lg text-center" width="5%">No</th>
                                <th class="p-4 font-bold">Pembeli</th>
                                <th class="p-4 font-bold">Unit</th>
                                <th class="p-4 font-bold text-center">Cara Bayar</th>
                                <th class="p-4 font-bold">Tahap Saat Ini</th>
                                <th class="p-4 font-bold text-center">Progres 8 Tahap</th>
                                <th class="p-4 font-bold text-center rounded-tr-lg" width="8%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700 text-sm">
                            @php $no = 1; @endphp
                            @foreach ($deals as $d)
                                <tr class="hover:bg-gray-50 transition duration-150"
                                    data-stage="{{ $d['stage'] }}" data-pay="{{ $d['pay'] }}">
                                    <td class="p-4 font-medium text-center">{{ $no++ }}</td>
                                    <td class="p-4">
                                        <a href="{{ route('transactions.show', $d['id']) }}"
                                            class="font-bold text-gray-900 hover:text-sky-600">{{ $d['name'] }}</a>
                                    </td>
                                    <td class="p-4 text-gray-600">{{ $d['code'] }}</td>
                                    <td class="p-4 text-center whitespace-nowrap">
                                        @if ($d['pay'] === 'KPR')
                                            <span class="bg-sky-100 text-sky-700 text-xs px-3 py-1 rounded-full font-bold border border-sky-200">KPR</span>
                                        @else
                                            <span class="bg-emerald-100 text-emerald-700 text-xs px-3 py-1 rounded-full font-bold border border-emerald-200">Cash</span>
                                        @endif
                                        @if ($d['indent'])
                                            <span class="inline-block w-2 h-2 rounded-full bg-emerald-500 align-middle ml-1" title="Unit indent"></span>
                                        @endif
                                    </td>
                                    <td class="p-4">
                                        <span class="font-semibold text-gray-700">{{ $d['stage'] + 1 }}.</span>
                                        <span class="text-gray-600">{{ $stages[$d['stage']]['t'] }}</span>
                                    </td>
                                    <td class="p-4">
                                        <div class="flex items-center justify-center">
                                            @foreach ($d['states'] as $st)
                                                <span class="w-3 h-3 rounded-full shrink-0 {{ $dotClass[$st['state']] }}"
                                                    title="{{ $st['no'] }}. {{ $st['label'] }} — {{ $stateText[$st['state']] }}"></span>
                                                @if (! $loop->last)
                                                    <span class="h-0.5 w-3 sm:w-4 shrink-0 {{ $st['state'] === 'done' ? 'bg-green-300' : 'bg-gray-200' }}"></span>
                                                @endif
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="p-4">
                                        <div class="flex justify-center">
                                            <a href="{{ route('transactions.show', $d['id']) }}"
                                                class="w-10 h-10 flex items-center justify-center bg-sky-500 text-white rounded-lg shadow hover:bg-sky-600 hover:scale-105 transition"
                                                title="Lihat Detail">
                                                <i class="fas fa-eye text-lg"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <p class="text-xs text-gray-400">
                Tahap "Pengajuan KPR" otomatis dilewati untuk pembeli cash, dan "Konstruksi" dilewati untuk unit ready
                stock — satu pipeline melayani semua jenis transaksi.
            </p>

        </div>
    </main>

    <!-- SCRIPTS -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="//cdn.datatables.net/2.0.2/js/dataTables.min.js"></script>
    <script src="{{ asset('modal/pipeline.js') }}"></script>

    @include('modal.transactionAdd')

    @include('sweetalert::alert')
    @include('layout.loading')
</body>

</html>
