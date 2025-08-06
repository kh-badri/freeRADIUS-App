<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<!-- Tambahkan JS toastr dan jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>


<div class="row">
    <!-- Profil Akun -->
    <div class="col-md-6">
        <div class="box" style="border-radius: 5px; border: 1px solid #ddd; margin-bottom: 20px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
            <div class="box-header with-border" style="padding: 10px 15px; background-color: #f5f5f5; font-size: 18px; font-weight: bold;">
                <h3 class="box-title">Akun Anda</h3>
            </div>
            <div class="box-body" style="padding: 15px;">
                <table class="table">
                    <tr>
                        <td>Foto Profil</td>
                        <td>
                            <div style="position: relative;">
                                <img src="<?= !empty($akun->foto)
                                                ? base_url('uploads/foto_profil/' . htmlspecialchars($akun->foto, ENT_QUOTES, 'UTF-8'))
                                                : base_url('assets/images/default.png') ?>"
                                    alt="Foto Profil"
                                    class="avatar-profile"
                                    onclick="openModal(this.src)">
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

    <!-- Modal Pop-up -->
    <div id="imageModal" class="custom-modal" onclick="closeModal()">
        <span class="close-btn" onclick="closeModal()">×</span>
        <img class="modal-content" id="modalImage">
    </div>

    <!-- CSS -->
    <style>
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
            object-fit: cover;
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

    <!-- Form Update Akun & Password -->
    <div class="col-md-6">
        <!-- Form Update Data Akun -->
        <div class="box" style="border-radius: 5px; border: 1px solid #ddd; margin-bottom: 20px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
            <div class="box-header with-border" style="padding: 10px 15px; background-color: #f5f5f5; font-size: 18px; font-weight: bold;">
                <h3 class="box-title">Ubah Informasi Akun</h3>
            </div>
            <div class="box-body" style="padding: 15px;">
                <?= form_open_multipart('akun/update_akun') ?>
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" class="form-control"
                        value="<?= htmlspecialchars($akun->username, ENT_QUOTES, 'UTF-8') ?>" required>
                </div>
                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" name="nama" class="form-control"
                        value="<?= htmlspecialchars($akun->nama, ENT_QUOTES, 'UTF-8') ?>" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control"
                        value="<?= htmlspecialchars($akun->email, ENT_QUOTES, 'UTF-8') ?>" required>
                </div>
                <div class="form-group">
                    <label>No HP</label>
                    <input type="text" name="no_hp" class="form-control"
                        value="<?= htmlspecialchars($akun->no_hp, ENT_QUOTES, 'UTF-8') ?>" required>
                </div>
                <div class="form-group">
                    <label>Foto Profil</label>
                    <?php if (!empty($akun->foto)): ?>
                        <div style="margin-bottom: 10px;">
                            <img
                                src="<?= !empty($akun->foto) && file_exists('uploads/foto_profil/' . $akun->foto)
                                            ? base_url('uploads/foto_profil/' . htmlspecialchars($akun->foto, ENT_QUOTES, 'UTF-8')) . '?v=' . time()
                                            : base_url('assets/images/default.png') . '?v=' . time() ?>"
                                alt="Foto Profil"
                                class="avatar-profile"
                                onclick="openModal(this.src)">
                        </div>
                    <?php endif; ?>
                    <!-- Input untuk upload file baru -->
                    <input type="file" name="foto" class="form-control">
                    <!-- Input tersembunyi untuk mengirim foto lama -->
                    <input type="hidden" name="foto_lama" value="<?= htmlspecialchars($akun->foto, ENT_QUOTES, 'UTF-8') ?>">
                </div>

                <button type="submit" class="btn btn-danger">Perbarui Akun</button>
                <?= form_close() ?>
            </div>
        </div>

        <!-- Form Ubah Password -->
        <div class="box" style="border-radius: 5px; border: 1px solid #ddd; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
            <div class="box-header with-border" style="padding: 10px 15px; background-color: #f5f5f5; font-size: 18px; font-weight: bold;">
                <h3 class="box-title">Ubah Password</h3>
            </div>
            <div class="box-body" style="padding: 15px;">
                <?= form_open('akun/update_password') ?>
                <div class="form-group">
                    <label>Password Lama</label>
                    <input type="password" name="password_lama" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Password Baru</label>
                    <input type="password" name="password_baru" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Konfirmasi Password Baru</label>
                    <input type="password" name="konfirmasi_password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-warning">Perbarui Password</button>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript -->
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
        <?php if ($this->session->flashdata('message')): ?>
            toastr.success("<?= $this->session->flashdata('message'); ?>");
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