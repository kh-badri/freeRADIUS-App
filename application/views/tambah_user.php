<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<form action="<?= base_url('user/tambah_aksi') ?>" method="post" class="ml-2">
    <div class="row">
        <!-- Kolom Kiri -->
        <div class="col-md-6">
            <div class="form-group">
                <label>Nama Pelanggan</label>
                <input type="text" name="nama_pelanggan" class="form-control">
                <?= form_error('nama_pelanggan', '<div class="text-small text-danger">', '</div>'); ?>
            </div>
            <div class="form-group">
                <label>Alamat</label>
                <input type="text" name="alamat" class="form-control">
                <?= form_error('alamat', '<div class="text-small text-danger">', '</div>'); ?>
            </div>
            <div class="form-group">
                <label>Nomor Hp</label>
                <input type="text" name="nomor_hp" class="form-control">
                <?= form_error('nomor_hp', '<div class="text-small text-danger">', '</div>'); ?>
            </div>
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" id="username" class="form-control" readonly>
            </div>
            <div class="form-group">
                <label>Password</label>
                <div class="input-group">
                    <input type="password" name="password" id="password" class="form-control" readonly>
                    <div class="input-group-append">
                        <button type="button" class="btn btn-outline-secondary" onclick="togglePassword()">
                            <i class="fas fa-eye" id="toggle-icon"></i>
                        </button>
                    </div>
                </div>
                <?= form_error('password', '<div class="text-small text-danger">', '</div>'); ?>
            </div>
            <div class="form-group">
                <label>Koneksi</label>
                <select name="koneksi" id="koneksi" class="form-control">
                    <option value="">-- Pilih Koneksi --</option>
                    <?php foreach ($tipe_koneksi as $koneksi): ?>
                        <option value="<?= $koneksi->koneksi ?>"><?= $koneksi->koneksi ?></option>
                    <?php endforeach; ?>
                </select>
                <?= form_error('koneksi', '<div class="text-small text-danger">', '</div>'); ?>
            </div>
            <div class="form-group">
                <label>Expiration</label>
                <input type="datetime-local" name="expiration" class="form-control" value="<?= date('Y-m-d\TH:i') ?>">
                <?= form_error('expiration', '<div class="text-small text-danger">', '</div>'); ?>
            </div>
        </div>

        <!-- Kolom Kanan -->
        <div class="col-md-6">
            <div class="form-group">
                <label>IP Address</label>
                <input type="text" name="ipaddress" class="form-control">
                <?= form_error('ipaddress', '<div class="text-small text-danger">', '</div>'); ?>
            </div>
            <div class="form-group">
                <label>Site</label>
                <select name="site_id" id="site_id" class="form-control">
                    <option value="">-- Pilih Site --</option>
                    <?php foreach ($site as $st): ?>
                        <option value="<?= $st->id_site ?>"><?= $st->namasite ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label>Kategori</label>
                <select name="kategori_id" class="form-control">
                    <option value="">-- Select Kategori --</option>
                    <?php
                    $kategori_terpakai = [];
                    foreach ($kategori as $kt):
                        if (!in_array($kt->namakategori, $kategori_terpakai)):
                            $kategori_terpakai[] = $kt->namakategori;
                    ?>
                            <option value="<?= $kt->id_kategori ?>"><?= $kt->namakategori ?> </option>
                    <?php
                        endif;
                    endforeach;
                    ?>
                </select>
                <?= form_error('kategori_id', '<div class="text-small text-danger">', '</div>'); ?>
            </div>

            <div class="form-group">
                <label>Simultaneous Use</label>
                <input type="number" name="simuluse" class="form-control" min="1">
                <?= form_error('simuluse', '<div class="text-small text-danger">', '</div>'); ?>
            </div>

            <div class="form-group">
                <label>Layanan</label>
                <select name="bandwith_id" class="form-control" id="bandwithSelect">
                    <option value="">-- Select Bandwidth --</option>
                    <?php
                    $bandwith_terpakai = [];
                    foreach ($bandwith as $bw):
                        if (!in_array($bw->namapaket, $bandwith_terpakai)):
                            $bandwith_terpakai[] = $bw->namapaket;
                            $harga_bersih = str_replace('.', '', $bw->harga); // pastikan angka murni
                    ?>
                            <option value="<?= $bw->id_bw ?>" data-harga="<?= $harga_bersih ?>">
                                <?= $bw->namapaket ?>
                            </option>
                    <?php
                        endif;
                    endforeach;
                    ?>
                </select>
                <?= form_error('bandwith_id', '<div class="text-small text-danger">', '</div>'); ?>
            </div>


            <div class="form-group">
                <label for="tarif">Tarif</label>
                <input type="text" class="form-control" id="tarif" name="tarif" readonly>
            </div>



            <div class="form-group">
                <label>Sesi</label>
                <select name="sesi_id" class="form-control">
                    <option value="">-- Select Sesi --</option>
                    <?php foreach ($sesi as $sesi): ?>
                        <option value="<?= $sesi->id_sesi ?>"><?= $sesi->namasesi ?> </option>
                    <?php endforeach; ?>
                </select>
                <?= form_error('id_sesi', '<div class="text-small text-danger">', '</div>'); ?>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label>&nbsp;</label>
        <div class="d-flex justify-content-center">
            <button type="button" class="btn btn-secondary mr-4" onclick="window.history.back();">
                <i class="fas fa-times"></i> Cancel
            </button>
            <button type="submit" class="btn btn-success">
                <i class="fas fa-check"></i> Simpan
            </button>
        </div>
    </div>
</form>

<script>
    $(document).ready(function() {
        $('#bandwithSelect').on('change', function() {
            var harga = $(this).find(':selected').data('harga');
            if (harga) {
                var formatted = new Intl.NumberFormat('id-ID').format(harga);
                $('#tarif').val('Rp. ' + formatted);
            } else {
                $('#tarif').val('');
            }
        });
    });

    $(document).ready(function() {
        $('#site_id').change(function() {
            var siteId = $(this).val();
            if (siteId) {
                $.ajax({
                    url: "<?= base_url('user/get_kodepelanggan/') ?>" + siteId,
                    type: "GET",
                    dataType: "json",
                    success: function(response) {
                        $('#username').val(response.username);
                        var generatedPassword = generateRandomPassword(10);
                        $('#password').val(generatedPassword);
                    },
                    error: function(xhr) {
                        console.log("Gagal:", xhr.responseText);
                    }
                });
            } else {
                $('#username').val('');
                $('#password').val('');
            }
        });
    });

    function generateRandomPassword(length = 10) {
        var chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        var password = '';
        for (var i = 0; i < length; i++) {
            password += chars.charAt(Math.floor(Math.random() * chars.length));
        }
        return password;
    }

    function togglePassword() {
        const passwordField = document.getElementById('password');
        const icon = document.getElementById('toggle-icon');
        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            passwordField.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
</script>