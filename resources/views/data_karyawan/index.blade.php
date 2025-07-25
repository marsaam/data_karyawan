@extends('templates.index')

@section('title', 'Dashboard')

@section('content')
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <!-- Page pre-title -->
                <div class="page-pretitle">
                    Master
                </div>
                <h2 class="page-title">
                    Data Karyawan
                </h2>
            </div>
            <!-- Page title actions -->
            @can('create karyawan')
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="#" class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal"
                            data-bs-target="#modalTambahKaryawan">
                            <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 5l0 14" />
                                <path d="M5 12l14 0" />
                            </svg>
                            Tambah Karyawan
                        </a>
                    </div>
                </div>
            @endcan
        </div>
    </div>
    <br>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-6">
                    <div class="mb-3">
                        <label for="">Filter Jenis Kelamin</label>
                        <select class="form-select" id="filterJenisKelamin">
                            <option value="" selected>-- Pilih --</option>
                            <option value="1">Laki-laki</option>
                            <option value="2">Perempuan</option>
                        </select>
                    </div>
                </div>
                <div class="col-6">
                    <div class="mb-3">
                        <label for="">Filter Jenjang Pendidikan</label>
                        <select class="form-select" id="filterJenjangPendidikan">
                            <option value="" selected>-- Pilih --</option>
                            <option value="1">SMA/K</option>
                            <option value="2">D3</option>
                            <option value="3">D4/S1</option>
                            <option value="4">S2</option>
                            <option value="5">S3</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="card">
        <div class="card-body">
            @can('view karyawan')
                <table class="table table-vcenter card-table" id="karyawanTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Karyawan</th>
                            <th>Nomor Induk Karyawan</th>
                            <th>Tempat, Tanggal Lahir</th>
                            <th>Jenis Kelamin</th>
                            <th>Foto Karyawan</th>
                            <th>Riwayat Pendidikan</th>
                            <th>Anggota Keluarga</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            @endcan
        </div>
    </div>
    <br>

    @include('data_karyawan.modal-edit')
    @include('data_karyawan.modal-tambah')

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        var karyawanTable;

        $(document).ready(function() {
            karyawanTable = $('#karyawanTable').DataTable({
                "scrollX": true,
                "autoWidth": false,
                dom: "<'row mb-3'<'col-md-3'l><'col-md-6 d-flex align-items-center justify-content-center'B><'col-md-3'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row mt-2'<'col-sm-5'i><'col-sm-7'p>>",
                "lengthChange": true, // agar dropdown jumlah data per halaman muncul
                "lengthMenu": [10, 20, 30, 50, 100], // nilai dropdown jumlah per halaman
                "pageLength": 10, // default jumlah data per halaman
                buttons: [
                    'copy',
                    'excel',
                    @can('ekspor PDF karyawan')
                          {
                                extend: 'pdf',
                                title: 'Daftar Karyawan',
                            }, {
                                extend: 'print',
                                title: 'Daftar Karyawan',
                            },
                    @endcan

                    'colvis'
                ],

                "ordering": false,
                "order": [
                    [0, "desc"]
                ],
                "ajax": {
                    "url": "/getKaryawan",
                    "type": "GET",
                    "dataSrc": "data",
                    data: function(d) {
                        d.jenis_kelamin = $('#filterJenisKelamin').val();
                        d.jenjang = $('#filterJenjangPendidikan').val();
                    }
                },
                "columns": [{
                        data: null,
                        render: function(data, type, row, meta) {
                            return meta.row + 1;
                        }
                    },
                    {
                        data: 'nama_lengkap'
                    },
                    {
                        data: 'no_karyawan'
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            if (!row.tanggal_lahir) return row.tempat_lahir || '-';

                            const tanggal = new Date(row.tanggal_lahir);
                            const day = String(tanggal.getDate()).padStart(2, '0');
                            const month = String(tanggal.getMonth() + 1).padStart(2,
                                '0'); // bulan dimulai dari 0
                            const year = tanggal.getFullYear();

                            return `${row.tempat_lahir}, ${day}-${month}-${year}`;
                        }
                    },
                    {
                        data: 'jenis_kelamin',
                        render: function(data, type, row) {
                            return data === '1' ? 'L' : 'P';
                        }
                    },
                    {
                        data: 'foto',
                        render: function(data, type, row) {
                            return '<img src="' + data +
                                '" alt="Foto Karyawan" style="width: 50px; height: 50px;">';
                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            const jenjangLabel = {
                                '1': 'SMA/K',
                                '2': 'D3',
                                '3': 'D4/S1',
                                '4': 'S2',
                                '5': 'S3'
                            };

                            if (!row.pendidikans || row.pendidikans.length === 0) {
                                return '-';
                            }

                            return row.pendidikans.map(p => jenjangLabel[p.jenjang] || p.jenjang)
                                .join(', ');
                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            if (!row.keluargas || row.keluargas.length === 0) {
                                return '-';
                            }

                            const hubunganLabel = {
                                '1': 'Ayah',
                                '2': 'Ibu',
                                '3': 'Suami',
                                '4': 'Istri',
                                '5': 'Anak',
                                '6': 'Saudara',
                                '7': 'Lainnya'
                            };

                            return row.keluargas
                                .map(k =>
                                    `${k.nama_keluarga} - ${hubunganLabel[k.hubungan] || 'Tidak diketahui'}`
                                )
                                .join('<br>');
                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return `
                            @can('delete karyawan')
        <button class="btn btn-danger btn-sm me-2 mt-2" onclick="deleteKaryawan('${row.id}')">Hapus</button>
        @endcan
        @can('edit karyawan')
        <button class="btn btn-success btn-sm me-2 mt-2" onclick="editKaryawan('${row.id}')">Edit</button>
        @endcan
      `;
                        }
                    }
                ],
                "columnDefs": [{
                    targets: [4, 5, 6, 7], // sesuai jumlah kolom yang ada
                    visible: false
                }]
            });
        });
        $('#filterJenisKelamin, #filterJenjangPendidikan').on('change', function() {
            $('#karyawanTable').DataTable().ajax.reload();
        });
    </script>
    <script>
        function deleteKaryawan(id) {
            Swal.fire({
                title: 'Hapus Karyawan?',
                text: 'Yakin ingin menghapus karyawan ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('delete_karyawan') }}",
                        type: "POST",
                        data: {
                            id: id,
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        beforeSend: function() {
                            Swal.fire({
                                title: 'Menghapus...',
                                allowOutsideClick: false,
                                didOpen: () => {
                                    Swal.showLoading();
                                }
                            });
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: response.message,
                                timer: 1500,
                                showConfirmButton: false
                            });

                            if (typeof karyawanTable !== 'undefined') {
                                karyawanTable.ajax.reload();
                            }
                        },
                        error: function(xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: xhr.responseJSON?.message ||
                                    'Terjadi kesalahan saat menghapus.'
                            });
                        }
                    });
                }
            });
        }
    </script>
    <script>
        function editKaryawan(karyawanId) {
            $.ajax({
                url: `/karyawan/${karyawanId}`,
                type: 'GET',
                success: function(response) {
                    const karyawan = response.data;

                    // Isi form utama
                    $('#edit_nama_lengkap').val(karyawan.nama_lengkap);
                    $('#edit_no_karyawan').val(karyawan.no_karyawan);
                    $('#edit_tempat_lahir').val(karyawan.tempat_lahir);
                    $('#edit_tanggal_lahir').val(karyawan.tanggal_lahir);
                    $('#edit_jenis_kelamin').val(karyawan.jenis_kelamin);
                    $('#edit_karyawan_id').val(karyawan.id);
                    // Tampilkan foto jika ada
                    if (karyawan.foto) {
                        $('#edit_preview-foto')
                            .attr('src', '/' + karyawan.foto) // pastikan ada / di depannya agar URL benar
                            .css('display', 'block');
                    } else {
                        $('#edit_preview-foto')
                            .attr('src', '#')
                            .css('display', 'none');
                    }


                    // Reset wrapper pendidikan & keluarga
                    $('#edit_wrapperPendidikan').html('');
                    $('#edit_wrapperKeluarga').html('');

                    // Tampilkan data pendidikan
                    karyawan.pendidikans.forEach((pendidikan, index) => {
                        const html = `
                    <div class="border p-3 mb-3 rounded bg-light position-relative pendidikan-item">
                        <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2 btn-hapus-pendidikan">&times;</button>
                        <div class="mb-3">
                            <label>Jenjang Pendidikan</label>
                            <select name="pendidikan[${index}][jenjang]" class="form-control">
                                <option value="">-- Pilih --</option>
                                <option value="1" ${pendidikan.jenjang == 1 ? 'selected' : ''}>SMA/K</option>
                                <option value="2" ${pendidikan.jenjang == 2 ? 'selected' : ''}>D3</option>
                                <option value="3" ${pendidikan.jenjang == 3 ? 'selected' : ''}>D4/S1</option>
                                <option value="4" ${pendidikan.jenjang == 4 ? 'selected' : ''}>S2</option>
                                <option value="5" ${pendidikan.jenjang == 5 ? 'selected' : ''}>S3</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label>Nama Sekolah/Institusi</label>
                            <input type="text" name="pendidikan[${index}][institusi]" class="form-control" value="${pendidikan.institusi}">
                        </div>
                    </div>
                `;
                        $('#edit_wrapperPendidikan').append(html);
                    });

                    // Tampilkan data keluarga
                    karyawan.keluargas.forEach((keluarga, index) => {
                        const html = `
                    <div class="border p-3 mb-3 rounded bg-light position-relative keluarga-item">
                        <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2 btn-hapus-keluarga">&times;</button>
                        <div class="mb-3">
                            <label>Nama Anggota Keluarga</label>
                            <input type="text" name="keluarga[${index}][nama]" class="form-control" value="${keluarga.nama_keluarga}">
                        </div>
                        <div class="mb-3">
                            <label>Hubungan</label>
                            <select name="keluarga[${index}][hubungan]" class="form-control">
                                <option value="">-- Pilih --</option>
                                <option value="1" ${keluarga.hubungan == 1 ? 'selected' : ''}>Ayah</option>
                                <option value="2" ${keluarga.hubungan == 2 ? 'selected' : ''}>Ibu</option>
                                <option value="3" ${keluarga.hubungan == 3 ? 'selected' : ''}>Suami</option>
                                <option value="4" ${keluarga.hubungan == 4 ? 'selected' : ''}>Istri</option>
                                <option value="5" ${keluarga.hubungan == 5 ? 'selected' : ''}>Anak</option>
                                <option value="6" ${keluarga.hubungan == 6 ? 'selected' : ''}>Saudara</option>
                                <option value="7" ${keluarga.hubungan == 7 ? 'selected' : ''}>Lainnya</option>
                            </select>
                        </div>
                    </div>
                `;
                        $('#edit_wrapperKeluarga').append(html);
                    });

                    $('#modalEditKaryawan').modal('show');
                },
                error: function() {
                    Swal.fire('Gagal', 'Tidak bisa memuat data user.', 'error');
                }
            });
        }
    </script>
@endsection
