<form action="<?= base_url('bandwith/tambah_aksi') ?>" method="post" class="ml-2">
    <div class="form-group">
        <label>Bandwith</label>
        <input
            type="text"
            name="namapaket"
            id="namapaket"
            class="form-control"
            placeholder="code paket"
            oninput="updateNilaiPaket()">
        <?= form_error('namapaket', '<div class="text-small text-danger">', '</div>'); ?>
    </div>
    <div class="form-group">
        <label>Nilai</label>
        <input
            type="text"
            name="nilaipaket"
            id="nilaipaket"
            class="form-control"
            placeholder="M/M"
            readonly>
        <?= form_error('nilaipaket', '<div class="text-small text-danger">', '</div>'); ?>
    </div>
    <div class="form-group">
        <label>Harga</label>
        <input
            type="text"
            name="harga"
            id="harga"
            class="form-control"
            placeholder="Rp."
            oninput="updateNilaiPaket()">
        <?= form_error('harga', '<div class="text-small text-danger">', '</div>'); ?>
    </div>
    <button type="submit" class="btn btn-primary mr-4"><i class="fas fa-save"></i> Tambah</button>
</form>

<script>
    function updateNilaiPaket() {
        const namaPaket = document.getElementById("namapaket").value;

        // Cari angka pertama dalam string
        const match = namaPaket.match(/(\d+)/);

        if (match) {
            const angka = match[1]; // Ambil angka
            document.getElementById("nilaipaket").value = `${angka}M/${angka}M`;
        } else {
            document.getElementById("nilaipaket").value = "";
        }
    }
</script>