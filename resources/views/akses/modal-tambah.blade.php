<div class="modal fade" id="modalTambahAkses" tabindex="-1" aria-labelledby="modalTambahAksesLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="form-tambah-alat">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahAksesLabel">Tambah Akses</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Akses</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary no-disable">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        $('#form-tambah-alat').on('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);

            $.ajax({
                url: "{{ route('create_akses') }}",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                    $('.no-disable').prop('disabled', true).text('Menyimpan...');
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: response.message || 'Akses berhasil ditambahkan.',
                        showConfirmButton: false,
                        timer: 1500
                    });

                    $('#form-tambah-alat')[0].reset();
                    $('#modalTambahAkses').modal('hide');

                    if (aksesTable) {
                        aksesTable.ajax.reload(); // harus setelah roleTable ter-inisialisasi
                    }
                },
                error: function(xhr) {
                    let errorText = 'Terjadi kesalahan.';

                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorText = xhr.responseJSON.message;
                    }

                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: errorText
                    });
                },
                complete: function() {
                    $('.no-disable').prop('disabled', false).text('Simpan');
                }
            });
        });
    });
</script>
