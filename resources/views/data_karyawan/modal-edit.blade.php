<div class="modal fade" id="modalEditKaryawan" tabindex="-1" aria-labelledby="modalEditKaryawanLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="overflow: visible;">
            <form id="form-edit-karyawan" enctype="multipart/form-data">
                <input type="hidden" name="karyawan_id" id="edit_karyawan_id">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditKaryawanLabel">Edit Karyawan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="nama_karyawan" class="form-label">Nama Karyawan</label>
                                <input type="text" class="form-control" id="edit_nama_lengkap" name="nama_lengkap"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="nomor_induk_karyawan" class="form-label">Nomor Induk Karyawan</label>
                                <input type="text" class="form-control" id="edit_no_karyawan" name="no_karyawan"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                                <input type="text" class="form-control" id="edit_tempat_lahir" name="tempat_lahir"
                                    required>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="mb-3">
                                <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                <input type="date" class="form-control" id="edit_tanggal_lahir" name="tanggal_lahir"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                <select class="form-select" id="edit_jenis_kelamin" name="jenis_kelamin" required>
                                    <option value="" disabled selected>-- Pilih --</option>
                                    <option value="1">Laki-laki</option>
                                    <option value="2">Perempuan</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Foto Diri</label>
                                <input type="file" name="foto" id="edit_foto" class="form-control">
                                <br>
                                <img id="edit_preview-foto" src="#" alt="Preview Foto"
                                    style="display: none; max-width: 150px; max-height: 150px; border-radius: 8px;">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <button type="button" class="btn btn-success mt-2 me-2 mb-2 w-100"
                                    id="edit_tambahPendidikan">
                                    Tambah Pendidikan
                                </button>
                                <div id="edit_wrapperPendidikan"></div>
                            </div>
                            <div class="col-6">
                                <button type="button" class="btn btn-success mt-2 me-2 mb-2 w-100"
                                    id="edit_tambahAnggotaKeluarga">
                                    Tambah Anggota Keluarga
                                </button>
                                <div id="edit_wrapperKeluarga"></div>
                            </div>
                        </div>
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
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    document.getElementById('edit_foto').addEventListener('change', function(event) {
        const file = event.target.files[0];

        if (file) {
            const reader = new FileReader();

            reader.onload = function(e) {
                const preview = document.getElementById('edit_preview-foto');
                preview.src = e.target.result;
                preview.style.display = 'block';
            }

            reader.readAsDataURL(file);
        }
    });
    // Reset preview saat form di-reset
    document.getElementById('form-tambah-alat').addEventListener('reset', function() {
        const preview = document.getElementById('edit_preview-foto');
        preview.src = '';
        preview.style.display = 'none';
    });
</script>
<script>
    $('#form-edit-karyawan').on('submit', function(e) {
        e.preventDefault();

        const form = $('#form-edit-karyawan')[0];
        const formData = new FormData(form);

        // optional: debug isian formData
        // for (let pair of formData.entries()) {
        //     console.log(pair[0]+ ': ' + pair[1]);
        // }

        $.ajax({
            url: "{{ route('update_karyawan') }}",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function() {
                $('.no-disable').prop('disabled', true).text('Menyimpan...');
            },
            success: function(response) {
                Swal.fire('Berhasil', response.message, 'success');
                $('#modalEditKaryawan').modal('hide');
                if (typeof karyawanTable !== 'undefined') {
                    karyawanTable.ajax.reload();
                }
            },
            error: function(xhr) {
                let errorText = 'Gagal menyimpan.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorText = xhr.responseJSON.message;
                }
                Swal.fire('Error', errorText, 'error');
            },
            complete: function() {
                $('.no-disable').prop('disabled', false).text('Simpan');
            }
        });
    });
</script>
