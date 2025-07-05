<!-- Tambahkan toastr dan jQuery jika belum ada -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<div class="card">
    <div class="card-header bg-dark text-white">
        <h5 class="m-0"><i class="fas fa-plus-circle"></i> Tambah Site</h5>
    </div>
    <div class="card-body">
        <form action="<?= base_url('site/tambah_aksi') ?>" method="post" class="ml-2">
            <div class="form-group">
                <label>Nama Site</label>
                <input
                    type="text"
                    name="namasite"
                    id="namasite"
                    class="form-control"
                    placeholder="Nama Kota"
                    required>
                <?= form_error('namasite', '<div class="text-small text-danger">', '</div>'); ?>
            </div>
            <div class="form-group">
                <label>Code Site</label>
                <input
                    type="text"
                    name="kodesite"
                    id="kodesite"
                    class="form-control"
                    placeholder="Prepix ID Pelanggan"
                    required>
                <?= form_error('kodesite', '<div class="text-small text-danger">', '</div>'); ?>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Tambah</button>
                <a href="<?= base_url('site') ?>" class="btn btn-secondary ml-2"><i class="fas fa-arrow-left"></i> Kembali</a>
            </div>
        </form>
    </div>
</div>

<!-- TOASTR NOTIFIKASI -->
<script>
    $(document).ready(function() {
        <?php if ($this->session->flashdata('error')): ?>
            toastr.error("<?= $this->session->flashdata('error'); ?>");
        <?php endif; ?>
        <?php if ($this->session->flashdata('pesan')): ?>
            toastr.success("<?= $this->session->flashdata('pesan'); ?>");
        <?php endif; ?>
    });
</script>