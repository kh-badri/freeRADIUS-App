<!-- Tambahkan CSS toastr -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<!-- Tambahkan JS toastr dan jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<div class="card">
    <!-- button tambah -->
    <?php
    // Ambil role user dari session
    $role = $this->session->userdata('role');
    ?>

    <div class="card-header">
        <a
            href="<?= base_url('kategori/tambah') ?>"
            class="btn btn-primary"
            style="background-color: #343a40; border-color: #343a40; color: white;"
            <?php if ($role !== 'admin'): ?>
            onclick="event.preventDefault(); showAccessDeniedAlert();"
            <?php endif; ?>>
            <i class="fas fa-plus"> Tambah Kategori</i>
        </a>
    </div>

    <!-- /.card-header -->
    <div class="card-body">
        <table id="example1" class="table table-bordered table-striped">
            <thead style="background-color: #343a40; color: white;">
                <tr class="text-center">
                    <th>No</th>
                    <th>Kategori Layanan</th>
                    <th>Tipe Koneksi</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1;
                foreach ($kategori as $ssw): ?>
                    <tr class="text-center">
                        <td><?= $no++ ?></td>
                        <td><?= $ssw->namakategori ?></td>
                        <td><?= $ssw->tipe_kategori ?></td>
                        <td>
                            <button data-toggle="modal" data-target="#edit<?= $ssw->id_kategori ?>" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></button>
                            <?php
                            // Ambil role user dari session
                            $role = $this->session->userdata('role');
                            ?>

                            <a
                                href="<?= base_url('kategori/delete/' . $ssw->id_kategori) ?>"
                                class="btn btn-danger btn-sm"
                                <?php if ($role !== 'admin'): ?>
                                onclick="event.preventDefault(); showAccessDeniedAlert();"
                                <?php else: ?>
                                onclick="return confirm('Apakah Anda yakin menghapus data ini?')"
                                <?php endif; ?>>
                                <i class="fa fa-trash"></i>
                            </a>

                            <!-- Alert HTML -->
                            <div class="alert alert-danger alert-dismissible fade" role="alert" id="access-denied-alert" style="display: none; position: fixed; top: 20px; right: 20px; z-index: 9999;">
                                <strong><i class="fas fa-times-circle"></i> Akses Ditolak!</strong><br> Anda tidak memiliki hak akses untuk fitur ini.
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Edit -->
<?php foreach ($kategori as $ssw) { ?>
    <div class="modal fade" id="edit<?= $ssw->id_kategori ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Sesi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="<?= base_url('kategori/edit/' . $ssw->id_kategori) ?>" method="post" class="ml-2">
                        <div class="form-group">
                            <label>Kategori</label>
                            <input type="text"
                                name="namakategori"
                                class="form-control"
                                placeholder="Misal: 1 jam"
                                value="<?= $ssw->namakategori ?>"
                                id="namakategori<?= $ssw->id_kategori ?>"
                                oninput="updateNilaiSesi(<?= $ssw->id_kategori ?>)">
                            <?= form_error('namakategori', '<div class="text-small text-danger">', '</div>'); ?>
                        </div>
                        <div class="form-group">
                            <label>Tipe Koneksi</label>
                            <select name="tipe_kategori"
                                class="form-control"
                                id="namakategori<?= $ssw->id_kategori ?>"
                                onchange="updateNilaiSesi(<?= $ssw->id_kategori ?>)">
                                <option value="">-- Pilih Tipe Koneksi --</option>
                                <option value="Fiber Optic" <?= ($ssw->tipe_kategori == 'Fiber Optic') ? 'selected' : '' ?>>Fiber Optic</option>
                                <option value="Wireless" <?= ($ssw->tipe_kategori == 'Wireless') ? 'selected' : '' ?>>Wireless</option>
                            </select>
                            <?= form_error('tipe_kategori', '<div class="text-small text-danger">', '</div>'); ?>
                        </div>

                        <?php
                        // Ambil role user dari session
                        $role = $this->session->userdata('role');
                        ?>
                        <div class="modal-footer d-flex justify-content-center">
                            <button
                                type="submit"
                                class="btn btn-primary mr-4"
                                <?php if ($role !== 'admin'): ?>
                                onclick="event.preventDefault(); showAccessDeniedAlert();"
                                <?php endif; ?>>
                                <i class="fas fa-save"></i> Simpan
                            </button>
                        </div>

                        <!-- Alert HTML -->
                        <div class="alert alert-danger alert-dismissible fade" role="alert" id="access-denied-alert" style="display: none; position: fixed; top: 20px; right: 20px; z-index: 9999;">
                            <strong><i class="fas fa-times-circle"></i> Akses Ditolak!</strong><br> Anda tidak memiliki hak akses untuk fitur ini.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

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

        <?php if ($this->session->flashdata('error')): ?>
            toastr.error("<?= $this->session->flashdata('error'); ?>");
        <?php endif; ?>
    });

    // Alert akses ditolak
    function showAccessDeniedAlert() {
        toastr.error("Akses Ditolak! Anda tidak memiliki hak akses untuk fitur ini.");
    }
</script>