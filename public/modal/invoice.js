$(document).ready(function () {
    // ========== DataTable ==========
    if ($('#myTable').length) {
        window.invoiceTable = new DataTable('#myTable', {
            pageLength: 10,
            order: [],
            columnDefs: [{ orderable: false, targets: [0, -1] }],
            language: {
                search: 'Cari:',
                lengthMenu: 'Tampil _MENU_ data',
                info: 'Menampilkan _START_–_END_ dari _TOTAL_ invoice',
                infoEmpty: 'Tidak ada data',
                infoFiltered: '(disaring dari _MAX_ total)',
                zeroRecords: 'Tidak ada invoice yang cocok',
                paginate: { previous: 'Sebelumnya', next: 'Berikutnya' },
            },
        });
    }

    // ========== Filter: Status ==========
    DataTable.ext.search.push(function (settings, data, dataIndex) {
        if (settings.nTable.id !== 'myTable') return true;
        const status = $('#filterStatus').val();
        const tr = settings.aoData[dataIndex].nTr;
        return !status || (tr.getAttribute('data-status') || '') === status;
    });

    $('#filterStatus').on('change', function () {
        if (window.invoiceTable) window.invoiceTable.draw();
    });

    $('#filterReset').on('click', function () {
        $('#filterStatus').val('');
        if (window.invoiceTable) window.invoiceTable.search('').draw();
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
    $(window).click((e) => {
        if (e.target === $('#addModal')[0]) $('#addModal').addClass('hidden');
    });

    // ========== Delete Confirm ==========
    $(document).on('click', '.delete-confirm', function (e) {
        e.preventDefault();
        const form = $(this).closest('form');
        Swal.fire({
            title: 'Hapus item ini?',
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
