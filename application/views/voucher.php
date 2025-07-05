<!-- Tambahkan CSS toastr -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<!-- Tambahkan JS toastr dan jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>


<!-- Form Generate Voucher -->
<div class="card">
    <div class="card-header bg-dark text-white">
        <h5>Generate Voucher</h5>
    </div>
    <div class="card-body">
        <form action="<?= base_url('voucher/generate') ?>" method="post">
            <div class="row">
                <div class="col-md-4">
                    <!-- type voucher -->
                    <input name="type" class="form-control" required value="voucher" type="hidden">

                    <div class="form-group">
                        <label>Jumlah Voucher</label>
                        <input type="number" name="jumlah" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Prefix Username</label>
                        <input type="text" name="prefix" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Expiration</label>
                        <input type="datetime-local" name="expiration" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Simultaneous Use</label>
                        <input type="number" name="simuluse" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Bandwidth</label>
                        <select name="bandwith_id" class="form-control" required>
                            <option value="">-- Select Bandwidth --</option>
                            <?php if (!empty($bandwidth)): ?>
                                <?php foreach ($bandwidth as $bw): ?>
                                    <option value="<?= $bw->id_bw ?>"><?= $bw->namapaket ?></option>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <option value="">Tidak ada data bandwidth</option>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Sesi</label>
                        <select name="sesi_id" class="form-control" required>
                            <option value="">-- Select Sesi --</option>
                            <?php if (!empty($sesi)): ?>
                                <?php foreach ($sesi as $si): ?>
                                    <option value="<?= $si->id_sesi ?>"><?= $si->namasesi ?></option>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <option value="">Tidak ada data sesi</option>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-success mt-3">
                <i class="fas fa-cogs"></i> Generate Voucher
            </button>
        </form>
    </div>
</div>


<script>
    $(document).ready(function() {
        // Atur konfigurasi toastr
        toastr.options = {
            closeButton: true,
            progressBar: true,
            positionClass: "toast-top-right", // Lokasi notifikasi
            showMethod: "slideDown",
            hideMethod: "slideUp",
            timeOut: 3000 // Waktu tampil
        };

        // Tampilkan pesan toastr jika ada flashdata
        <?php if ($this->session->flashdata('pesan')): ?>
            toastr.success("<?= $this->session->flashdata('pesan'); ?>");
        <?php endif; ?>
    });
</script>