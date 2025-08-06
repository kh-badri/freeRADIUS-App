<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<!-- Tambahkan JS toastr dan jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>


<div class="row">
    <div class="col-md-6">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Akun Anda</h3>
            </div>
            <div class="box-body">
                <table class="table">
                    <tr>
                        <td>Foto Profil</td>
                        <td>
                            <div class="image-container">
                                <?php
                                $foto_url = base_url('assets/images/default.png');
                                if (!empty($akun->foto) && file_exists('./uploads/foto_profil/' . $akun->foto)) {
                                    $foto_url = base_url('uploads/foto_profil/' . htmlspecialchars($akun->foto, ENT_QUOTES, 'UTF-8')) . '?' . time();
                                }
                                ?>
                                <img src="<?= $foto_url ?>" alt="Foto Profil" class="avatar-profile" onclick="openModal(this.src)">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>Username</td>
                        <td><?= htmlspecialchars($akun->username, ENT_QUOTES, 'UTF-8') ?></td>
                    </tr>
                    <tr>
                        <td>Nama</td>
                        <td><?= htmlspecialchars($akun->nama, ENT_QUOTES, 'UTF-8') ?></td>
                    </tr>
                    <tr>
                        <td>No HP</td>
                        <td><?= htmlspecialchars($akun->no_hp, ENT_QUOTES, 'UTF-8') ?></td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td><?= htmlspecialchars($akun->email, ENT_QUOTES, 'UTF-8') ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Ubah Informasi Akun</h3>
            </div>
            <div class="box-body">
                <?= form_open_multipart('akun/update_akun', ['id' => 'form-update-akun']) ?>
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" class="form-control"
                        value="<?= set_value('username', htmlspecialchars($akun->username, ENT_QUOTES, 'UTF-8')) ?>">
                    <?= form_error('username', '<p class="text-danger">', '</p>') ?>
                </div>
                <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" name="nama" id="nama" class="form-control"
                        value="<?= set_value('nama', htmlspecialchars($akun->nama, ENT_QUOTES, 'UTF-8')) ?>">
                    <?= form_error('nama', '<p class="text-danger">', '</p>') ?>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-control"
                        value="<?= set_value('email', htmlspecialchars($akun->email, ENT_QUOTES, 'UTF-8')) ?>">
                    <?= form_error('email', '<p class="text-danger">', '</p>') ?>
                </div>
                <div class="form-group">
                    <label for="no_hp">No HP</label>
                    <input type="text" name="no_hp" id="no_hp" class="form-control"
                        value="<?= set_value('no_hp', htmlspecialchars($akun->no_hp, ENT_QUOTES, 'UTF-8')) ?>">
                    <?= form_error('no_hp', '<p class="text-danger">', '</p>') ?>
                </div>
                <div class="form-group">
                    <label for="foto">Foto Profil (Maks. 2MB, JPG/PNG/GIF)</label>
                    <?php if (!empty($akun->foto) && $akun->foto !== 'default.png'): ?>
                        <div class="current-photo">
                            <img src="<?= base_url('uploads/foto_profil/' . htmlspecialchars($akun->foto, ENT_QUOTES, 'UTF-8')) ?>"
                                alt="Foto Sekarang" class="img-thumbnail">
                        </div>
                    <?php endif; ?>
                    <input type="file" name="foto" id="foto" class="form-control">
                    <input type="hidden" name="foto_lama" value="<?= htmlspecialchars($akun->foto, ENT_QUOTES, 'UTF-8') ?>">
                </div>
                <button type="submit" class="btn btn-danger">Perbarui Akun</button>
                <?= form_close() ?>
            </div>
        </div>

        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Ubah Password</h3>
            </div>
            <div class="box-body">
                <?= form_open('akun/update_password') ?>
                <div class="form-group">
                    <label for="password_lama">Password Lama</label>
                    <input type="password" name="password_lama" id="password_lama" class="form-control">
                    <?= form_error('password_lama', '<p class="text-danger">', '</p>') ?>
                </div>
                <div class="form-group">
                    <label for="password_baru">Password Baru</label>
                    <input type="password" name="password_baru" id="password_baru" class="form-control">
                    <?= form_error('password_baru', '<p class="text-danger">', '</p>') ?>
                </div>
                <div class="form-group">
                    <label for="konfirmasi_password">Konfirmasi Password Baru</label>
                    <input type="password" name="konfirmasi_password" id="konfirmasi_password" class="form-control">
                    <?= form_error('konfirmasi_password', '<p class="text-danger">', '</p>') ?>
                </div>
                <button type="submit" class="btn btn-warning">Perbarui Password</button>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>

<div id="imageModal" class="custom-modal" onclick="closeModal()">
    <span class="close-btn">&times;</span>
    <img class="modal-content" id="modalImage">
</div>
<style>
    .box {
        border-radius: 5px;
        border: 1px solid #ddd;
        margin-bottom: 20px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .box-header.with-border {
        padding: 10px 15px;
        background-color: #f5f5f5;
        font-size: 18px;
        font-weight: bold;
    }

    .box-body {
        padding: 15px;
    }

    .table td {
        vertical-align: middle;
    }

    .avatar-profile {
        width: 160px;
        height: 160px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid #aaa;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        cursor: pointer;
        transition: transform 0.3s ease;
    }

    .avatar-profile:hover {
        transform: scale(1.05);
    }

    .image-container {
        position: relative;
    }

    .current-photo {
        margin-bottom: 10px;
    }

    .img-thumbnail {
        width: 120px;
        height: 120px;
        border-radius: 5px;
        object-fit: cover;
        border: 1px solid #ddd;
        padding: 4px;
        background-color: #fff;
    }

    .custom-modal {
        display: none;
        position: fixed;
        z-index: 9999;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.9);
        padding-top: 50px;
    }

    .modal-content {
        display: block;
        margin: auto;
        width: 400px;
        height: 400px;
        max-width: 90vw;
        max-height: 90vh;
        object-fit: contain;
        border-radius: 10px;
        animation: zoomIn 0.3s ease;
    }

    .close-btn {
        position: absolute;
        top: 20px;
        right: 30px;
        color: white;
        font-size: 40px;
        font-weight: bold;
        cursor: pointer;
    }

    .close-btn:hover {
        color: #ff4444;
    }

    @keyframes zoomIn {
        from {
            transform: scale(0.6);
        }

        to {
            transform: scale(1);
        }
    }
</style>
<script>
    $(document).ready(function() {
        toastr.options = {
            closeButton: true,
            progressBar: true,
            positionClass: "toast-top-right",
            showMethod: "slideDown",
            hideMethod: "slideUp",
            timeOut: 5000
        };

        <?php if ($this->session->flashdata('message')): ?>
            toastr.success("<?= $this->session->flashdata('message'); ?>");
        <?php endif; ?>

        <?php if ($this->session->flashdata('error')): ?>
            toastr.error("<?= $this->session->flashdata('error'); ?>");
        <?php endif; ?>
    });

    function openModal(src) {
        const modal = document.getElementById("imageModal");
        const modalImg = document.getElementById("modalImage");
        modal.style.display = "block";
        modalImg.src = src;
    }

    function closeModal() {
        document.getElementById("imageModal").style.display = "none";
    }
</script>