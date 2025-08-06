<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Akun extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Load model, library, dan helper
        $this->load->model('Akun_model');
        $this->load->library(['form_validation', 'upload', 'session']);
        $this->load->helper(['url', 'form', 'file']); // Menambah helper file untuk penanganan file
        $this->check_login();
    }

    /**
     * @access private
     * Metode untuk memeriksa status login pengguna.
     * Jika belum login, redirect ke halaman login.
     */
    private function check_login()
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
    }

    /**
     * Menampilkan halaman profil akun.
     */
    public function index()
    {
        $user_id = $this->session->userdata('user_id');

        // Mengambil data akun berdasarkan user_id.
        // Jika tidak ada, get_akun() di model harusnya mengembalikan null.
        $akun = $this->Akun_model->get_akun($user_id);

        // Memastikan objek $akun ada untuk menghindari error jika data kosong.
        if (!$akun) {
            $akun = (object) [
                'username' => '',
                'nama'     => '',
                'no_hp'    => '',
                'email'    => '',
                'foto'     => 'default.png', // Memberikan nilai default foto
                'password' => ''
            ];
        }

        $data = [
            'akun'  => $akun,
            'title' => 'Profil Akun'
        ];

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('akun', $data);
        $this->load->view('templates/footer');
    }

    /**
     * Memperbarui informasi akun (username, nama, email, no_hp, foto).
     */
    public function update_akun()
    {
        // Mendapatkan ID pengguna dari session
        $user_id = $this->session->userdata('user_id');

        // Set rules validasi untuk input data teks
        $this->form_validation->set_rules('username', 'Username', 'trim|required');
        $this->form_validation->set_rules('nama', 'Nama', 'trim|required');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('no_hp', 'Nomor HP', 'trim|required|numeric'); // Menambah validasi numeric

        if ($this->form_validation->run() === FALSE) {
            // Jika validasi form gagal, tampilkan error dan kembali ke halaman profil
            $this->session->set_flashdata('error', validation_errors());
            redirect('akun');
        } else {
            // Data untuk di-update ke database
            $data = [
                'username' => $this->input->post('username', TRUE), // Gunakan TRUE untuk XSS filtering
                'nama'     => $this->input->post('nama', TRUE),
                'email'    => $this->input->post('email', TRUE),
                'no_hp'    => $this->input->post('no_hp', TRUE),
            ];

            // Inisialisasi variabel untuk upload foto
            $foto_lama = $this->input->post('foto_lama', TRUE);
            $upload_path = './uploads/foto_profil/';

            // Proses upload foto jika ada file yang diunggah
            if (!empty($_FILES['foto']['name'])) {
                // Pastikan direktori upload ada
                if (!is_dir($upload_path)) {
                    mkdir($upload_path, 0755, true);
                }

                $config['upload_path']   = $upload_path;
                $config['allowed_types'] = 'jpg|jpeg|png|gif';
                $config['max_size']      = 2048; // Maksimum 2 MB
                $config['encrypt_name']  = TRUE;

                $this->upload->initialize($config);

                if ($this->upload->do_upload('foto')) {
                    $upload_data = $this->upload->data();
                    $data['foto'] = $upload_data['file_name'];

                    // Update session foto pengguna
                    $this->session->set_userdata('foto', $upload_data['file_name']);

                    // Hapus foto lama jika bukan foto default
                    if (!empty($foto_lama) && $foto_lama !== 'default.png' && file_exists($upload_path . $foto_lama)) {
                        unlink($upload_path . $foto_lama);
                    }
                } else {
                    // Jika upload gagal, set pesan error dan redirect
                    $error = $this->upload->display_errors('', '');
                    $this->session->set_flashdata('error', 'Gagal mengunggah foto: ' . strip_tags($error));
                    redirect('akun');
                }
            }

            // Lakukan update data di model
            if ($this->Akun_model->update_akun($user_id, $data)) {
                $this->session->set_flashdata('message', 'Data akun berhasil diperbarui.');
            } else {
                $this->session->set_flashdata('error', 'Gagal memperbarui data akun.');
            }

            redirect('akun');
        }
    }

    /**
     * Memperbarui password pengguna.
     */
    public function update_password()
    {
        // Mendapatkan ID pengguna dari session
        $user_id = $this->session->userdata('user_id');

        // Set rules validasi untuk password
        $this->form_validation->set_rules('password_lama', 'Password Lama', 'required');
        $this->form_validation->set_rules('password_baru', 'Password Baru', 'required|min_length[6]');
        $this->form_validation->set_rules('konfirmasi_password', 'Konfirmasi Password', 'required|matches[password_baru]');

        if ($this->form_validation->run() === FALSE) {
            // Jika validasi gagal, set pesan error dan redirect
            $this->session->set_flashdata('error', validation_errors());
            redirect('akun');
        } else {
            $password_lama = $this->input->post('password_lama');
            $password_baru = $this->input->post('password_baru');

            $akun = $this->Akun_model->get_akun($user_id);

            // Verifikasi password lama
            if (!$akun || !isset($akun->password) || md5($password_lama) !== $akun->password) {
                $this->session->set_flashdata('error', 'Password lama tidak cocok.');
                redirect('akun');
            }

            // Jika password lama benar, lakukan update password
            $data = ['password' => md5($password_baru)];

            if ($this->Akun_model->update_akun($user_id, $data)) {
                $this->session->set_flashdata('message', 'Password berhasil diperbarui.');
            } else {
                $this->session->set_flashdata('error', 'Gagal memperbarui password.');
            }

            redirect('akun');
        }
    }
}
