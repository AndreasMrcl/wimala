$(document).ready(function () {
    // ========== DataTable ==========
    if ($('#myTable').length) {
        new DataTable('#myTable', {
            pageLength: 10,
            order: [],
            columnDefs: [{ orderable: false, targets: [0, -1] }],
            language: {
                search: 'Cari:',
                lengthMenu: 'Tampil _MENU_ data',
                info: 'Menampilkan _START_–_END_ dari _TOTAL_ tipe',
                infoEmpty: 'Tidak ada data',
                infoFiltered: '(disaring dari _MAX_ total)',
                zeroRecords: 'Tidak ada tipe yang cocok',
                paginate: { previous: 'Sebelumnya', next: 'Berikutnya' },
            },
        });
    }

    // ========== Currency Formatter ==========
    function formatCurrency(value) {
        let raw = String(value).replace(/\D/g, '');
        if (raw === '') return '';
        return parseInt(raw, 10).toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    $('.currency').on('input', function () {
        $(this).val(formatCurrency($(this).val()));
    });

    // Hapus titik sebelum submit agar lolos validasi numeric
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
        $('#editNama').val(btn.data('nama'));
        $('#editLuasTanah').val(btn.data('luas_tanah'));
        $('#editLuasBangunan').val(btn.data('luas_bangunan'));
        $('#editKamarTidur').val(btn.data('kamar_tidur'));
        $('#editKamarMandi').val(btn.data('kamar_mandi'));
        $('#editHargaDasar').val(formatCurrency(btn.data('harga_dasar')));

        $('#editForm').attr('action', `/tipe/${btn.data('id')}`);
        $('#editModal').removeClass('hidden');
    });

    // ========== Delete Confirm ==========
    $(document).on('click', '.delete-confirm', function (e) {
        e.preventDefault();
        const form = $(this).closest('form');
        Swal.fire({
            title: 'Hapus tipe ini?',
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
