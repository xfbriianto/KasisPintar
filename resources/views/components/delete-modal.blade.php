<!-- Modal Konfirmasi Hapus -->
<div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteConfirmModalLabel">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus data ini?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Hapus</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Tangkap semua tombol delete
        const deleteButtons = document.querySelectorAll('.delete-btn');
        const deleteConfirmModal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));
        const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
        let currentDeleteForm = null;

        deleteButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Temukan form terdekat
                currentDeleteForm = this.closest('.delete-form');
                
                // Tampilkan modal konfirmasi
                deleteConfirmModal.show();
            });
        });

        // Konfirmasi delete
        confirmDeleteBtn.addEventListener('click', function() {
            if (currentDeleteForm) {
                currentDeleteForm.submit();
            }
        });
    });
</script>
@endpush