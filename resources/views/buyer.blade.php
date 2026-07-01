<!DOCTYPE html>
<html lang="id">

<head>
    <title>Data Pembeli</title>
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
                        <i class="fas fa-users text-sky-600"></i> Data Pembeli
                    </h1>
                    <p class="text-sm text-gray-500 mt-1">Kelola data calon dan pembeli unit</p>
                </div>
                <x-button id="addBtn" size="lg" variant="primary" class="shadow-md" icon="plus">Tambah Pembeli</x-button>
            </div>

            <!-- Table -->
            <div class="w-full bg-white rounded-xl shadow-md border border-gray-100">
                <div class="p-5 overflow-auto">
                    <table id="myTable" class="w-full text-left">
                        <thead class="bg-gray-100 text-gray-600 text-sm leading-normal">
                            <tr>
                                <th class="p-4 font-bold rounded-tl-lg text-center" width="5%">No</th>
                                <th class="p-4 font-bold">Nama</th>
                                <th class="p-4 font-bold">KTP / NPWP</th>
                                <th class="p-4 font-bold">Kontak</th>
                                <th class="p-4 font-bold">Alamat</th>
                                <th class="p-4 font-bold text-center rounded-tr-lg" width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700 text-sm">
                            @php $no = 1; @endphp
                            @foreach ($buyers as $b)
                                <tr class="hover:bg-gray-50 transition duration-150">
                                    <td class="p-4 font-medium text-center">{{ $no++ }}</td>
                                    <td class="p-4">
                                        <div class="font-bold text-gray-900">{{ $b->nama }}</div>
                                    </td>
                                    <td class="p-4 text-xs space-y-1">
                                        <div class="flex items-center gap-2"><i class="fas fa-id-card text-gray-400 w-4"></i> {{ $b->ktp ?: '—' }}</div>
                                        <div class="flex items-center gap-2"><i class="fas fa-receipt text-gray-400 w-4"></i> {{ $b->npwp ?: '—' }}</div>
                                    </td>
                                    <td class="p-4 text-xs space-y-1">
                                        <div class="flex items-center gap-2"><i class="fas fa-phone text-gray-400 w-4"></i> {{ $b->telepon ?: '—' }}</div>
                                        <div class="flex items-center gap-2"><i class="fas fa-envelope text-gray-400 w-4"></i> {{ $b->email ?: '—' }}</div>
                                    </td>
                                    <td class="p-4 text-xs text-gray-500">{{ \Illuminate\Support\Str::limit($b->alamat, 40) ?: '—' }}</td>
                                    <td class="p-4">
                                        <div class="flex justify-center items-center gap-2">
                                            <button
                                                class="editBtn w-10 h-10 flex items-center justify-center bg-blue-500 text-white rounded-lg shadow hover:bg-blue-600 hover:scale-105 transition"
                                                data-id="{{ $b->id }}" data-nama="{{ $b->nama }}" data-ktp="{{ $b->ktp }}"
                                                data-npwp="{{ $b->npwp }}" data-telepon="{{ $b->telepon }}"
                                                data-email="{{ $b->email }}" data-alamat="{{ $b->alamat }}" title="Edit">
                                                <i class="fas fa-edit text-lg"></i>
                                            </button>
                                            <form method="post" action="{{ route('buyers.destroy', $b->id) }}" class="inline">
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
    <script src="{{ asset('modal/buyer.js') }}"></script>

    @include('modal.buyerAdd')
    @include('modal.buyerEdit')

    @include('sweetalert::alert')
    @include('layout.loading')
</body>

</html>
