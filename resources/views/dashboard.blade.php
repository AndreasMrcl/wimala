@extends('layouts.app')
@section('title','Dashboard')

@section('content')
  <div class="card pad" style="margin-bottom:18px">
    <div class="pghead" style="margin-bottom:0">
      <div class="ti">
        <span class="tiic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19V5"/><path d="M4 19h16"/><path d="M8 16l3-4 3 3 4-6"/></svg></span>
        <div><h1>Dashboard</h1><div class="ds">Ringkasan inventory, penjualan, dan keuangan proyek</div></div>
      </div>
      <div class="date">{{ now()->locale('id')->translatedFormat('l, d F Y') }}</div>
    </div>
  </div>

  <div class="kpis">
    <div class="stat"><div class="lbl">Total Unit</div><div class="val">210</div><div class="dlt"><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M12 19V5"/><path d="M6 11l6-6 6 6"/></svg> +30 unit · 2 cluster</div></div>
    <div class="stat"><div class="lbl">Unit Terjual</div><div class="val">82</div><div class="dlt"><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M12 19V5"/><path d="M6 11l6-6 6 6"/></svg> +6 bulan ini</div></div>
    <div class="stat"><div class="lbl">Pengajuan KPR Aktif</div><div class="val">14</div><div class="dlt"><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M12 19V5"/><path d="M6 11l6-6 6 6"/></svg> +3 bulan ini</div></div>
    <div class="stat"><div class="lbl">Penerimaan Bulan Ini</div><div class="val">Rp 4.825.000.000</div><div class="sub">42 pembayaran masuk</div></div>
  </div>

  <div class="kpis">
    <div class="stat color c-green"><div class="txt"><div class="lbl">Stok Tersedia</div><div class="val">98</div><div class="per">Jun 2026</div></div><div class="ricon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 11l9-8 9 8"/><path d="M5 10v10h14V10"/></svg></div></div>
    <div class="stat color c-blue"><div class="txt"><div class="lbl">Unit Dibooking</div><div class="val">30</div><div class="per">Jun 2026</div></div><div class="ricon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 3h12v18l-6-4-6 4z"/></svg></div></div>
    <div class="stat color c-amber"><div class="txt"><div class="lbl">Menunggu SP2K</div><div class="val">14</div><div class="per">Jun 2026</div></div><div class="ricon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6"/></svg></div></div>
    <div class="stat color c-purple"><div class="txt"><div class="lbl">Serah Terima</div><div class="val">5</div><div class="per">Jun 2026</div></div><div class="ricon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="8" cy="14" r="5"/><path d="M11.5 11.5L21 2l1 4-3 1 1 3-3 1"/></svg></div></div>
  </div>

  <div class="charts">
    <div class="card pad chart-card"><h3>Tren Penjualan</h3><div class="cs">6 periode terakhir</div><div class="chart-box"><canvas id="chartSales"></canvas></div></div>
    <div class="card pad chart-card"><h3>Penjualan per Cluster</h3><div class="cs">Realisasi dibanding target</div><div class="chart-box"><canvas id="chartCluster"></canvas></div></div>
  </div>
  <p class="note">Semua angka adalah data contoh untuk ilustrasi. Pada sistem sebenarnya, angka diperbarui otomatis dari aktivitas penjualan dan pembayaran.</p>
@endsection

@push('scripts')
<script>
  var CHART = @json($chart);
  if (window.Chart) {
    Chart.defaults.font.family = "Segoe UI, system-ui, sans-serif";
    Chart.defaults.color = "#64748b";
    new Chart(document.getElementById('chartSales'), { type:'line',
      data:{ labels:CHART.salesLabels, datasets:[
        {label:'Unit terjual',data:CHART.terjual,borderColor:'#1875b9',backgroundColor:'rgba(24,117,185,.08)',fill:true,tension:.35,borderWidth:2,pointRadius:4,pointBackgroundColor:'#1875b9'},
        {label:'Unit dibooking',data:CHART.dibooking,borderColor:'#1f9d50',backgroundColor:'transparent',tension:.35,borderWidth:2,pointRadius:4,pointBackgroundColor:'#1f9d50'}
      ]},
      options:{responsive:true,maintainAspectRatio:false,plugins:{legend:{position:'bottom',labels:{usePointStyle:true,boxWidth:8,padding:18}}},scales:{y:{beginAtZero:true,grid:{color:'#eef1f6'}},x:{grid:{display:false}}}} });
    new Chart(document.getElementById('chartCluster'), { type:'bar',
      data:{ labels:CHART.clusterLabels, datasets:[
        {label:'Realisasi',data:CHART.realisasi,backgroundColor:'#1875b9',borderRadius:6,barThickness:26},
        {label:'Target',data:CHART.target,backgroundColor:'#bcd8ee',borderRadius:6,barThickness:26}
      ]},
      options:{responsive:true,maintainAspectRatio:false,plugins:{legend:{position:'bottom',labels:{usePointStyle:true,boxWidth:8,padding:18}}},scales:{y:{beginAtZero:true,grid:{color:'#eef1f6'}},x:{grid:{display:false}}}} });
  }
</script>
@endpush
