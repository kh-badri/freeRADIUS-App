<form action="<?= base_url('kategori/tambah_aksi') ?>" method="post" class="ml-2">
    <div class="form-group">
        <label>Kategori Layanan</label>
        <input
            type="text"
            name="namakategori"
            id="namakategori"
            class="form-control"
            placeholder="Broadband, Dedicated, Dll..">
        <?= form_error('namakategori', '<div class="text-small text-danger">', '</div>'); ?>
    </div>
    <div class="form-group">
        <label>Tipe Koneksi</label>
        <select name="tipe_kategori" id="tipe_kategori" class="form-control">
            <option value="">-- Pilih Tipe Koneksi --</option>
            <option value="Fiber Optic">Fiber Optic</option>
            <option value="Wireless">Wireless</option>
        </select>
        <?= form_error('tipe_kategori', '<div class="text-small text-danger">', '</div>'); ?>
    </div>


    <button type="submit" class="btn btn-primary mr-4"><i class="fas fa-save"></i> Tambah</button>
</form>