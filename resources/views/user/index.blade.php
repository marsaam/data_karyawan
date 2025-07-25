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
                    User
                </h2>
            </div>
            <!-- Page title actions -->
            @can('create user')
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="#" class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal"
                            data-bs-target="#modalTambahUser">
                            <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 5l0 14" />
                                <path d="M5 12l14 0" />
                            </svg>
                            Tambah User
                        </a>
                    </div>
                </div>
            @endcan
        </div>
    </div>
    <br>

    <div class="card">
        <div class="card-body">
            @can('view user')
                <table class="table table-vcenter card-table" id="userTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            {{-- <th>Role</th> --}}
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            @endcan
        </div>
        <br>
        @include('user.modal-tambah')
        @include('user.modal-edit')

        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            let userTable;

            $(document).ready(function() {
                userTable = $('#userTable').DataTable({
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
                        @can('ekspor PDF user')
                            {
                                extend: 'pdf',
                                title: 'Daftar User',
                            }, {
                                extend: 'print',
                                title: 'Daftar User',
                            },
                        @endcan

                        'colvis'
                    ],

                    "ordering": false,
                    "order": [
                        [0, "desc"]
                    ],
                    "ajax": {
                        "url": "/getUser",
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
                            data: 'email'
                        },
                        // {
                        //     data: null,
                        //     render: function(data, type, row) {
                        //         return row.role_ref && row.role_ref.name ? row.role_ref.name : '-';
                        //     }
                        // }, // atau sesuaikan jika nested seperti row.role.name
                        {
                            data: null,
                            render: function(data, type, row) {
                                return `
                                @can('delete user')
        <button class="btn btn-danger btn-sm" onclick="deleteUser('${row.id}')">Hapus</button>
        @endcan
        @can('edit user')
        <button class="btn btn-success btn-sm" onclick="editUser('${row.id}')">Edit</button>
        @endcan
      `;
                            }
                        }
                    ],

                });
            });
        </script>

        <script>
            function deleteUser(id) {
                Swal.fire({
                    title: 'Hapus User?',
                    text: 'Yakin ingin menghapus user ini?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Hapus',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('delete_user') }}",
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

                                if (typeof userTable !== 'undefined') {
                                    userTable.ajax.reload();
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
            function editUser(userId) {
                $.ajax({
                    url: `/user/${userId}`,
                    type: 'GET',
                    success: function(response) {
                        console.log(response);
                        const user = response.data;

                        $('#edit_name').val(user.name);
                        $('#edit_email').val(user.email);
                        $('#edit_password').val(''); // kosongkan, jangan tampilkan password
                        $('#edit_role').val(user.role);
                        $('#edit_user_id').val(user.id);

                        $('#modalEditUser').modal('show');
                    },
                    error: function() {
                        Swal.fire('Gagal', 'Tidak bisa memuat data user.', 'error');
                    }
                });
            }
        </script>

    @endsection
