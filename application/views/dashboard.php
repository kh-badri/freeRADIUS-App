<!-- Main content -->
<!-- Tambahkan CSS toastr -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<!-- Tambahkan JS toastr dan jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<div>
    <h4 class="mt-2"><strong>Data</strong></h4>
</div>
<section class="content">
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <!-- Total User -->
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-4">
                <div class="small-box text-white" style="background-color:rgb(7, 90, 122);">
                    <div class="inner">
                        <h3><?= $total_user; ?></h3>
                        <p>Total User</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <a href="<?= base_url('user?type=home') ?>" class="small-box-footer text-white">
                        More Info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <!-- User Aktif -->
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-4 text-white">
                <div class="small-box" style="background-color: rgb(13, 161, 63);">
                    <div class="inner">
                        <h3><?= $total_user_aktif; ?></h3>
                        <p>User Aktif</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-user-check"></i>
                    </div>
                    <a href="<?= base_url('user?type=home&status=aktif') ?>" class="small-box-footer text-white">
                        More Info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <!-- User Expired -->
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-4 text-white">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3><?= $total_user_expired; ?></h3>
                        <p>User Expired</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-user-times"></i>
                    </div>
                    <a href="<?= base_url('user?type=home&status=expired') ?>" class="small-box-footer text-white">
                        More Info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <!-- Total Voucher -->
            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 mb-4 text-white">
                <div class="small-box" style="background-color: #3674B5;">
                    <div class="inner">
                        <h3><?= $total_voucher; ?></h3>
                        <p>Total Voucher</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-ticket-alt"></i>
                    </div>
                    <a href="<?= base_url('user?type=voucher') ?>" class="small-box-footer">
                        More Info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <!-- Voucher Aktif -->
            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 mb-4 text-white">
                <div class="small-box" style="background-color: #03A6A1;">
                    <div class="inner">
                        <h3><?= $total_voucher_aktif; ?></h3>
                        <p>Voucher Aktif</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-hourglass-end"></i>
                    </div>
                    <a href="<?= base_url('user?type=voucher&status=aktif') ?>" class="small-box-footer text-white">
                        More Info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <!-- Voucher Expired -->
            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 mb-4 text-white">
                <div class="small-box" style="background-color: rgb(231, 76, 60);">
                    <div class="inner">
                        <h3><?= $total_voucher_expired; ?></h3>
                        <p>Voucher Expired</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-ban"></i>
                    </div>
                    <a href="<?= base_url('user?type=voucher&status=expired') ?>" class="small-box-footer text-white">
                        More Info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <!-- Total Nas -->
            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 mb-4 text-white">
                <div class="small-box" style="background-color: #437057;">
                    <div class="inner">
                        <h3><?= $total_nas; ?></h3>
                        <p>Total Nas <i class="" aria-hidden="true"></i></p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-network-wired"></i>
                    </div>
                    <a href="<?= base_url('nas') ?>" class="small-box-footer text-white">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
</section>





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
        <?php if ($this->session->flashdata('success')): ?>
            toastr.success("<?= $this->session->flashdata('success'); ?>");
        <?php endif; ?>
    });
</script>