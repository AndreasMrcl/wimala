<!DOCTYPE html>
<html lang="id">

<head>
    <title>Tipe Rumah</title>
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
                        <i class="fas fa-house-chimney text-sky-600"></i> Tipe Rumah
                    </h1>
                    <p class="text-sm text-gray-500 mt-1">Kelola tipe dan spesifikasi rumah</p>
                </div>
                <x-button id="addBtn" size="lg" variant="primary" class="shadow-md" icon="plus">Tambah Tipe</x-button>
            </div>

            <!-- Table -->
            <div class="w-full bg-white rounded-xl shadow-md border border-gray-100">
                <div class="p-5 overflow-auto">
                    <table id="myTable" class="w-full text-left">
                        <thead class="bg-gray-100 text-gray-600 text-sm leading-normal">
                            <tr>
                                <th class="p-4 font-bold rounded-tl-lg text-center" width="5%">No</th>
                                <th class="p-4 font-bold">Nama Tipe</th>
                                <th class="p-4 font-bold text-center">Luas Tanah</th>
                                <th class="p-4 font-bold text-center">Luas Bangunan</th>
                                <th class="p-4 font-bold text-center">Kamar</th>
                                <th class="p-4 font-bold text-right">Harga Dasar</th>
                                <th class="p-4 font-bold text-center rounded-tr-lg" width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700 text-sm">
                            @php $no = 1; @endphp
                            @foreach ($tipe as $t)
                                <tr class="hover:bg-gray-50 transition duration-150">
                                    <td class="p-4 font-medium text-center">{{ $no++ }}</td>
                                    <td class="p-4">
                                        <div class="font-bold text-gray-900 text-base flex items-center gap-2">
                                            <i class="fas fa-house text-gray-300"></i> {{ $t->nama }}
                                        </div>
                                    </td>
                                    <td class="p-4 text-center text-gray-600">{{ $t->luas_tanah }} m²</td>
                                    <td class="p-4 text-center text-gray-600">{{ $t->luas_bangunan }} m²</td>
                                    <td class="p-4 text-center">
                                        <span class="inline-flex items-center gap-1 text-xs text-gray-500">
                                            <i class="fas fa-bed text-gray-400"></i> {{ $t->kamar_tidur }}
                                            <span class="text-gray-300 mx-1">·</span>
                                            <i class="fas fa-bath text-gray-400"></i> {{ $t->kamar_mandi }}
                                        </span>
                                    </td>
                                    <td class="p-4 text-right font-mono text-slate-600 whitespace-nowrap">
                                        Rp {{ number_format($t->harga_dasar, 0, ',', '.') }}
                                    </td>
                                    <td class="p-4">
                                        <div class="flex justify-center items-center gap-2">
                                            <button
                                                class="editBtn w-10 h-10 flex items-center justify-center bg-blue-500 text-white rounded-lg shadow hover:bg-blue-600 hover:scale-105 transition"
                                                data-id="{{ $t->id }}" data-nama="{{ $t->nama }}"
                                                data-luas_tanah="{{ $t->luas_tanah }}" data-luas_bangunan="{{ $t->luas_bangunan }}"
                                                data-kamar_tidur="{{ $t->kamar_tidur }}" data-kamar_mandi="{{ $t->kamar_mandi }}"
                                                data-harga_dasar="{{ (int) $t->harga_dasar }}" title="Edit">
                                                <i class="fas fa-edit text-lg"></i>
                                            </button>

                                            <form method="post" action="{{ route('tipe.destroy', $t->id) }}" class="inline">
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

        </div>
    </main>

    <!-- SCRIPTS -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="//cdn.datatables.net/2.0.2/js/dataTables.min.js"></script>
    <script src="{{ asset('modal/tipe.js') }}"></script>

    @include('modal.tipeAdd')
    @include('modal.tipeEdit')

    @include('sweetalert::alert')
    @include('layout.loading')
</body>

</html>
