@extends('layouts.app')
@section('title','Invoice & Pembayaran')

@section('content')
  <div class="card pad">
    <div class="pghead">
      <div class="ti">
        <span class="tiic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2h9l3 3v17l-3-2-3 2-3-2-3 2V5z"/><path d="M9 8h6M9 12h6"/></svg></span>
        <div><h1>Invoice &amp; Pembayaran</h1><div class="ds">Penagihan termin dan pencatatan pembayaran masuk</div></div>
      </div>
      <button class="btn-add"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.4"><path d="M12 5v14M5 12h14"/></svg> Buat Invoice</button>
    </div>

    <div class="kpis" style="margin-bottom:22px">
      <div class="stat color c-blue"><div class="txt"><div class="lbl">Total Tertagih</div><div class="val" style="font-size:24px">Rp 18,4 M</div><div class="per">48 invoice aktif</div></div><div class="ricon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2h9l3 3v17l-3-2-3 2-3-2-3 2V5z"/></svg></div></div>
      <div class="stat color c-green"><div class="txt"><div class="lbl">Sudah Terbayar</div><div class="val" style="font-size:24px">Rp 13,2 M</div><div class="per">72% tertagih</div></div><div class="ricon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6L9 17l-5-5"/></svg></div></div>
      <div class="stat color c-amber"><div class="txt"><div class="lbl">Belum Jatuh Tempo</div><div class="val" style="font-size:24px">Rp 3,3 M</div><div class="per">ditagih bulan depan</div></div><div class="ricon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg></div></div>
      <div class="stat color c-red"><div class="txt"><div class="lbl">Terlambat</div><div class="val" style="font-size:24px">Rp 1,9 M</div><div class="per">7 invoice perlu reminder</div></div><div class="ricon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 9v4M12 17h.01"/><path d="M10.3 3.9 1.8 18a2 2 0 0 0 1.7 3h17a2 2 0 0 0 1.7-3L13.7 3.9a2 2 0 0 0-3.4 0z"/></svg></div></div>
    </div>

    <table class="dt" style="width:100%">
      <thead><tr>
        <th>Invoice / Unit</th><th>Pembeli</th><th>Jenis Termin</th><th class="txt-right">Jumlah</th>
        <th class="txt-center">Jatuh Tempo</th><th class="txt-center">Status</th><th class="txt-center">Aksi</th>
      </tr></thead>
      <tbody>
      @foreach($invoices as $v)
        <tr>
          <td><div class="c1" style="font-size:13px">{{ $v['no'] }}</div><div class="c3">Unit {{ $v['unit'] }}</div></td>
          <td>{{ $v['pembeli'] }}</td>
          <td>{{ $v['termin'] }}</td>
          <td class="txt-right money">Rp {{ number_format($v['jumlah'],0,',','.') }}</td>
          <td class="txt-center"><span class="pill-blue"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg>{{ $v['jatuh'] }}</span></td>
          <td class="txt-center"><span class="badge {{ $status[$v['status']][1] }}">{{ $status[$v['status']][0] }}</span></td>
          <td class="txt-center"><div class="act">
            <button class="a-view" title="Lihat"><svg viewBox="0 0 24 24"><path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7S1 12 1 12z"/><circle cx="12" cy="12" r="3"/></svg></button>
            <button class="a-edit" title="Ubah"><svg viewBox="0 0 24 24"><path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4z"/></svg></button>
            <button class="a-del" title="Hapus"><svg viewBox="0 0 24 24"><path d="M3 6h18"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6M14 11v6"/></svg></button>
          </div></td>
        </tr>
      @endforeach
      </tbody>
    </table>
  </div>
  <p class="note">Sesuai kebutuhan klien, pembayaran dikonfirmasi manual dari bukti transfer — tanpa payment gateway.</p>
@endsection
