<!DOCTYPE html>
<html lang="id">

<head>
    <title>Invoice {{ $invoice->no_invoice }}</title>
    @include('layout.head')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

@php
    $eff = $invoice->effectiveStatus();
    $statusColor = [
        'paid'   => 'bg-green-100 text-green-700 border-green-200',
        'unpaid' => 'bg-blue-100 text-blue-700 border-blue-200',
        'late'   => 'bg-red-100 text-red-700 border-red-200',
    ];
    $statusLabel = ['paid' => 'Lunas', 'unpaid' => 'Belum jatuh tempo', 'late' => 'Terlambat'];
@endphp

<body class="bg-gray-50 font-sans">
    @include('layout.sidebar')

    <main class="md:ml-64 xl:ml-72 2xl:ml-72">
        @include('layout.navbar')
        <div class="p-6 space-y-6">

            <a href="{{ route('invoices.index') }}"
                class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-sky-600 transition">
                <i class="fas fa-arrow-left"></i> Kembali ke Invoice
            </a>

            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-600 text-sm rounded-xl p-3">
                    {{ $errors->first() }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <!-- LEFT -->
                <div class="lg:col-span-2 space-y-6">

                    <!-- Invoice Summary -->
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                        <div class="flex items-start justify-between">
                            <div>
                                <h1 class="text-2xl font-bold text-gray-800">{{ $invoice->no_invoice }}</h1>
                                <p class="text-sm text-gray-500 mt-1">
                                    {{ $invoice->terminLabel() }} ·
                                    Unit <a href="{{ route('units.show', $invoice->saleTransaction->unit) }}" class="text-sky-600 hover:underline">{{ $invoice->saleTransaction->unit->kode }}</a>
                                    · {{ $invoice->saleTransaction->buyer->nama }}
                                </p>
                            </div>
                            <span class="{{ $statusColor[$eff] }} text-xs px-4 py-1.5 rounded-full font-bold border whitespace-nowrap">
                                {{ $statusLabel[$eff] }}
                            </span>
                        </div>

                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mt-6">
                            <div class="bg-gray-50 rounded-lg p-4">
                                <div class="text-xs text-gray-400 uppercase tracking-wide">Jumlah Tagihan</div>
                                <div class="font-semibold text-gray-800 mt-1">Rp {{ number_format($invoice->jumlah, 0, ',', '.') }}</div>
                            </div>
                            <div class="bg-green-50 rounded-lg p-4">
                                <div class="text-xs text-green-600 uppercase tracking-wide">Sudah Dibayar</div>
                                <div class="font-semibold text-green-700 mt-1">Rp {{ number_format($invoice->paidAmount(), 0, ',', '.') }}</div>
                            </div>
                            <div class="bg-amber-50 rounded-lg p-4">
                                <div class="text-xs text-amber-600 uppercase tracking-wide">Sisa</div>
                                <div class="font-semibold text-amber-700 mt-1">Rp {{ number_format($invoice->outstanding(), 0, ',', '.') }}</div>
                            </div>
                        </div>
                        <div class="text-xs text-gray-400 mt-3">
                            Jatuh tempo: {{ $invoice->jatuh_tempo->translatedFormat('l, d F Y') }}
                        </div>
                    </div>

                    <!-- Payment History -->
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                        <h3 class="font-bold text-gray-800 text-lg mb-4">Riwayat Pembayaran</h3>
                        @if ($invoice->payments->isEmpty())
                            <p class="text-sm text-gray-400">Belum ada pembayaran.</p>
                        @else
                            <div class="overflow-auto">
                                <table class="w-full text-left text-sm">
                                    <thead class="text-gray-500 border-b border-gray-100">
                                        <tr>
                                            <th class="py-2 pr-4 font-semibold">Tanggal</th>
                                            <th class="py-2 pr-4 font-semibold text-right">Jumlah</th>
                                            <th class="py-2 pr-4 font-semibold">Metode</th>
                                            <th class="py-2 pr-4 font-semibold">Bukti</th>
                                            <th class="py-2 pr-4 font-semibold">Dikonfirmasi</th>
                                            <th class="py-2 font-semibold text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-gray-700">
                                        @foreach ($invoice->payments as $p)
                                            <tr class="border-b border-gray-50 last:border-0">
                                                <td class="py-2 pr-4">{{ $p->tanggal->translatedFormat('d M Y') }}</td>
                                                <td class="py-2 pr-4 text-right font-mono">Rp {{ number_format($p->jumlah, 0, ',', '.') }}</td>
                                                <td class="py-2 pr-4 capitalize">{{ $p->metode }}</td>
                                                <td class="py-2 pr-4">
                                                    @if ($p->bukti_transfer)
                                                        <a href="{{ asset('storage/'.$p->bukti_transfer) }}" target="_blank"
                                                            class="text-sky-600 hover:underline inline-flex items-center gap-1">
                                                            <i class="fas fa-paperclip"></i> Lihat
                                                        </a>
                                                    @else
                                                        <span class="text-gray-300">—</span>
                                                    @endif
                                                </td>
                                                <td class="py-2 pr-4 text-xs text-gray-500">{{ $p->confirmedBy?->name ?? '—' }}</td>
                                                <td class="py-2 text-center">
                                                    <form method="post" action="{{ route('payments.destroy', $p) }}" class="inline">
                                                        @csrf @method('delete')
                                                        <button type="button"
                                                            class="delete-confirm w-8 h-8 inline-flex items-center justify-center bg-red-500 text-white rounded-lg hover:bg-red-600 transition"
                                                            title="Hapus">
                                                            <i class="fas fa-trash text-sm"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- RIGHT: Record Payment -->
                <div class="space-y-6">
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                        <h3 class="font-bold text-gray-800 text-lg mb-4">Catat Pembayaran</h3>
                        @if ($invoice->isPaid())
                            <div class="bg-green-50 border border-green-200 text-green-700 text-sm rounded-lg p-3">
                                <i class="fas fa-circle-check"></i> Invoice ini sudah lunas.
                            </div>
                        @endif
                        <form action="{{ route('payments.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4 mt-2">
                            @csrf
                            <input type="hidden" name="invoice_id" value="{{ $invoice->id }}">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Tanggal Bayar</label>
                                <input type="date" name="tanggal" value="{{ now()->format('Y-m-d') }}"
                                    class="w-full rounded-lg border-gray-300 shadow-sm p-2.5 border focus:ring-2 focus:ring-sky-500" required>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Jumlah (Rp)</label>
                                <input type="text" name="jumlah" value="{{ number_format($invoice->outstanding(), 0, ',', '.') }}"
                                    class="currency w-full rounded-lg border-gray-300 shadow-sm p-2.5 border focus:ring-2 focus:ring-sky-500" required>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Metode</label>
                                <select name="metode"
                                    class="w-full rounded-lg border-gray-300 shadow-sm p-2.5 border focus:ring-2 focus:ring-sky-500" required>
                                    <option value="transfer">Transfer</option>
                                    <option value="tunai">Tunai</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Bukti Transfer (opsional)</label>
                                <input type="file" name="bukti_transfer" accept=".jpg,.jpeg,.png,.pdf"
                                    class="w-full text-sm text-gray-600 file:mr-3 file:rounded-lg file:border-0 file:bg-sky-50 file:px-3 file:py-2 file:text-sky-700">
                                <p class="text-[11px] text-gray-400 mt-1">JPG/PNG/PDF, maks 2 MB.</p>
                            </div>
                            <x-button type="submit" variant="success" icon="money-bill-wave" class="w-full justify-center">Catat Pembayaran</x-button>
                        </form>
                    </div>
                </div>

            </div>

        </div>
    </main>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="{{ asset('modal/invoice.js') }}"></script>

    @include('sweetalert::alert')
    @include('layout.loading')
</body>

</html>
