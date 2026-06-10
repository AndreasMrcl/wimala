@extends('layouts.app')
@section('title','Detail Unit '.$unit['code'])

@php
  $slabel = ['done'=>'Selesai','active'=>'Sedang berjalan','pending'=>'Menunggu','skip'=>'Dilewati'];
  $scolor = ['done'=>'var(--green-text)','active'=>'var(--primary)','pending'=>'var(--faint)','skip'=>'var(--faint)'];
@endphp

@section('content')
  <a class="back" href="{{ route('units.index') }}"><svg viewBox="0 0 24 24"><path d="M15 18l-6-6 6-6"/></svg> Kembali ke Data Unit</a>
  <div class="dgrid">
    <div class="card pad">
      <div style="display:flex;align-items:center;justify-content:space-between">
        <div class="detail-title">{{ $unit['code'] }}</div>
        <span class="badge {{ $status[$unit['status']][1] }}" style="font-size:13px;padding:6px 14px">{{ $status[$unit['status']][0] }}</span>
      </div>
      <div style="color:var(--muted);margin-top:4px">{{ $unit['cluster'] }} · {{ $unit['blok'] }}</div>
      <div class="facts">
        <div class="fact"><div class="k">Tipe</div><div class="v">Tipe {{ $unit['tipe'] }}</div></div>
        <div class="fact"><div class="k">Luas Tanah / Bangunan</div><div class="v">LT {{ $unit['lt'] }} / LB {{ $unit['lb'] }} m²</div></div>
        <div class="fact"><div class="k">Harga</div><div class="v">Rp {{ number_format($unit['harga'],0,',','.') }}</div></div>
        <div class="fact"><div class="k">Cara Bayar</div><div class="v">{{ $unit['bayar']==='-' ? '—' : $unit['bayar'] }}</div></div>
      </div>

      <div class="card pad" style="margin-top:18px">
        <div class="sec-h">Transaksi Terkait</div>
        @if($trx)
          <div style="display:flex;align-items:center;justify-content:space-between">
            <div>
              <div style="font-weight:600;color:var(--head)">{{ $trx['name'] }}</div>
              <div style="font-size:12.5px;color:var(--muted);margin-top:5px">
                @if($trx['pay']==='KPR')<span class="badge bd-kpr">KPR</span>@else<span class="badge bd-cash">Cash</span>@endif
                · Tahap {{ $trx['stage']+1 }}. {{ $stages[$trx['stage']]['t'] }}
              </div>
            </div>
            <a class="back" style="margin:0" href="{{ route('transactions.show', $trx['id']) }}">Lihat transaksi <svg viewBox="0 0 24 24"><path d="M9 18l6-6-6-6"/></svg></a>
          </div>
        @else
          <div style="color:var(--muted);font-size:13.5px">Belum ada transaksi pada unit ini.</div>
        @endif
      </div>
    </div>

    <div>
      <div class="card pad">
        <div class="sec-h">Riwayat Status</div>
        @foreach($timeline as $it)
          <div class="tl-item {{ $it['state']==='skip' ? 'skip' : '' }}">
            <div class="tl-mk tl-{{ $it['state'] }}">@if($it['state']==='done')<svg viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg>@endif</div>
            <div class="tl-tx"><div class="n">{{ $it['label'] }}</div><div class="s" style="color:{{ $scolor[$it['state']] }}">{{ $slabel[$it['state']] }}</div></div>
          </div>
        @endforeach
      </div>
      <div class="card pad" style="margin-top:18px">
        <div class="sec-h">Dokumen</div>
        @foreach($docs as $d)
          <div class="doc"><span class="l"><svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6"/></svg> {{ $d[0] }}</span>
            @if($d[1])<span class="badge bd-done">Tersedia</span>@else<span class="badge bd-available">Belum ada</span>@endif
          </div>
        @endforeach
      </div>
    </div>
  </div>
@endsection
