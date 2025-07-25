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
                    Role
                </h2>
            </div>
            <!-- Page title actions -->
            @can('create role')
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    <a href="#" class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal"
                        data-bs-target="#modalTambahRole">
                        <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 5l0 14" />
                            <path d="M5 12l14 0" />
                        </svg>
                        Tambah Role
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
            <table class="table table-vcenter card-table" id="roleTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Role</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
            @endcan
        </div>
        <br>
        @include('role.modal-tambah')
        @include('role.modal-edit')
        {{-- @include('role.assign-akses') --}}
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            let roleTable;

            $(document).ready(function() {
                roleTable = $('#roleTable').DataTable({
                    "scrollX": true,
                    "autoWidth": false,
                    "ordering": false,
                    "order": [
                        [0, "desc"]
                    ],
                    "ajax": {
                        "url": "/getRole",
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
                                return `
                                @can('delete role')
            <button class="btn btn-danger btn-sm" onclick="deleteRole('${row.id}')">Hapus</button>
            @endcan
             @can('edit role')
            <button class="btn btn-success btn-sm" onclick="editRole('${row.id}')">Akses</button>
             @endcan
        `;
                            }
                        }
                    ]
                });
            });
        </script>
        <script>
            function deleteRole(id) {
                Swal.fire({
                    title: 'Hapus Role?',
                    text: 'Yakin ingin menghapus role ini?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Hapus',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('delete_role') }}",
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

                                if (typeof roleTable !== 'undefined') {
                                    roleTable.ajax.reload();
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
            function editRole(roleId) {
                $.ajax({
                    url: `/role/${roleId}`,
                    type: 'GET',
                    success: function(response) {
                          console.log(response); // Cek struktur data

                        const role = response.data;
                        const akses = response.akses;

                        $('#edit_name').val(role.name);
                        $('#edit_role_id').val(role.id);

                        // Uncheck semua dulu
                        $('.akses-switch').prop('checked', false);

                        // Tandai yg punya akses
                        role.permissions.forEach(function(p) {
                            $(`#akses-${p.id}`).prop('checked', true);
                        });

                        $('#modalEditRole').modal('show');
                    },
                    error: function() {
                        Swal.fire('Gagal', 'Tidak bisa memuat data role.', 'error');
                    }
                });
            }
        </script>

    @endsection
