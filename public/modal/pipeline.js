$(document).ready(function () {
    let stageFilter = '';

    // ========== DataTable ==========
    if ($('#myTable').length) {
        window.pipelineTable = new DataTable('#myTable', {
            pageLength: 10,
            order: [],
            columnDefs: [{ orderable: false, targets: [0, 5, -1] }],
            language: {
                search: 'Cari:',
                lengthMenu: 'Tampil _MENU_ data',
                info: 'Menampilkan _START_–_END_ dari _TOTAL_ transaksi',
                infoEmpty: 'Tidak ada data',
                infoFiltered: '(disaring dari _MAX_ total)',
                zeroRecords: 'Tidak ada transaksi yang cocok',
                paginate: { previous: 'Sebelumnya', next: 'Berikutnya' },
            },
        });
    }

    // ========== Filter by stage (chips) ==========
    DataTable.ext.search.push(function (settings, data, dataIndex) {
        if (settings.nTable.id !== 'myTable') return true;
        if (stageFilter === '') return true;

        const tr = settings.aoData[dataIndex].nTr;
        return (tr.getAttribute('data-stage') || '') === stageFilter;
    });

    $('.stage-chip').on('click', function () {
        $('.stage-chip').removeClass('active');
        $(this).addClass('active');
        stageFilter = $(this).attr('data-stage') || '';
        if (window.pipelineTable) window.pipelineTable.draw();
    });

    // ========== Create Transaction Modal ==========
    $('#addBtn').click(() => $('#addModal').removeClass('hidden'));
    $('#closeAddModal').click(() => $('#addModal').addClass('hidden'));
    $(window).click((e) => {
        if (e.target === $('#addModal')[0]) $('#addModal').addClass('hidden');
    });

    // Tampilkan field bank hanya saat KPR
    function toggleBankField() {
        const isKpr = $('#paymentMethod').val() === 'kpr';
        $('#bankField').toggleClass('hidden', !isKpr);
    }
    $('#paymentMethod').on('change', toggleBankField);
    toggleBankField();
});
