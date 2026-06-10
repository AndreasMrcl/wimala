@extends('layouts.app')
@section('title','Tracking Penjualan')

@section('content')
  <div class="card pad">
    <div class="pghead">
      <div class="ti">
        <span class="tiic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="5" height="16" rx="1"/><rect x="10" y="4" width="5" height="11" rx="1"/><rect x="17" y="4" width="5" height="14" rx="1"/></svg></span>
        <div><h1>Tracking Penjualan</h1><div class="ds">Setiap kartu adalah satu transaksi yang bergerak mengikuti tahapannya</div></div>
      </div>
      <button class="btn-add"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.4"><path d="M12 5v14M5 12h14"/></svg> Transaksi Baru</button>
    </div>
    <div style="display:flex;gap:18px;font-size:12.5px;color:var(--muted);margin-bottom:16px;align-items:center">
      <span class="badge bd-kpr">KPR</span><span class="badge bd-cash">Cash</span>
      <span style="display:inline-flex;align-items:center;gap:6px">unit indent <span class="idot"></span></span>
    </div>
    <div class="kanban">
      @foreach($stages as $i => $st)
        @php $cards = array_values(array_filter($deals, fn($d) => $d['stage'] === $i)); @endphp
        <div class="kcol">
          <div class="kcol-h">
            <span class="t">{{ $i+1 }}. {{ $st['t'] }}@if($st['tag']==='kpr')<span class="ktag kt-kpr">KPR</span>@elseif($st['tag']==='indent')<span class="ktag kt-indent">indent</span>@endif</span>
            <span class="ct">{{ count($cards) }}</span>
          </div>
          @forelse($cards as $d)
            <a class="kcard" href="{{ route('transactions.show', $d['id']) }}" style="text-decoration:none;display:block">
              <div class="w">{{ $d['name'] }}</div>
              <div class="u">{{ $d['code'] }}</div>
              <div class="f">
                @if($d['pay']==='KPR')<span class="badge bd-kpr" style="font-size:10.5px;padding:3px 9px">KPR</span>@else<span class="badge bd-cash" style="font-size:10.5px;padding:3px 9px">Cash</span>@endif
                @if($d['indent'])<span class="idot"></span>@endif
              </div>
            </a>
          @empty
            <div class="kempty">—</div>
          @endforelse
        </div>
      @endforeach
    </div>
  </div>
  <p class="note">Tahap "Pengajuan KPR" otomatis dilewati untuk pembeli cash, dan "Konstruksi" dilewati untuk unit ready stock — satu papan melayani semua jenis transaksi.</p>
@endsection
