@extends('layouts.app')
@section('title','Manajemen Unit')

@section('content')
  <div class="card pad">
    <div class="pghead">
      <div class="ti">
        <span class="tiic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 21h18"/><path d="M5 21V7l8-4v18"/><path d="M19 21V11l-6-4"/></svg></span>
        <div><h1>Manajemen Unit</h1><div class="ds">Kelola seluruh unit di semua cluster</div></div>
      </div>
      <button class="btn-add"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.4"><path d="M12 5v14M5 12h14"/></svg> Tambah Unit</button>
    </div>
    <table class="dt" style="width:100%">
      <thead><tr>
        <th>Unit / Cluster</th><th>Tipe / Luas</th><th class="txt-right" style="width:180px">Harga</th>
        <th class="txt-center">Cara Bayar</th><th class="txt-center">Status</th><th class="txt-center">Aksi</th>
      </tr></thead>
      <tbody>
      @foreach($units as $u)
        <tr>
          <td><div class="c1">{{ $u['code'] }}</div><div class="c2"><svg viewBox="0 0 24 24"><path d="M3 21h18"/><path d="M6 21V8l6-4 6 4v13"/><path d="M10 21v-5h4v5"/></svg> {{ $u['cluster'] }}</div><div class="c3">{{ $u['blok'] }}</div></td>
          <td><div class="c1" style="font-size:13px">Tipe {{ $u['tipe'] }}</div><div class="c3">LT {{ $u['lt'] }} / LB {{ $u['lb'] }} m²</div></td>
          <td class="txt-right money">Rp {{ number_format($u['harga'],0,',','.') }}</td>
          <td class="txt-center">
            @if($u['bayar']==='KPR')<span class="badge bd-kpr">KPR</span>
            @elseif($u['bayar']==='Cash')<span class="badge bd-cash">Cash</span>
            @else<span style="color:#aab2bf">—</span>@endif
          </td>
          <td class="txt-center"><span class="badge {{ $status[$u['status']][1] }}">{{ $status[$u['status']][0] }}</span></td>
          <td class="txt-center"><div class="act">
            <button class="a-view" title="Lihat" onclick="location.href='{{ route('units.show', $u['code']) }}'"><svg viewBox="0 0 24 24"><path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7S1 12 1 12z"/><circle cx="12" cy="12" r="3"/></svg></button>
            <button class="a-edit" title="Ubah"><svg viewBox="0 0 24 24"><path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4z"/></svg></button>
            <button class="a-del" title="Hapus"><svg viewBox="0 0 24 24"><path d="M3 6h18"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6M14 11v6"/></svg></button>
          </div></td>
        </tr>
      @endforeach
      </tbody>
    </table>
  </div>
  <p class="note">Status unit dijaga otomatis oleh sistem agar satu unit tidak mungkin terjual ke dua pembeli.</p>
@endsection
