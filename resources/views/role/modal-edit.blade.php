<div class="modal fade" id="modalEditRole" tabindex="-1" aria-labelledby="modalEditRoleLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="overflow: visible;">
            <form id="form-edit-role">
                @csrf
                <input type="hidden" name="role_id" id="edit_role_id">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditRoleLabel">Tambah Akses</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Role</label>
                        <input type="text" class="form-control" id="edit_name" name="name" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Akses</label>
                        <div class="row">
                            @foreach ($akses as $item)
                                <div class="col-md-6 mb-2">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input akses-switch" type="checkbox" name="permission_id[]"
                                            value="{{ $item->id }}" id="akses-{{ $item->id }}">
                                        <label class="form-check-label" for="akses-{{ $item->id }}">
                                            {{ $item->name }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
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

<script>
    $(document).ready(function() {
        $('#form-edit-role').on('submit', function(e) {
            e.preventDefault();

            const formData = $(this).serialize();

            $.ajax({
                url: "{{ route('assign_role_permissions') }}",
                type: "POST",
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                    $('.no-disable').prop('disabled', true).text('Menyimpan...');
                },
                success: function(response) {
                    Swal.fire('Berhasil', response.message, 'success');
                    $('#modalEditRole').modal('hide');
                    if (typeof roleTable !== 'undefined') {
                        roleTable.ajax.reload();
                    }
                },
                error: function() {
                    Swal.fire('Gagal', 'Tidak bisa menyimpan akses.', 'error');
                },
                complete: function() {
                    $('.no-disable').prop('disabled', false).text('Simpan');
                }
            });
        });
    });
</script>
