<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<div class="card">
  <div class="card-header d-flex justify-content-between">
    <?php $role = $this->session->userdata('role'); ?>
    <a href="<?= base_url('user/tambah') ?>" class="btn btn-primary btn-dark" <?php if ($role !== 'admin'): ?> onclick="event.preventDefault(); showAccessDeniedAlert();" <?php endif; ?>>
      <i class="fas fa-plus"></i> Tambah User
    </a>

    <div class="ml-auto">
      <button class="btn btn-secondary btn-sm filter-btn" data-type="home"><i class="fas fa-home mr-1"></i> Filter Home</button>
      <button class="btn btn-secondary btn-sm filter-btn" data-type="voucher"><i class="fas fa-ticket-alt mr-1"></i> Filter Voucher</button>
      <button class="btn btn-success btn-sm filter-btn" data-type="all">Show All</button>
    </div>
  </div>

  <div class="card-body">
    <div class="table-responsive">
      <table id="example1" class="table table-bordered table-striped">
        <thead class="bg-dark text-white">
          <tr class="text-center">
            <th>No</th>
            <th>Nama Pelanggan</th>
            <th>Username</th>
            <th>Expiration</th>
            <th>Kategori</th>
            <th>Site</th>
            <th>Tipe</th>
            <th>Koneksi</th>
            <th>Layanan</th>
            <th>Tarif</th>
            <th>Waktu</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php $no = 1;
          foreach ($user as $ssw): ?>
            <tr class="text-center filter-row" data-type="<?= htmlspecialchars($ssw->type, ENT_QUOTES, 'UTF-8') ?>">
              <td><?= $no++ ?></td>
              <td><?= htmlspecialchars($ssw->nama_pelanggan, ENT_QUOTES, 'UTF-8') ?></td>
              <td><?= htmlspecialchars($ssw->username, ENT_QUOTES, 'UTF-8') ?></td>
              <td><?= htmlspecialchars($ssw->expiration, ENT_QUOTES, 'UTF-8') ?></td>
              <td><?= htmlspecialchars($ssw->namakategori, ENT_QUOTES, 'UTF-8') ?></td>
              <td><?= htmlspecialchars($ssw->site, ENT_QUOTES, 'UTF-8') ?></td>
              <td><?= htmlspecialchars($ssw->type, ENT_QUOTES, 'UTF-8') ?></td>
              <td><?= htmlspecialchars($ssw->tipe_kategori, ENT_QUOTES, 'UTF-8') ?></td>
              <td><?= htmlspecialchars($ssw->namapaket, ENT_QUOTES, 'UTF-8') ?></td>
              <td>Rp. <?= number_format((float) str_replace('.', '', $ssw->tarif), 0, ',', '.') ?></td>
              <td><?= htmlspecialchars($ssw->namasesi, ENT_QUOTES, 'UTF-8') ?></td>
              <td>
                <a href="http://<?= htmlspecialchars($ssw->ipaddress, ENT_QUOTES, 'UTF-8') ?>/" target="_blank" class="btn btn-success btn-sm">
                  <i class="fa fa-wifi"></i>
                </a>
                <button class="btn btn-warning btn-sm btn-edit-user"
                  data-id="<?= $ssw->id_user ?>"
                  data-nama="<?= htmlspecialchars($ssw->nama_pelanggan, ENT_QUOTES, 'UTF-8') ?>"
                  data-username="<?= htmlspecialchars($ssw->username, ENT_QUOTES, 'UTF-8') ?>"
                  data-password="<?= htmlspecialchars($ssw->password, ENT_QUOTES, 'UTF-8') ?>"
                  data-alamat="<?= htmlspecialchars($ssw->alamat, ENT_QUOTES, 'UTF-8') ?>"
                  data-nomor_hp="<?= htmlspecialchars($ssw->nomor_hp, ENT_QUOTES, 'UTF-8') ?>"
                  data-ipaddress="<?= htmlspecialchars($ssw->ipaddress, ENT_QUOTES, 'UTF-8') ?>"
                  data-simuluse="<?= $ssw->simuluse ?>"
                  data-expiration="<?= date('Y-m-d\TH:i', strtotime($ssw->expiration)) ?>"
                  data-site_id="<?= $ssw->site_id ?>"
                  data-kategori_id="<?= $ssw->kategori_id ?>"
                  data-bandwith_id="<?= $ssw->bandwith_id ?>"
                  data-tarif="<?= $ssw->tarif ?>"
                  data-sesi_id="<?= $ssw->sesi_id ?>"
                  data-toggle="modal" data-target="#modalEditUser">
                  <i class="fa fa-edit"></i>
                </button>
                <a href="<?= base_url('user/delete/' . $ssw->id_user) ?>" class="btn btn-danger btn-sm"
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
</div>

