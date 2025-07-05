<!-- Tambahkan toastr dan jQuery jika belum ada -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<div class="card">
    <div class="card-header bg-dark text-white">
        <h5 class="m-0"><i class="fas fa-plus-circle"></i> Tambah Sesi</h5>
    </div>
    <div class="card-body">
        <form action="<?= base_url('sesi/tambah_aksi') ?>" method="post" class="ml-2">
            <div class="form-group">
                <label>Nama Sesi</label>
                <input
                    type="text"
                    name="namasesi"
                    id="namasesi"
                    class="form-control"
                    placeholder="jam / bulan"
                    oninput="updateNilaiSesi()"
                    autocomplete="off"
                    required>
                <?= form_error('namasesi', '<div class="text-small text-danger">', '</div>'); ?>
            </div>
            <div class="form-group">
                <label>Nilai (dalam detik)</label>
                <input
                    type="text"
                    name="nilaisesi"
                    id="nilaisesi"
                    class="form-control"
                    placeholder="Detik"
                    readonly
                    required>
                <?= form_error('nilaisesi', '<div class="text-small text-danger">', '</div>'); ?>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Tambah</button>
                <a href="<?= base_url('sesi') ?>" class="btn btn-secondary ml-2"><i class="fas fa-arrow-left"></i> Kembali</a>
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

    function updateNilaiSesi() {
        const input = document.getElementById("namasesi").value.trim().toLowerCase().replace(/\s+/g, ' ');

        let detik = 0;

        // Cek pola input
        const jamMatch = input.match(/^(\d+)\s?jam$/);
        const menitMatch = input.match(/^(\d+)\s?menit$/);
        const bulanMatch = input.match(/^(\d+)\s?bulan$/);

        if (jamMatch) {
            detik = parseInt(jamMatch[1]) * 3600;
        } else if (menitMatch) {
            detik = parseInt(menitMatch[1]) * 60;
        } else if (bulanMatch) {
            detik = parseInt(bulanMatch[1]) * 30 * 24 * 3600; // anggap 1 bulan = 30 hari
        }

        document.getElementById("nilaisesi").value = detik || 0;
    }
</script>