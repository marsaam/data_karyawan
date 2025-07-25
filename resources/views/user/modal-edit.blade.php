<div class="modal fade" id="modalEditUser" tabindex="-1" aria-labelledby="modalEditUserLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="overflow: visible;">
            <form id="form-edit-user">
                <input type="hidden" name="user_id" id="edit_user_id">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditUserLabel">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="edit_name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="edit_email" name="email"
                            autocomplete="new-email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="edit_password" name="password"
                            autocomplete="new-password">
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label">User</label>
                        <select name="role" id="edit_role" class="form-control">
                            <option value="">-- Pilih --</option>
                            @foreach ($roles as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
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
    $(document).ready(function() {
        $('.select-akses').select2({
            placeholder: "-- Pilih --",
            allowClear: true,
            width: '100%',
            dropdownParent: $('#modalEditUser') // ⬅️ ini penting!
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#form-edit-user').on('submit', function(e) {
            e.preventDefault();

            const formData = $(this).serialize();

            $.ajax({
                url: "{{ route('update_user') }}",
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
                    $('#modalEditUser').modal('hide');
                    if (typeof userTable !== 'undefined') {
                        userTable.ajax.reload();
                    }
                },
                error: function() {
                    Swal.fire('Gagal', 'Tidak bisa menyimpan perubahan.', 'error');
                },
                complete: function() {
                    $('.no-disable').prop('disabled', false).text('Simpan');
                }
            });
        });
    });
</script>