<!-- Modal Edit User -->
<div class="modal fade" id="modalEditUser" tabindex="-1" role="dialog" aria-labelledby="modalEditLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <form action="<?= base_url('user/edit/' . $ssw->id_user) ?>" method="post">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Data User</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span>&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id_user" id="edit_id_user">
          <div class="row">
            <!-- Kolom 1 -->
            <div class="col-md-4">
              <div class="form-group">
                <label>Nama Pelanggan</label>
                <input type="text" name="nama_pelanggan" id="edit_nama" class="form-control">
              </div>
              <div class="form-group">
                <label>Alamat</label>
                <input type="text" name="alamat" id="edit_alamat" class="form-control">
              </div>
              <div class="form-group">
                <label>Nomor HP</label>
                <input type="text" name="nomor_hp" id="edit_nomor_hp" class="form-control">
              </div>
              <div class="form-group">
                <label>IP Address</label>
                <input type="text" name="ipaddress" id="edit_ipaddress" class="form-control">
              </div>
              <div class="form-group">
                <label>Koneksi</label>
                <select name="kategori_id" id="kategori_id" class="form-control">
                  <option value="">-- Pilih Koneksi --</option>
                  <?php
                  $tipe_kategori_terpakai = [];
                  foreach ($kategori as $kt):
                    if (!in_array($kt->tipe_kategori, $tipe_kategori_terpakai)):
                      $tipe_kategori_terpakai[] = $kt->tipe_kategori;
                  ?>
                      <option value="<?= $kt->id_kategori ?>"><?= $kt->tipe_kategori ?></option>
                  <?php
                    endif;
                  endforeach;
                  ?>
                </select>
              </div>
            </div>

            <!-- Kolom 2 -->
            <div class="col-md-4">
              <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" id="edit_username" class="form-control" readonly>
              </div>
              <div class="form-group">
                <label>Password</label>
                <div class="input-group">
                  <input type="password" name="password" id="edit_password" class="form-control password-field">
                  <div class="input-group-append">
                    <span class="input-group-text toggle-password" style="cursor: pointer;">
                      <i class="fa fa-eye" id="toggle-password-icon"></i>
                    </span>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label>Expiration</label>
                <input type="datetime-local" name="expiration" id="edit_expiration" class="form-control">
              </div>
              <div class="form-group">
                <label>Simultaneous-Use</label>
                <input type="number" name="simuluse" id="edit_simuluse" class="form-control">
              </div>
              <div class="form-group">
                <label>Tarif (Rp)</label>
                <input type="text" class="form-control" id="edit_tarif" readonly>
              </div>
            </div>

            <!-- Kolom 3 -->
            <div class="col-md-4">
              <div class="form-group">
                <label>Site</label>
                <!-- Tampilkan nama site (tidak bisa diedit) -->
                <input type="text" class="form-control" value="<?= $ssw->site ?>" readonly>
                <!-- Kirim ID site secara tersembunyi ke backend -->
                <input type="hidden" name="site_id" value="<?= $ssw->site_id ?>">
              </div>

              <div class="form-group">
                <label>Kategori</label>
                <select name="kategori_id" id="edit_kategori_id" class="form-control">
                  <?php foreach ($kategori as $kt): ?>
                    <option value="<?= $kt->id_kategori ?>"><?= $kt->namakategori ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="form-group">
                <label>Layanan</label>
                <select name="bandwith_id" id="edit_bandwith_id" class="form-control">
                  <?php foreach ($bandwith as $bw): ?>
                    <option value="<?= $bw->id_bw ?>" data-harga="<?= $bw->harga ?>">
                      <?= $bw->namapaket ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="form-group">
                <label>Sesi</label>
                <select name="sesi_id" id="edit_sesi_id" class="form-control">
                  <?php foreach ($sesi as $si): ?>
                    <option value="<?= $si->id_sesi ?>"><?= $si->namasesi ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-success">Simpan Perubahan</button>
        </div>
      </div>
    </form>
  </div>
