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
                info: 'Menampilkan _START_–_END_ dari _TOTAL_ pembeli',
                infoEmpty: 'Tidak ada data',
                infoFiltered: '(disaring dari _MAX_ total)',
                zeroRecords: 'Tidak ada pembeli yang cocok',
                paginate: { previous: 'Sebelumnya', next: 'Berikutnya' },
            },
        });
    }

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
        $('#editKtp').val(btn.data('ktp'));
        $('#editNpwp').val(btn.data('npwp'));
        $('#editTelepon').val(btn.data('telepon'));
        $('#editEmail').val(btn.data('email'));
        $('#editAlamat').val(btn.data('alamat'));

        $('#editForm').attr('action', `/buyers/${btn.data('id')}`);
        $('#editModal').removeClass('hidden');
    });

    // ========== Delete Confirm ==========
    $(document).on('click', '.delete-confirm', function (e) {
        e.preventDefault();
        const form = $(this).closest('form');
        Swal.fire({
            title: 'Hapus pembeli ini?',
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
