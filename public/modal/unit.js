$(document).ready(function () {
    // ========== DataTable ==========
    if ($('#myTable').length) {
        window.unitTable = new DataTable('#myTable', {
            pageLength: 10,
            order: [],
            columnDefs: [{ orderable: false, targets: [0, -1] }],
            language: {
                search: 'Cari:',
                lengthMenu: 'Tampil _MENU_ data',
                info: 'Menampilkan _START_–_END_ dari _TOTAL_ unit',
                infoEmpty: 'Tidak ada data',
                infoFiltered: '(disaring dari _MAX_ total)',
                zeroRecords: 'Tidak ada unit yang cocok',
                paginate: { previous: 'Sebelumnya', next: 'Berikutnya' },
            },
        });
    }

    // ========== Filter: Cluster & Status ==========
    DataTable.ext.search.push(function (settings, data, dataIndex) {
        if (settings.nTable.id !== 'myTable') return true;

        const cluster = $('#filterCluster').val();
        const status = $('#filterStatus').val();
        const tr = settings.aoData[dataIndex].nTr;
        const rowCluster = tr.getAttribute('data-cluster') || '';
        const rowStatus = tr.getAttribute('data-status') || '';

        const matchCluster = !cluster || rowCluster === cluster;
        const matchStatus = !status || rowStatus === status;
        return matchCluster && matchStatus;
    });

    $('#filterCluster, #filterStatus').on('change', function () {
        if (window.unitTable) window.unitTable.draw();
    });

    $('#filterReset').on('click', function () {
        $('#filterCluster').val('');
        $('#filterStatus').val('');
        if (window.unitTable) window.unitTable.search('').draw();
    });

    // ========== Currency Formatter ==========
    function formatCurrency(value) {
        let raw = String(value).replace(/\D/g, '');
        if (raw === '') return '';
        return parseInt(raw, 10).toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    $('.currency').on('input', function () {
        $(this).val(formatCurrency($(this).val()));
    });

    $('form').on('submit', function () {
        $(this).find('.currency').each(function () {
            $(this).val($(this).val().replace(/\./g, ''));
        });
    });

    // ========== Modal Open/Close ==========
    $('#addBtn').click(() => $('#addModal').removeClass('hidden'));
    $('#closeAddModal').click(() => $('#addModal').addClass('hidden'));
    $('#closeModal').click(() => $('#editModal').addClass('hidden'));

    $(window).click((e) => {
        if (e.target === $('#addModal')[0]) $('#addModal').addClass('hidden');
        if (e.target === $('#editModal')[0]) $('#editModal').addClass('hidden');
    });

    // ========== Edit Button ==========
    $(document).on('click', '.editBtn', function () {
        const btn = $(this);
        $('#editKode').val(btn.data('kode'));
        $('#editClusterId').val(btn.data('cluster_id'));
        $('#editHouseTypeId').val(btn.data('house_type_id'));
        $('#editBlok').val(btn.data('blok'));
        $('#editNomor').val(btn.data('nomor'));
        $('#editHarga').val(formatCurrency(btn.data('harga')));
        $('#editDeliveryType').val(btn.data('delivery_type'));
        $('#editStatus').val(btn.data('status'));

        $('#editForm').attr('action', `/units/${btn.data('kode')}`);
        $('#editModal').removeClass('hidden');
    });

    // ========== Delete Confirm ==========
    $(document).on('click', '.delete-confirm', function (e) {
        e.preventDefault();
        const form = $(this).closest('form');
        Swal.fire({
            title: 'Hapus unit ini?',
            text: 'Tindakan ini tidak dapat dibatalkan.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonText: 'Batal',
            confirmButtonText: 'Ya, hapus!',
        }).then((result) => {
            if (result.isConfirmed) form.submit();
        });
    });
});