</div>


<script>
  $(document).ready(function() {
    const urlParams = new URLSearchParams(window.location.search);
    const filterType = urlParams.get('type');

    if (filterType) {
      $('.filter-btn').removeClass('active');
      $(`.filter-btn[data-type="${filterType}"]`).addClass('active').trigger('click');
    }
  });

  $(document).ready(function() {
    $('.filter-btn').click(function() {
      const type = $(this).data('type');

      if (type === 'all') {
        $('tbody tr').show();
      } else {
        $('tbody tr').hide().filter(function() {
          return $(this).data('type') === type;
        }).show();
      }
    });

    // Auto trigger filter jika ada parameter type di URL
    const urlParams = new URLSearchParams(window.location.search);
    const filterType = urlParams.get('type');
    if (filterType) {
      $(`.filter-btn[data-type="${filterType}"]`).trigger('click');
    }
  });

  $(document).ready(function() {
    $('.toggle-password').on('click', function() {
      const input = $('#edit_password');
      const icon = $('#toggle-password-icon');

      if (input.attr('type') === 'password') {
        input.attr('type', 'text');
        icon.removeClass('fa-eye').addClass('fa-eye-slash');
      } else {
        input.attr('type', 'password');
        icon.removeClass('fa-eye-slash').addClass('fa-eye');
      }
    });
  });

  $(document).ready(function() {
    $('.btn-edit-user').on('click', function() {
      $('#edit_id_user').val($(this).data('id'));
      $('#edit_nama').val($(this).data('nama'));
      $('#edit_username').val($(this).data('username'));
      $('#edit_password').val($(this).data('password'));
      $('#edit_alamat').val($(this).data('alamat'));
      $('#edit_nomor_hp').val($(this).data('nomor_hp'));
      $('#edit_ipaddress').val($(this).data('ipaddress'));
      $('#edit_simuluse').val($(this).data('simuluse'));
      $('#edit_expiration').val($(this).data('expiration'));
      $('#edit_site_id').val($(this).data('site_id'));
      $('#edit_kategori_id').val($(this).data('kategori_id'));
      $('#edit_bandwith_id').val($(this).data('bandwith_id')).trigger('change');
      $('#edit_sesi_id').val($(this).data('sesi_id'));

      let raw = $(this).data('tarif');
      let formatted = 'Rp. ' + new Intl.NumberFormat('id-ID').format(parseInt(raw.replace(/\D/g, '')));
      $('#edit_tarif').val(formatted);
    });

    $('#edit_bandwith_id').on('change', function() {
      let harga = $(this).find(':selected').data('harga');
      if (harga) {
        let formatted = 'Rp. ' + new Intl.NumberFormat('id-ID').format(parseInt(harga.replace(/\D/g, '')));
        $('#edit_tarif').val(formatted);
      } else {
        $('#edit_tarif').val('');
      }
    });
  });

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