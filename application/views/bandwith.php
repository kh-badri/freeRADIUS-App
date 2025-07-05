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
      href="<?= base_url('bandwith/tambah') ?>"
      class="btn btn-primary"
      style="background-color: #343a40; border-color: #343a40; color: white;"
      <?php if ($role !== 'admin'): ?>
      onclick="event.preventDefault(); showAccessDeniedAlert();"
      <?php endif; ?>>
      <i class="fas fa-plus"></i> Tambah Layanan
    </a>
  </div>


  <!-- /.card-header -->
  <div class="card-body">
    <table id="example1" class="table table-bordered table-striped">
      <thead style=" background-color: #343a40; color: white;">
        <tr class=" text-center">
          <th>No</th>
          <th>Bandwith</th>
          <th>Nilai</th>
          <th>Harga</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php $no = 1;
        foreach ($bandwith as $ssw): ?>
          <tr class="text-center">
            <td><?= $no++ ?></td>
            <td><?= $ssw->namapaket ?></td>
            <td><?= $ssw->nilaipaket ?></td>
            <td>Rp.<?= $ssw->harga ?></td>
            <td>
              <button data-toggle="modal" data-target="#edit<?= $ssw->id_bw ?>" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></button>
              <?php
              // Ambil role user dari session
              $role = $this->session->userdata('role');
              ?>

              <a
                href="<?= base_url('bandwith/delete/' . $ssw->id_bw) ?>"
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

<?php foreach ($bandwith as $ssw) { ?>
  <div class="modal fade" id="edit<?= $ssw->id_bw ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit Paket Bandwidth</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="<?= base_url('bandwith/edit/' . $ssw->id_bw) ?>" method="post">
            <!-- Input Nama Paket -->
            <div class="form-group">
              <label for="namapaket<?= $ssw->id_bw ?>">Jenis Layanan</label>
              <input
                type="text"
                name="namapaket"
                id="namapaket<?= $ssw->id_bw ?>"
                class="form-control"
                placeholder="Contoh: 10 Mbps"
                value="<?= $ssw->namapaket ?>"
                oninput="updateNilaiPaket(<?= $ssw->id_bw ?>)"
                autocomplete="off">
              <?= form_error('namapaket', '<div class="text-small text-danger">', '</div>'); ?>
            </div>

            <!-- Input Nilai Paket -->
            <div class="form-group">
              <label for="nilaipaket<?= $ssw->id_bw ?>">Nilai</label>
              <input
                type="text"
                name="nilaipaket"
                id="nilaipaket<?= $ssw->id_bw ?>"
                class="form-control"
                placeholder="M/M"
                readonly
                value="<?= $ssw->nilaipaket ?>">
              <?= form_error('nilaipaket', '<div class="text-small text-danger">', '</div>'); ?>
            </div>

            <div class="form-group">
              <label for="harga<?= $ssw->id_bw ?>">Harga</label>
              <input
                type="text"
                name="harga"
                id="harga<?= $ssw->id_bw ?>"
                class="form-control"
                placeholder="Rp."
                value="<?= $ssw->harga ?>"
                oninput="updateNilaiPaket(<?= $ssw->id_bw ?>)"
                autocomplete="off">
              <?= form_error('harga', '<div class="text-small text-danger">', '</div>'); ?>
            </div>

            <!-- Tombol Simpan -->
            <?php
            // Ambil role user dari session
            $role = $this->session->userdata('role');
            ?>

            <div class="modal-footer d-flex justify-content-center">
              <button
                type="submit"
                class="btn btn-primary"
                <?php if ($role !== 'admin'): ?>
                onclick="event.preventDefault(); showAccessDeniedAlert();"
                <?php endif; ?>>
                <i class="fas fa-save"></i> Simpan
              </button>
            </div>
        </div>
        </form>
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

  function updateNilaiPaket(id) {
    // Ambil input dari kolom Nama Paket
    const namaPaketInput = document.getElementById("namapaket" + id).value.trim();

    // Regex untuk memvalidasi angka diikuti "Mbps"
    const match = namaPaketInput.match(/(\d+)\s?(?:Mbps)?/i);


    // Update nilai jika valid
    if (match) {
      const nilai = match[1]; // Angka dari regex
      document.getElementById("nilaipaket" + id).value = `${nilai}M/${nilai}M`;
    } else {
      // Kosongkan jika tidak valid
      document.getElementById("nilaipaket" + id).value = "";
    }
  }
</script>