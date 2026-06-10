@extends('layouts.app')
@section('title','Tipe Rumah')

@section('content')
  <div class="card pad">
    <div class="pghead">
      <div class="ti">
        <span class="tiic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-6 9 6v11a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1z"/><path d="M9 21V12h6v9"/></svg></span>
        <div><h1>Tipe Rumah</h1><div class="ds">Kelola tipe dan spesifikasi rumah</div></div>
      </div>
      <button class="btn-add" onclick="openTipeModal()"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.4"><path d="M12 5v14M5 12h14"/></svg> Tambah Tipe</button>
    </div>
    <table class="dt" style="width:100%">
      <thead><tr>
        <th>Nama Tipe</th><th>Luas Tanah</th><th>Luas Bangunan</th><th>Kamar</th><th class="txt-right">Harga Dasar</th><th class="txt-center">Aksi</th>
      </tr></thead>
      <tbody>
      @foreach($tipe as $t)
        <tr>
          <td><span class="c1">{{ $t['nama'] }}</span></td>
          <td>{{ $t['lt'] }} m²</td>
          <td>{{ $t['lb'] }} m²</td>
          <td>{{ $t['kt'] }} KT / {{ $t['km'] }} KM</td>
          <td class="txt-right money">Rp {{ number_format($t['harga'],0,',','.') }}</td>
          <td class="txt-center"><div class="act">
            <button class="a-edit" title="Ubah"
              onclick="openTipeModal(this)"
              data-nama="{{ $t['nama'] }}" data-lt="{{ $t['lt'] }}" data-lb="{{ $t['lb'] }}" data-kt="{{ $t['kt'] }}" data-km="{{ $t['km'] }}" data-harga="{{ $t['harga'] }}">
              <svg viewBox="0 0 24 24"><path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4z"/></svg>
            </button>
            <button class="a-del" title="Hapus"><svg viewBox="0 0 24 24"><path d="M3 6h18"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6M14 11v6"/></svg></button>
          </div></td>
        </tr>
      @endforeach
      </tbody>
    </table>
  </div>
  <p class="note">Form tambah/ubah hanya tampilan untuk prototype — belum menyimpan data.</p>
@endsection

@section('modal')
<div class="modal-bg" id="modalTipe">
  <div class="modal">
    <div class="modal-h"><h3 id="mTitle">Tambah Tipe Rumah</h3><button class="modal-x" onclick="closeTipe()">&times;</button></div>
    <div class="modal-b">
      <div class="field"><label>Nama Tipe</label><input id="m_nama" placeholder="mis. Tipe 36/72"></div>
      <div class="frow"><div class="field"><label>Luas Tanah (m²)</label><input id="m_lt" type="number"></div><div class="field"><label>Luas Bangunan (m²)</label><input id="m_lb" type="number"></div></div>
      <div class="frow"><div class="field"><label>Kamar Tidur</label><input id="m_kt" type="number"></div><div class="field"><label>Kamar Mandi</label><input id="m_km" type="number"></div></div>
      <div class="field"><label>Harga Dasar (Rp)</label><input id="m_harga" type="number"></div>
    </div>
    <div class="modal-f"><button class="btn-ghost" onclick="closeTipe()">Batal</button><button class="btn-primary" onclick="closeTipe()">Simpan</button></div>
  </div>
</div>
@endsection
