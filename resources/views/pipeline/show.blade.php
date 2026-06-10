@extends('layouts.app')
@section('title','Detail Transaksi')

@php
  $slabel = ['done'=>'Selesai','active'=>'Sedang berjalan','pending'=>'Menunggu','skip'=>'Dilewati'];
  $scolor = ['done'=>'var(--green-text)','active'=>'var(--primary)','pending'=>'var(--faint)','skip'=>'var(--faint)'];
@endphp

@section('content')
  <a class="back" href="{{ route('pipeline.index') }}"><svg viewBox="0 0 24 24"><path d="M15 18l-6-6 6-6"/></svg> Kembali ke Tracking</a>
  <div class="dgrid">
    <div>
      <div class="card pad">
        <div class="detail-title">{{ $trx['name'] }}</div>
        <div style="color:var(--muted);margin-top:4px">Unit {{ $trx['code'] }}</div>
        <div class="facts">
          <div class="fact"><div class="k">Cara Bayar</div><div class="v">{{ $trx['pay'] }}</div></div>
          <div class="fact"><div class="k">Jenis Unit</div><div class="v">{{ $trx['indent'] ? 'Indent' : 'Ready stock' }}</div></div>
          <div class="fact"><div class="k">Tahap Aktif</div><div class="v">{{ $trx['stage']+1 }}. {{ $stages[$trx['stage']]['t'] }}</div></div>
          <div class="fact"><div class="k">Status</div><div class="v">Aktif</div></div>
        </div>
      </div>
      <div class="card pad" style="margin-top:18px">
        <div class="sec-h">Jadwal Pembayaran</div>
        @foreach($schedule as $r)
          <div class="doc"><span class="l">{{ $r[0] }}</span><span style="display:flex;gap:14px;align-items:center"><span class="money">{{ $r[1] }}</span><span class="badge {{ $r[3] }}">{{ $r[2] }}</span></span></div>
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
    <div class="card pad">
      <div class="sec-h">Tahapan Transaksi</div>
      @foreach($states as $s)
        <div class="tl-item {{ $s['state']==='skip' ? 'skip' : '' }}">
          <div class="tl-mk tl-{{ $s['state'] }}">@if($s['state']==='done')<svg viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg>@endif</div>
          <div class="tl-tx"><div class="n">{{ $s['no'] }}. {{ $s['label'] }}</div><div class="s" style="color:{{ $scolor[$s['state']] }}">{{ $slabel[$s['state']] }}</div></div>
        </div>
      @endforeach
    </div>
  </div>
@endsection
