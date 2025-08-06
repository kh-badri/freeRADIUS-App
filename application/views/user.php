<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<div class="card">
  <div class="card-header d-flex justify-content-between align-items-center">
    <?php $role = $this->session->userdata('role'); ?>
    <a href="<?= base_url('user/tambah') ?>" class="btn btn-primary" <?php if ($role !== 'admin'): ?>onclick="event.preventDefault(); showAccessDeniedAlert();" <?php endif; ?>>
      <i class="fas fa-plus"></i> Tambah User
    </a>

    <div>
      <button class="btn btn-secondary btn-sm filter-btn" data-type="home"><i class="fas fa-home mr-1"></i> Home</button>
      <button class="btn btn-secondary btn-sm filter-btn" data-type="voucher"><i class="fas fa-ticket-alt mr-1"></i> Voucher</button>
      <button class="btn btn-success btn-sm filter-btn" data-type="all">Show All</button>
    </div>
  </div>

  <div class="card-body">
    <div class="table-responsive">
      <table id="example1" class="table table-bordered table-striped">
        <thead class="bg-dark text-white text-center">
          <tr>
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
            <tr class="text-center filter-row" data-type="<?= htmlspecialchars($ssw->type) ?>">
              <td><?= $no++ ?></td>
              <td><?= htmlspecialchars($ssw->nama_pelanggan) ?></td>
              <td><?= htmlspecialchars($ssw->username) ?></td>
              <td><?= htmlspecialchars($ssw->expiration) ?></td>
              <td><?= htmlspecialchars($ssw->kategori) ?></td>
              <td><?= htmlspecialchars($ssw->site) ?></td>
              <td><?= htmlspecialchars($ssw->type) ?></td>
              <td><?= htmlspecialchars($ssw->koneksi) ?></td>
              <td><?= htmlspecialchars($ssw->namapaket) ?></td>
              <td>Rp. <?= number_format((float) str_replace('.', '', $ssw->tarif), 0, ',', '.') ?></td>
              <td><?= htmlspecialchars($ssw->namasesi) ?></td>
              <td>
                <a href="http://<?= htmlspecialchars($ssw->ipaddress) ?>/" target="_blank" class="btn btn-success btn-sm"><i class="fa fa-wifi"></i></a>
                <button class="btn btn-warning btn-sm btn-edit-user" data-toggle="modal" data-target="#modalEditUser"
                  data-id="<?= $ssw->id_user ?>" data-nama="<?= htmlspecialchars($ssw->nama_pelanggan) ?>" data-username="<?= htmlspecialchars($ssw->username) ?>"
                  data-password="<?= htmlspecialchars($ssw->password) ?>" data-alamat="<?= htmlspecialchars($ssw->alamat) ?>"
                  data-nomor_hp="<?= htmlspecialchars($ssw->nomor_hp) ?>" data-ipaddress="<?= htmlspecialchars($ssw->ipaddress) ?>"
                  data-koneksi="<?= $ssw->koneksi ?>" data-simuluse="<?= $ssw->simuluse ?>"
                  data-expiration="<?= date('Y-m-d\TH:i', strtotime($ssw->expiration)) ?>"
                  data-site_id="<?= $ssw->site_id ?>" data-kategori="<?= $ssw->kategori ?>"
                  data-bandwith_id="<?= $ssw->bandwith_id ?>" data-tarif="<?= $ssw->tarif ?>" data-sesi_id="<?= $ssw->sesi_id ?>">
                  <i class="fa fa-edit"></i>
                </button>
                <a href="<?= base_url('user/delete/' . $ssw->id_user) ?>" class="btn btn-danger btn-sm" <?php if ($role !== 'admin'): ?>onclick="event.preventDefault(); showAccessDeniedAlert();" <?php else: ?>onclick="return confirm('Apakah Anda yakin menghapus data ini?')" <?php endif; ?>>
                  <i class="fa fa-trash"></i>
                </a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>

  <?php $this->load->view('user/modal_edit_user'); ?>
</div>

<script>
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

    $('.toggle-password').click(function() {
      const input = $('#edit_password');
      const icon = $('#toggle-password-icon');
      input.attr('type', input.attr('type') === 'password' ? 'text' : 'password');
      icon.toggleClass('fa-eye fa-eye-slash');
    });

    $('.btn-edit-user').click(function() {
      let btn = $(this);
      $('#formEditUser').attr('action', '<?= base_url('user/edit/') ?>' + btn.data('id'));
      $('#edit_id_user').val(btn.data('id'));
      $('#edit_nama').val(btn.data('nama'));
      $('#edit_username').val(btn.data('username'));
      $('#edit_password').val(btn.data('password'));
      $('#edit_alamat').val(btn.data('alamat'));
      $('#edit_nomor_hp').val(btn.data('nomor_hp'));
      $('#edit_ipaddress').val(btn.data('ipaddress'));
      $('#edit_koneksi').val(btn.data('koneksi'));
      $('#edit_simuluse').val(btn.data('simuluse'));
      $('#edit_expiration').val(btn.data('expiration'));
      $('#edit_site_id').val(btn.data('site_id'));
      $('#edit_kategori').val(btn.data('kategori'));
      $('#edit_bandwith_id').val(btn.data('bandwith_id')).trigger('change');
      $('#edit_sesi_id').val(btn.data('sesi_id'));
      let tarif = btn.data('tarif') || 0;
      $('#edit_tarif').val('Rp. ' + new Intl.NumberFormat('id-ID').format(tarif));
    });

    $('#edit_bandwith_id').change(function() {
      let harga = $(this).find(':selected').data('harga');
      $('#edit_tarif').val(harga ? 'Rp. ' + new Intl.NumberFormat('id-ID').format(harga) : '');
    });

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
    <?php endif; ?>
  });

  function showAccessDeniedAlert() {
    toastr.error("Akses Ditolak! Anda tidak memiliki hak akses untuk fitur ini.");
  }
</script>