<!DOCTYPE html>
<html lang="id">

<head>
    <title>Detail Transaksi — {{ $transaction->buyer->nama }}</title>
    @include('layout.head')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

@php
    $tlColor = [
        'done'        => ['dot' => 'bg-green-500 text-white', 'line' => 'bg-green-200', 'label' => 'text-gray-700', 'sub' => 'text-green-600', 'text' => 'Selesai', 'icon' => 'check'],
        'in_progress' => ['dot' => 'bg-sky-500 text-white ring-4 ring-sky-100', 'line' => 'bg-gray-200', 'label' => 'text-gray-900 font-semibold', 'sub' => 'text-sky-600', 'text' => 'Sedang berjalan', 'icon' => null],
        'pending'     => ['dot' => 'bg-gray-200 text-gray-400', 'line' => 'bg-gray-200', 'label' => 'text-gray-400', 'sub' => 'text-gray-400', 'text' => 'Menunggu', 'icon' => null],
        'skipped'     => ['dot' => 'bg-gray-100 text-gray-300', 'line' => 'bg-gray-100', 'label' => 'text-gray-300 line-through', 'sub' => 'text-gray-300', 'text' => 'Dilewati', 'icon' => 'minus'],
        'failed'      => ['dot' => 'bg-red-500 text-white', 'line' => 'bg-gray-200', 'label' => 'text-red-700', 'sub' => 'text-red-600', 'text' => 'Gagal', 'icon' => 'xmark'],
    ];
    $statusBadge = [
        'active'    => 'bg-sky-100 text-sky-700 border-sky-200',
        'completed' => 'bg-green-100 text-green-700 border-green-200',
        'cancelled' => 'bg-red-100 text-red-700 border-red-200',
    ];
    $statusLabel = ['active' => 'Aktif', 'completed' => 'Selesai', 'cancelled' => 'Dibatalkan'];
@endphp

