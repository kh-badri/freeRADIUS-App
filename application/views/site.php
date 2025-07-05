<!-- Tambahkan CSS toastr -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<!-- Tambahkan JS toastr dan jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<div class="card">
    <!-- Ambil role user dari session -->
    <?php $role = $this->session->userdata('role'); ?>

    <div class="card-header">
        <a href="<?= base_url('site/tambah') ?>" class="btn btn-primary"
            style="background-color: #343a40; border-color: #343a40; color: white;"
            <?php if ($role !== 'admin'): ?>
            onclick="event.preventDefault(); showAccessDeniedToastr();"
            <?php endif; ?>>
            <i class="fas fa-plus"> Tambah Site</i>
        </a>
    </div>

    <div class="card-body">
        <table id="example1" class="table table-bordered table-striped">
            <thead style="background-color: #343a40; color: white;">
                <tr class="text-center">
                    <th>No</th>
                    <th>Nama Site</th>
                    <th>Code Site</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1;
                foreach ($site as $ssw): ?>
                    <tr class="text-center">
                        <td><?= $no++ ?></td>
                        <td><?= $ssw->namasite ?></td>
                        <td><?= $ssw->kodesite ?></td>
                        <td>
                            <button data-toggle="modal" data-target="#edit<?= $ssw->id_site ?>" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></button>

                            <a href="<?= base_url('site/delete/' . $ssw->id_site) ?>"
                                class="btn btn-danger btn-sm"
                                <?php if ($role !== 'admin'): ?>
                                onclick="event.preventDefault(); showAccessDeniedToastr();"
                                <?php else: ?>
                                onclick="return confirm('Apakah Anda yakin menghapus data ini?')"
                                <?php endif; ?>>
                                <i class="fa fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Edit -->
<?php foreach ($site as $ssw): ?>
    <div class="modal fade" id="edit<?= $ssw->id_site ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Site</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <form action="<?= base_url('site/edit/' . $ssw->id_site) ?>" method="post">
                        <div class="form-group">
                            <label>Nama Site</label>
                            <input type="text"
                                name="namasite"
                                class="form-control"
                                placeholder="Misal: 1 jam"
                                value="<?= $ssw->namasite ?>"
                                id="namasite<?= $ssw->id_site ?>"
                                oninput="updateNilaiSite(<?= $ssw->id_site ?>)">
                            <?= form_error('namasite', '<div class="text-small text-danger">', '</div>'); ?>
                        </div>
                        <div class="form-group">
                            <label>Code Site</label>
                            <input type="text"
                                name="kodesite"
                                class="form-control"
                                placeholder="Detik"
                                value="<?= $ssw->kodesite ?>"
                                id="kodesite<?= $ssw->id_site ?>">
                            <?= form_error('kodesite', '<div class="text-small text-danger">', '</div>'); ?>
                        </div>

                        <div class="modal-footer d-flex justify-content-center">
                            <button type="submit"
                                class="btn btn-primary mr-4"
                                <?php if ($role !== 'admin'): ?>
                                onclick="event.preventDefault(); showAccessDeniedToastr();"
                                <?php endif; ?>>
                                <i class="fas fa-save"></i> Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<script>
    $(document).ready(function() {
        toastr.options = {
            closeButton: true,
            progressBar: true,
            positionClass: "toast-top-right",
            showMethod: "slideDown",
            hideMethod: "slideUp",
            timeOut: 3000
        };

        <?php if ($this->session->flashdata('pesan')): ?>
            toastr.success("<?= $this->session->flashdata('pesan'); ?>");
        <?php elseif ($this->session->flashdata('error')): ?>
            toastr.error("<?= $this->session->flashdata('error'); ?>");
        <?php endif; ?>
    });

    function showAccessDeniedToastr() {
        toastr.error('Akses ditolak!<br>Anda tidak memiliki akses fitur ini.', {
            closeButton: true,
            progressBar: true,
            timeOut: 5000,
        });
    }
</script>