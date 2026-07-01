<!DOCTYPE html>
<html lang="id">

<head>
    <title>Manajemen Unit</title>
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
                    'available'   => 'bg-green-100 text-green-700 border-green-200',
                    'booked'      => 'bg-blue-100 text-blue-700 border-blue-200',
                    'sold'        => 'bg-amber-100 text-amber-700 border-amber-200',
                    'handed_over' => 'bg-purple-100 text-purple-700 border-purple-200',
                    'completed'   => 'bg-gray-100 text-gray-700 border-gray-200',
                ];
            @endphp

            <!-- Header -->
            <div
                class="md:flex justify-between items-center bg-white p-5 rounded-xl shadow-sm border border-gray-100 space-y-2 md:space-y-0">
                <div>
                    <h1 class="font-bold text-2xl text-gray-800 flex items-center gap-2">
                        <i class="fas fa-house text-sky-600"></i> Manajemen Unit
                    </h1>
                    <p class="text-sm text-gray-500 mt-1">Kelola seluruh unit di semua cluster</p>
                </div>
                <x-button id="addBtn" size="lg" variant="primary" class="shadow-md" icon="plus">Tambah Unit</x-button>
            </div>

            <!-- Filters -->
            <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                <div class="flex flex-col md:flex-row md:items-end gap-3">
                    <div class="flex-1">
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Cluster</label>
                        <select id="filterCluster"
                            class="mt-1 w-full p-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-sky-500 outline-none">
                            <option value="">Semua Cluster</option>
                            @foreach ($clusters as $c)
                                <option value="{{ $c->id }}">{{ $c->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex-1">
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Status</label>
                        <select id="filterStatus"
                            class="mt-1 w-full p-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-sky-500 outline-none">
                            <option value="">Semua Status</option>
                            @foreach (\App\Models\Unit::STATUS_LABELS as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
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
                                <th class="p-4 font-bold">Unit / Cluster</th>
                                <th class="p-4 font-bold">Tipe / Luas</th>
                                <th class="p-4 font-bold text-right">Harga</th>
                                <th class="p-4 font-bold text-center">Jenis</th>
                                <th class="p-4 font-bold text-center">Status</th>
                                <th class="p-4 font-bold text-center rounded-tr-lg" width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700 text-sm">
                            @php $no = 1; @endphp
                            @foreach ($units as $u)
                                <tr class="hover:bg-gray-50 transition duration-150"
                                    data-cluster="{{ $u->cluster_id }}" data-status="{{ $u->status }}">
                                    <td class="p-4 font-medium text-center">{{ $no++ }}</td>
                                    <td class="p-4 space-y-1">
                                        <a href="{{ route('units.show', $u) }}" class="group block">
                                            <div class="font-bold text-gray-900 text-base group-hover:text-sky-600">
                                                {{ $u->kode }}
                                            </div>
                                            <div class="text-xs text-gray-500 flex items-center gap-1">
                                                <i class="fas fa-location-dot text-gray-400"></i> {{ $u->cluster?->nama }}
                                            </div>
                                            <div class="text-[11px] text-gray-400">Blok {{ $u->blok }} No. {{ $u->nomor }}</div>
                                        </a>
                                    </td>
                                    <td class="p-4">
                                        <div class="font-semibold text-gray-700">{{ $u->houseType?->nama }}</div>
                                        <div class="text-xs text-gray-400">LT {{ $u->luas_tanah }} / LB {{ $u->luas_bangunan }} m²</div>
                                    </td>
                                    <td class="p-4 text-right font-mono text-slate-600 whitespace-nowrap">
                                        Rp {{ number_format($u->harga, 0, ',', '.') }}
                                    </td>
                                    <td class="p-4 text-center">
                                        @if ($u->delivery_type === 'indent')
                                            <span class="bg-amber-100 text-amber-700 text-xs px-3 py-1 rounded-full font-bold border border-amber-200">Indent</span>
                                        @else
                                            <span class="bg-slate-100 text-slate-600 text-xs px-3 py-1 rounded-full font-bold border border-slate-200">Ready stock</span>
                                        @endif
                                    </td>
                                    <td class="p-4 text-center">
                                        <span class="{{ $statusColor[$u->status] ?? 'bg-gray-100 text-gray-600 border-gray-200' }} text-xs px-3 py-1 rounded-full font-bold border whitespace-nowrap">
                                            {{ \App\Models\Unit::STATUS_LABELS[$u->status] ?? $u->status }}
                                        </span>
                                    </td>
                                    <td class="p-4">
                                        <div class="flex justify-center items-center gap-2">
                                            <a href="{{ route('units.show', $u) }}"
                                                class="w-10 h-10 flex items-center justify-center bg-sky-500 text-white rounded-lg shadow hover:bg-sky-600 hover:scale-105 transition"
                                                title="Lihat Detail">
                                                <i class="fas fa-eye text-lg"></i>
                                            </a>
                                            <button
                                                class="editBtn w-10 h-10 flex items-center justify-center bg-blue-500 text-white rounded-lg shadow hover:bg-blue-600 hover:scale-105 transition"
                                                data-kode="{{ $u->kode }}" data-cluster_id="{{ $u->cluster_id }}"
                                                data-house_type_id="{{ $u->house_type_id }}" data-blok="{{ $u->blok }}"
                                                data-nomor="{{ $u->nomor }}" data-harga="{{ (int) $u->harga }}"
                                                data-delivery_type="{{ $u->delivery_type }}" data-status="{{ $u->status }}"
                                                title="Edit">
                                                <i class="fas fa-edit text-lg"></i>
                                            </button>
                                            <form method="post" action="{{ route('units.destroy', $u) }}" class="inline">
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
                Status unit dijaga sistem agar satu unit tidak mungkin terjual ke dua pembeli.
            </p>

        </div>
    </main>

    <!-- SCRIPTS -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="//cdn.datatables.net/2.0.2/js/dataTables.min.js"></script>
    <script src="{{ asset('modal/unit.js') }}"></script>

    @include('modal.unitAdd')
    @include('modal.unitEdit')

    @include('sweetalert::alert')
    @include('layout.loading')
</body>

</html>
