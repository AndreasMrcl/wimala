// Wimala Land prototype - interaksi ringan (DataTables, menu, modal)
$(function () {
  // DataTables untuk semua tabel ber-class .dt
  if (window.jQuery && $.fn.dataTable) {
    $('.dt').each(function () {
      $(this).DataTable({
        autoWidth: false,
        order: [],
        pageLength: 10,
        lengthMenu: [10, 25, 50],
        columnDefs: [{ orderable: false, targets: [-1] }],
        language: {
          search: 'Cari:',
          searchPlaceholder: 'ketik untuk menyaring...',
          lengthMenu: '_MENU_ data per halaman',
          info: 'Menampilkan _START_\u2013_END_ dari _TOTAL_ data',
          infoEmpty: 'Tidak ada data',
          zeroRecords: 'Tidak ditemukan',
          paginate: { previous: 'Sebelumnya', next: 'Berikutnya' }
        }
      });
    });
  }

  // Buka/tutup grup menu di sidebar
  document.querySelectorAll('.grp-parent[data-group]').forEach(function (p) {
    p.addEventListener('click', function () {
      var sub = document.getElementById(p.getAttribute('data-group'));
      var open = p.classList.toggle('open');
      if (sub) sub.classList.toggle('show', open);
    });
  });
});

// Modal Tipe Rumah (tampilan saja, tidak menyimpan)
function openTipeModal(btn) {
  var m = document.getElementById('modalTipe');
  if (!m) return;
  var d = btn ? btn.dataset : {};
  setVal('m_nama', d.nama || '');
  setVal('m_lt', d.lt || '');
  setVal('m_lb', d.lb || '');
  setVal('m_kt', d.kt || '');
  setVal('m_km', d.km || '');
  setVal('m_harga', d.harga || '');
  document.getElementById('mTitle').textContent = btn ? 'Ubah Tipe Rumah' : 'Tambah Tipe Rumah';
  m.classList.add('show');
}
function closeTipe() {
  var m = document.getElementById('modalTipe');
  if (m) m.classList.remove('show');
}
function setVal(id, v) {
  var e = document.getElementById(id);
  if (e) e.value = v;
}
