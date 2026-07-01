<!DOCTYPE html>
<html lang="id">

<head>
    <title>Detail Unit {{ $unit->kode }}</title>
    @include('layout.head')
</head>

@php
    $statusColor = [
        'available'   => 'bg-green-100 text-green-700 border-green-200',
        'booked'      => 'bg-blue-100 text-blue-700 border-blue-200',
        'sold'        => 'bg-amber-100 text-amber-700 border-amber-200',
        'handed_over' => 'bg-purple-100 text-purple-700 border-purple-200',
        'completed'   => 'bg-gray-100 text-gray-700 border-gray-200',
    ];
    $tlColor = [
        'done'    => ['dot' => 'bg-green-500 text-white', 'label' => 'text-gray-700', 'sub' => 'text-green-600', 'text' => 'Selesai'],
        'active'  => ['dot' => 'bg-sky-500 text-white ring-4 ring-sky-100', 'label' => 'text-gray-900 font-semibold', 'sub' => 'text-sky-600', 'text' => 'Sedang berjalan'],
        'pending' => ['dot' => 'bg-gray-200 text-gray-400', 'label' => 'text-gray-400', 'sub' => 'text-gray-400', 'text' => 'Menunggu'],
    ];
@endphp

<body class="bg-gray-50 font-sans">
    @include('layout.sidebar')

    <main class="md:ml-64 xl:ml-72 2xl:ml-72">
        @include('layout.navbar')
        <div class="p-6 space-y-6">

            <!-- Back -->
            <a href="{{ route('units.index') }}"
                class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-sky-600 transition">
                <i class="fas fa-arrow-left"></i> Kembali ke Data Unit
            </a>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <!-- LEFT: Summary + Transaction -->
                <div class="lg:col-span-2 space-y-6">

                    <!-- Unit Summary -->
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                        <div class="flex items-start justify-between">
                            <div>
                                <h1 class="text-2xl font-bold text-gray-800">{{ $unit->kode }}</h1>
                                <p class="text-sm text-gray-500 mt-1">
                                    <i class="fas fa-location-dot text-gray-400"></i>
                                    {{ $unit->cluster?->nama }} · Blok {{ $unit->blok }} No. {{ $unit->nomor }}
                                </p>
                            </div>
                            <span class="{{ $statusColor[$unit->status] ?? 'bg-gray-100 text-gray-600 border-gray-200' }} text-xs px-4 py-1.5 rounded-full font-bold border whitespace-nowrap">
                                {{ \App\Models\Unit::STATUS_LABELS[$unit->status] ?? $unit->status }}
                            </span>
                        </div>

                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-6">
                            <div class="bg-gray-50 rounded-lg p-4">
                                <div class="text-xs text-gray-400 uppercase tracking-wide">Tipe</div>
                                <div class="font-semibold text-gray-800 mt-1">{{ $unit->houseType?->nama }}</div>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <div class="text-xs text-gray-400 uppercase tracking-wide">Luas T / B</div>
                                <div class="font-semibold text-gray-800 mt-1">{{ $unit->luas_tanah }} / {{ $unit->luas_bangunan }} m²</div>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <div class="text-xs text-gray-400 uppercase tracking-wide">Harga</div>
                                <div class="font-semibold text-gray-800 mt-1">Rp {{ number_format($unit->harga, 0, ',', '.') }}</div>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <div class="text-xs text-gray-400 uppercase tracking-wide">Jenis Unit</div>
                                <div class="font-semibold text-gray-800 mt-1">{{ $unit->delivery_type === 'indent' ? 'Indent' : 'Ready stock' }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Related Transaction -->
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                        <h3 class="font-bold text-gray-800 text-lg mb-4">Transaksi Terkait</h3>
                        @if ($trx)
                            <div class="flex items-center justify-between">
                                <div>
                                    <div class="font-semibold text-gray-800">{{ $trx->buyer->nama }}</div>
                                    <div class="text-xs text-gray-500 mt-1 flex items-center gap-2">
                                        @if ($trx->payment_method === 'kpr')
                                            <span class="bg-sky-100 text-sky-700 px-2.5 py-0.5 rounded-full font-bold border border-sky-200">KPR</span>
                                        @else
                                            <span class="bg-emerald-100 text-emerald-700 px-2.5 py-0.5 rounded-full font-bold border border-emerald-200">{{ $trx->paymentLabel() }}</span>
                                        @endif
                                        · {{ $trx->currentStage->sequence }}. {{ $trx->currentStage->name }}
                                    </div>
                                </div>
                                <a href="{{ route('transactions.show', $trx) }}"
                                    class="inline-flex items-center gap-1 text-sm font-medium text-sky-600 hover:text-sky-700">
                                    Lihat transaksi <i class="fas fa-chevron-right text-xs"></i>
                                </a>
                            </div>
                        @else
                            <p class="text-sm text-gray-400">Belum ada transaksi pada unit ini.</p>
                        @endif
                    </div>

                </div>

                <!-- RIGHT: Timeline + Documents -->
                <div class="space-y-6">

                    <!-- Status Timeline -->
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                        <h3 class="font-bold text-gray-800 text-lg mb-5">Riwayat Status</h3>
                        <div class="space-y-1">
                            @foreach ($timeline as $i => $it)
                                @php $c = $tlColor[$it['state']]; @endphp
                                <div class="flex gap-3">
                                    <div class="flex flex-col items-center">
                                        <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs {{ $c['dot'] }}">
                                            @if ($it['state'] === 'done')
                                                <i class="fas fa-check"></i>
                                            @else
                                                {{ $i + 1 }}
                                            @endif
                                        </div>
                                        @if (! $loop->last)
                                            <div class="w-0.5 flex-1 min-h-6 {{ $it['state'] === 'done' ? 'bg-green-200' : 'bg-gray-200' }}"></div>
                                        @endif
                                    </div>
                                    <div class="pb-4">
                                        <div class="text-sm {{ $c['label'] }}">{{ $it['label'] }}</div>
                                        <div class="text-xs {{ $c['sub'] }}">{{ $c['text'] }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Documents -->
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                        <h3 class="font-bold text-gray-800 text-lg mb-4">Dokumen</h3>
                        <div class="space-y-2">
                            @foreach ($docs as $d)
                                <div class="flex items-center justify-between py-2 border-b border-gray-50 last:border-0">
                                    <span class="text-sm text-gray-600 flex items-center gap-2">
                                        <i class="fas fa-file-lines text-gray-400"></i> {{ $d[0] }}
                                    </span>
                                    @if ($d[1])
                                        <span class="bg-green-100 text-green-700 text-xs px-3 py-1 rounded-full font-bold border border-green-200">Tersedia</span>
                                    @else
                                        <span class="bg-gray-100 text-gray-400 text-xs px-3 py-1 rounded-full font-bold border border-gray-200">Belum ada</span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </main>

    @include('layout.loading')
</body>

</html>
