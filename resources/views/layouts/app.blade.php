<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Wimala Land — @yield('title', 'Sistem Informasi Pengembang Perumahan')</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables.net-dt/1.13.6/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
@php
  $isUnits    = request()->routeIs('units.*');
  $isTipe     = request()->routeIs('tipe.*');
  $isPipeline = request()->routeIs('pipeline.*') || request()->routeIs('transactions.*');
  $isInvoice  = request()->routeIs('invoices.*');
  $openMaster = $isUnits || $isTipe;
@endphp
<div class="app">

  <aside class="side">
    <div class="brand"><img class="logo" src="{{ asset('images/wimala-logo.png') }}" alt="Wimala Land"></div>
    <nav id="nav">
      <a href="{{ route('dashboard') }}" class="grp-parent {{ request()->routeIs('dashboard') ? 'open' : '' }}" style="text-decoration:none">
        <span class="ic"><svg viewBox="0 0 24 24" fill="none" stroke-width="1.8"><path d="M3 12l9-9 9 9"/><path d="M5 10v10h14V10"/></svg></span>
        Dashboard
      </a>

      <div class="grp-parent {{ $openMaster ? 'open' : '' }}" data-group="g-master">
        <span class="ic"><svg viewBox="0 0 24 24" fill="none" stroke-width="1.8"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg></span>
        Master Data
        <span class="chev"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg></span>
      </div>
      <div class="sub {{ $openMaster ? 'show' : '' }}" id="g-master">
        <a href="#" class="leaf">Proyek &amp; Cluster</a>
        <a href="{{ route('units.index') }}" class="leaf {{ $isUnits ? 'active' : '' }}">Data Unit</a>
        <a href="{{ route('tipe.index') }}" class="leaf {{ $isTipe ? 'active' : '' }}">Tipe Rumah</a>
        <a href="#" class="leaf">Bank Rekanan</a>
        <a href="#" class="leaf">Marketing</a>
      </div>

      <div class="grp-parent {{ $isPipeline ? 'open' : '' }}" data-group="g-sales">
        <span class="ic"><svg viewBox="0 0 24 24" fill="none" stroke-width="1.8"><rect x="3" y="11" width="5" height="9" rx="1"/><rect x="10" y="5" width="5" height="15" rx="1"/><rect x="17" y="8" width="5" height="12" rx="1"/></svg></span>
        Penjualan
        <span class="chev"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg></span>
      </div>
      <div class="sub {{ $isPipeline ? 'show' : '' }}" id="g-sales">
        <a href="{{ route('pipeline.index') }}" class="leaf {{ $isPipeline ? 'active' : '' }}">Tracking Penjualan</a>
        <a href="#" class="leaf">Pengajuan KPR</a>
      </div>

      <div class="grp-parent {{ $isInvoice ? 'open' : '' }}" data-group="g-fin">
        <span class="ic"><svg viewBox="0 0 24 24" fill="none" stroke-width="1.8"><path d="M6 2h8l4 4v16H6z"/><path d="M14 2v4h4"/><path d="M9 13h6M9 17h4"/></svg></span>
        Keuangan
        <span class="chev"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg></span>
      </div>
      <div class="sub {{ $isInvoice ? 'show' : '' }}" id="g-fin">
        <a href="{{ route('invoices.index') }}" class="leaf {{ $isInvoice ? 'active' : '' }}">Invoice &amp; Pembayaran</a>
        <a href="#" class="leaf">Kas Masuk / Keluar</a>
      </div>

      <a href="#" class="grp-parent" style="text-decoration:none">
        <span class="ic"><svg viewBox="0 0 24 24" fill="none" stroke-width="1.8"><path d="M4 19V5"/><path d="M4 19h16"/><path d="M8 16l3-4 3 3 4-6"/></svg></span>
        Laporan
      </a>
    </nav>
  </aside>

  <main class="main">
    <div class="topbar">
      <div class="search">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path d="M21 21l-4-4"/></svg>
        <input placeholder="Cari...">
      </div>
      <div class="me">Admin <span class="pic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="4"/><path d="M4 21c0-4 4-6 8-6s8 2 8 6"/></svg></span></div>
    </div>

    <div class="content">
      <div class="view active">
        @yield('content')
      </div>
    </div>
  </main>
</div>

@yield('modal')

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
<script src="{{ asset('js/app.js') }}"></script>
@stack('scripts')
</body>
</html>
