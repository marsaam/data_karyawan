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
                    Akses
                </h2>
            </div>
            @can('create role')
            <!-- Page title actions -->
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    <a href="#" class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal"
                        data-bs-target="#modalTambahAkses">
                        <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 5l0 14" />
                            <path d="M5 12l14 0" />
                        </svg>
                        Tambah Akses
                    </a>
                </div>
            </div>
            @endcan
        </div>
    </div>
    <br>

    <div class="card">
        <div class="card-body">
            @can('view role')
            <table class="table table-vcenter card-table" id="aksesTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Akses</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
            @endcan
        </div>
        <br>
        @include('akses.modal-tambah')
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            let aksesTable;

            $(document).ready(function() {
                aksesTable = $('#aksesTable').DataTable({
                    "scrollX": true,
                    "autoWidth": false,
                    "ordering": false,
                    "order": [
                        [0, "desc"]
                    ],
                    "ajax": {
                        "url": "/getAkses",
                        "type": "GET",
                        "dataSrc": "data"
                    },
                    "columns": [{
                            data: null,
                            render: function(data, type, row, meta) {
                                return meta.row + 1;
                            }
                        },
                        {
                            data: 'name'
                        },
                        {
                            data: null,
                            render: function(data, type, row) {
                                @can('edit role')
                                return `<button class="btn btn-danger btn-sm" onclick="deleteAkses('${row.id}')">Hapus</button>`;
                                @endcan
                            }
                        }
                    ]
                });
            });
        </script>
        <script>
            function deleteAkses(id) {
                Swal.fire({
                    title: 'Hapus Akses?',
                    text: 'Yakin ingin menghapus akses ini?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Hapus',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('delete_akses') }}",
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

                                if (typeof aksesTable !== 'undefined') {
                                    aksesTable.ajax.reload();
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

    @endsection
