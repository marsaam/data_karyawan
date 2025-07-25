<div class="modal fade" id="modalTambahKaryawan" tabindex="-1" aria-labelledby="modalTambahKaryawanLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="form-tambah-alat">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahKaryawanLabel">Tambah Karyawan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="nama_karyawan" class="form-label">Nama Karyawan</label>
                                <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="nomor_induk_karyawan" class="form-label">Nomor Induk Karyawan</label>
                                <input type="text" class="form-control" id="no_karyawan" name="no_karyawan" required>
                            </div>
                            <div class="mb-3">
                                <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                                <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir"
                                    required>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="mb-3">
                                <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                <select class="form-select" id="jenis_kelamin" name="jenis_kelamin" required>
                                    <option value="" disabled selected>-- Pilih --</option>
                                    <option value="1">Laki-laki</option>
                                    <option value="2">Perempuan</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Foto Diri</label>
                                <input type="file" name="foto" id="foto" class="form-control">
                                <br>
                                <img id="preview-foto" src="#" alt="Preview Foto"
                                    style="display: none; max-width: 150px; max-height: 150px; border-radius: 8px;">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <button type="button" class="btn btn-success mt-2 me-2 mb-2 w-100"
                                    id="tambahPendidikan">
                                    Tambah Pendidikan
                                </button>
                                <div id="wrapperPendidikan"></div>
                            </div>
                            <div class="col-6">
                                <button type="button" class="btn btn-success mt-2 me-2 mb-2 w-100"
                                    id="tambahAnggotaKeluarga">
                                    Tambah Anggota Keluarga
                                </button>
                                <div id="wrapperKeluarga"></div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary no-disable">Simpan</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById('foto').addEventListener('change', function(event) {
        const file = event.target.files[0];

        if (file) {
            const reader = new FileReader();

            reader.onload = function(e) {
                const preview = document.getElementById('preview-foto');
                preview.src = e.target.result;
                preview.style.display = 'block';
            }

            reader.readAsDataURL(file);
        }
    });
    // Reset preview saat form di-reset
    document.getElementById('form-tambah-alat').addEventListener('reset', function() {
        const preview = document.getElementById('preview-foto');
        preview.src = '';
        preview.style.display = 'none';
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        let pendidikanIndex = 0;
        let keluargaIndex = 0;

        document.getElementById('tambahPendidikan').addEventListener('click', function (e) {
            e.preventDefault();
            pendidikanIndex++;
            const wrapper = document.getElementById('wrapperPendidikan');

            const html = `
            <div class="border p-3 mb-3 rounded bg-light position-relative pendidikan-item">
                <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2 btn-hapus-pendidikan">&times;</button>
                <div class="mb-3">
                    <label>Jenjang Pendidikan</label>
                    <select name="pendidikan[${pendidikanIndex}][jenjang]" class="form-control">
                        <option value="">-- Pilih --</option>
                        <option value="1">SMA/K</option>
                        <option value="2">D3</option>
                        <option value="3">D4/S1</option>
                        <option value="4">S2</option>
                        <option value="5">S3</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label>Nama Sekolah/Institusi</label>
                    <input type="text" name="pendidikan[${pendidikanIndex}][institusi]" class="form-control">
                </div>
            </div>
            `;
            wrapper.insertAdjacentHTML('beforeend', html);
        });

        document.getElementById('tambahAnggotaKeluarga').addEventListener('click', function (e) {
            e.preventDefault();
            keluargaIndex++;
            const wrapper = document.getElementById('wrapperKeluarga');

            const html = `
            <div class="border p-3 mb-3 rounded bg-light position-relative keluarga-item">
                <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2 btn-hapus-keluarga">&times;</button>
                <div class="mb-3">
                    <label>Nama Anggota Keluarga</label>
                    <input type="text" name="keluarga[${keluargaIndex}][nama]" class="form-control">
                </div>
                <div class="mb-3">
                    <label>Hubungan</label>
                    <select name="keluarga[${keluargaIndex}][hubungan]" class="form-control">
                        <option value="">-- Pilih --</option>
                        <option value="1">Ayah</option>
                        <option value="2">Ibu</option>
                        <option value="3">Suami</option>
                        <option value="4">Istri</option>
                        <option value="5">Anak</option>
                        <option value="6">Saudara</option>
                        <option value="7">Lainnya</option>
                    </select>
                </div>
            </div>
            `;
            wrapper.insertAdjacentHTML('beforeend', html);
        });

        // Delegasi event: hapus pendidikan
        document.getElementById('wrapperPendidikan').addEventListener('click', function (e) {
            if (e.target.classList.contains('btn-hapus-pendidikan')) {
                e.target.closest('.pendidikan-item').remove();
            }
        });

        // Delegasi event: hapus keluarga
        document.getElementById('wrapperKeluarga').addEventListener('click', function (e) {
            if (e.target.classList.contains('btn-hapus-keluarga')) {
                e.target.closest('.keluarga-item').remove();
            }
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#form-tambah-alat').on('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);

            $.ajax({
                url: "{{ route('create_karyawan') }}",
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
                        text: response.message || 'Karyawan berhasil ditambahkan.',
                        showConfirmButton: false,
                        timer: 1500
                    });

                    $('#form-tambah-alat')[0].reset();
                    $('#modalTambahKaryawan').modal('hide');

                    if (karyawanTable) {
                        karyawanTable.ajax
                            .reload(); // harus setelah karyawanTable ter-inisialisasi
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