<body class="bg-gray-50 font-sans">
    @include('layout.sidebar')

    <main class="md:ml-64 xl:ml-72 2xl:ml-72">
        @include('layout.navbar')
        <div class="p-6 space-y-6">

            <!-- Back -->
            <a href="{{ route('pipeline.index') }}"
                class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-sky-600 transition">
                <i class="fas fa-arrow-left"></i> Kembali ke Tracking Penjualan
            </a>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <!-- LEFT -->
                <div class="lg:col-span-2 space-y-6">

                    <!-- Summary -->
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                        <div class="flex items-start justify-between">
                            <div>
                                <h1 class="text-2xl font-bold text-gray-800">{{ $transaction->buyer->nama }}</h1>
                                <p class="text-sm text-gray-500 mt-1">
                                    <i class="fas fa-house text-gray-400"></i>
                                    Unit <a href="{{ route('units.show', $transaction->unit) }}" class="text-sky-600 hover:underline">{{ $transaction->unit->kode }}</a>
                                    · {{ $transaction->unit->cluster?->nama }}
                                </p>
                            </div>
                            <span class="{{ $statusBadge[$transaction->status] }} text-xs px-4 py-1.5 rounded-full font-bold border whitespace-nowrap">
                                {{ $statusLabel[$transaction->status] }}
                            </span>
                        </div>

                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-6">
                            <div class="bg-gray-50 rounded-lg p-4">
                                <div class="text-xs text-gray-400 uppercase tracking-wide">Cara Bayar</div>
                                <div class="font-semibold text-gray-800 mt-1">{{ $transaction->paymentLabel() }}</div>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <div class="text-xs text-gray-400 uppercase tracking-wide">Jenis Unit</div>
                                <div class="font-semibold text-gray-800 mt-1">{{ $transaction->unit->delivery_type === 'indent' ? 'Indent' : 'Ready stock' }}</div>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <div class="text-xs text-gray-400 uppercase tracking-wide">Bank</div>
                                <div class="font-semibold text-gray-800 mt-1">{{ $transaction->bank?->nama ?? '—' }}</div>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <div class="text-xs text-gray-400 uppercase tracking-wide">Marketing</div>
                                <div class="font-semibold text-gray-800 mt-1">{{ $transaction->marketing?->nama ?? '—' }}</div>
                            </div>
                        </div>

                        @if ($transaction->status === 'cancelled' && $transaction->cancelled_reason)
                            <div class="mt-4 bg-red-50 border border-red-200 text-red-700 text-sm rounded-lg p-3">
                                <span class="font-semibold">Alasan pembatalan:</span> {{ $transaction->cancelled_reason }}
                            </div>
                        @endif
                    </div>

                    <!-- Actions -->
                    @if ($transaction->status === 'active')
                        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                            <h3 class="font-bold text-gray-800 text-lg mb-4">Tindakan</h3>
                            <form action="{{ route('transactions.advance', $transaction) }}" method="POST" class="space-y-3">
                                @csrf
                                <label class="block text-sm font-semibold text-gray-700">Catatan tahap (opsional)</label>
                                <textarea name="notes" rows="2"
                                    class="w-full rounded-lg border-gray-300 shadow-sm p-2.5 border focus:ring-2 focus:ring-sky-500"
                                    placeholder="mis. SP2K terbit, siap PPJB"></textarea>
                                <div class="flex flex-wrap gap-3">
                                    <x-button type="submit" variant="success" icon="circle-check">
                                        Selesaikan tahap "{{ $transaction->currentStage->name }}" &amp; lanjut
                                    </x-button>
                                    <button type="button" id="cancelBtn"
                                        class="font-bold rounded-lg px-6 py-3 text-base bg-red-600 text-white hover:bg-red-700 shadow-md flex items-center gap-2">
                                        <i class="fas fa-ban"></i> Batalkan transaksi
                                    </button>
                                </div>
                            </form>
                        </div>
                    @endif
                </div>

                <!-- RIGHT: Stage Timeline -->
                <div class="space-y-6">
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                        <h3 class="font-bold text-gray-800 text-lg mb-5">Tahapan Transaksi</h3>
                        <div class="space-y-1">
                            @foreach ($states as $s)
                                @php $c = $tlColor[$s['status']] ?? $tlColor['pending']; @endphp
                                <div class="flex gap-3">
                                    <div class="flex flex-col items-center">
                                        <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-semibold {{ $c['dot'] }}">
                                            @if ($c['icon'] === 'check')
                                                <i class="fas fa-check"></i>
                                            @elseif ($c['icon'] === 'minus')
                                                <i class="fas fa-minus"></i>
                                            @elseif ($c['icon'] === 'xmark')
                                                <i class="fas fa-xmark"></i>
                                            @else
                                                {{ $s['no'] }}
                                            @endif
                                        </div>
                                        @if (! $loop->last)
                                            <div class="w-0.5 flex-1 min-h-6 {{ $c['line'] }}"></div>
                                        @endif
                                    </div>
                                    <div class="pb-4">
                                        <div class="text-sm {{ $c['label'] }}">{{ $s['no'] }}. {{ $s['label'] }}</div>
                                        <div class="text-xs {{ $c['sub'] }}">{{ $c['text'] }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </main>

    @if ($transaction->status === 'active')
        <form id="cancelForm" action="{{ route('transactions.cancel', $transaction) }}" method="POST" class="hidden">
            @csrf
            <input type="hidden" name="cancelled_reason" id="cancelReason">
        </form>
        <script>
            document.getElementById('cancelBtn')?.addEventListener('click', function () {
                Swal.fire({
                    title: 'Batalkan transaksi?',
                    input: 'textarea',
                    inputLabel: 'Alasan pembatalan',
                    inputPlaceholder: 'mis. KPR ditolak bank',
                    inputAttributes: { required: true },
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonText: 'Batal',
                    confirmButtonText: 'Ya, batalkan',
                    preConfirm: (value) => {
                        if (!value) {
                            Swal.showValidationMessage('Alasan wajib diisi');
                        }
                        return value;
                    },
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('cancelReason').value = result.value;
                        document.getElementById('cancelForm').submit();
                    }
                });
            });
        </script>
    @endif

    @include('sweetalert::alert')
    @include('layout.loading')
</body>

</html>
