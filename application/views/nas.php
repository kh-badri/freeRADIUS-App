<!-- Tambahkan CSS toastr -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<!-- Tambahkan JS toastr dan jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<div class="card">
  <!-- button tambah -->
  <div class="card-header">
    <a
      href="<?= base_url('nas/tambah') ?>"
      class="btn"
      style="background-color: #343a40; border-color: #343a40; color: white;"
      <?php if ($this->session->userdata('role') !== 'admin'): ?>
      onclick="event.preventDefault(); showAccessDeniedAlert();"
      <?php endif; ?>>
      <i class="fas fa-plus"></i> <b>Add</b> Nas
    </a>
  </div>

  <!-- /.card-header -->
  <div class="card-body">
    <table id="example1" class="table table-bordered table-striped">
      <thead style="background-color: #343a40; color: white;">
        <tr class="text-center">
          <th>No</th>
          <th>IP Address</th>
          <th>Shortname</th>
          <th>Type</th>
          <th>Secret</th>
          <th>Community</th>
          <th>Actions</th>
        </tr>
      </thead>
      </thead>

      <tbody>
        <?php $no = 1;
        foreach ($nas as $ssw): ?>
          <tr class="text-center">
            <td><?= $no++ ?></td>
            <td><?= $ssw->nasname ?></td>
            <td><?= $ssw->shortname ?></td>
            <td><?= $ssw->type ?></td>
            <td><?= $ssw->secret ?></td>
            <td><?= $ssw->community ?></td>
            <td>
              <button data-toggle="modal" data-target="#edit<?= $ssw->id ?>" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></button>
              <?php
              // Ambil role user dari session
              $role = $this->session->userdata('role');
              ?>
              <a
                href="<?= base_url('nas/delete/' . $ssw->id) ?>"
                class="btn btn-danger btn-sm"
                <?php if ($role !== 'admin'): ?>
                onclick="event.preventDefault(); showAccessDeniedAlert();"
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
<?php foreach ($nas as $ssw) { ?>
  <div class="modal fade" id="edit<?= $ssw->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit Nas</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="<?= base_url('nas/edit/' . $ssw->id) ?>" method="post" class="ml-2">
            <div class="form-group">
              <label>IP Address</label>
              <input type="text" name="nasname" class="form-control" placeholder="IP Server" value="<?= $ssw->nasname ?>">
              <?= form_error('nasname', '<div class="text-small text-danger">', '</div>'); ?>
            </div>
            <div class="form-group">
              <label>Short Name</label>
              <input type="text" name="shortname" class="form-control" value="<?= $ssw->shortname ?>">
              <?= form_error('shortname', '<div class="text-small text-danger">', '</div>'); ?>
            </div>
            <div class="form-group">
              <label>Type</label>
              <input type="text" name="type" class="form-control" value="<?= $ssw->type ?>">
              <?= form_error('type', '<div class="text-small text-danger">', '</div>'); ?>
            </div>
            <div class="form-group">
              <label>Secret</label>
              <input type="text" name="secret" class="form-control" value="<?= $ssw->secret ?>">
              <?= form_error('secret', '<div class="text-small text-danger">', '</div>'); ?>
            </div>
            <div class="form-group">
              <label>Community</label>
              <input type="text" name="community" class="form-control" value="<?= $ssw->community ?>">
              <?= form_error('community', '<div class="text-small text-danger">', '</div>'); ?>
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
          </form>
        </div>
      </div>
    </div>
  </div>
<?php } ?>

<!-- Script Inline -->
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

  // Alert akses ditolak
  function showAccessDeniedAlert() {
    toastr.error("Akses Ditolak! Anda tidak memiliki hak akses untuk fitur ini.");
  }
</script>