<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Akun extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Load semua library, model, dan helper yang diperlukan
        $this->load->model('Akun_model');
        $this->load->library(['form_validation', 'upload', 'session']);
        $this->load->helper(['url', 'form', 'file']);
        $this->check_login();
    }

    // Metode untuk memeriksa status login pengguna
    private function check_login()
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
    }

    // Menampilkan halaman profil akun dengan data pengguna
    public function index()
    {
        $user_id = $this->session->userdata('user_id');
        $akun = $this->Akun_model->get_akun($user_id);

        // Memberikan objek default jika akun tidak ditemukan
        if (!$akun) {
            $akun = (object) [
                'username' => '',
                'nama'     => '',
                'no_hp'    => '',
                'email'    => '',
                'foto'     => 'default.png', // Memberi nilai default foto
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

    // Memproses pembaruan data akun dan foto profil
    public function update_akun()
    {
        $user_id = $this->session->userdata('user_id');

        // Mengatur aturan validasi untuk setiap field
        $this->form_validation->set_rules('username', 'Username', 'trim|required');
        $this->form_validation->set_rules('nama', 'Nama', 'trim|required');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('no_hp', 'Nomor HP', 'trim|required|numeric');

        // Jalankan validasi
        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('akun');
        }

        $data = [
            'username' => $this->input->post('username', TRUE),
            'nama'     => $this->input->post('nama', TRUE),
            'email'    => $this->input->post('email', TRUE),
            'no_hp'    => $this->input->post('no_hp', TRUE),
        ];

        $foto_lama = $this->input->post('foto_lama', TRUE);
        $upload_path = './uploads/foto_profil/';

        // Proses upload foto jika ada file baru yang diunggah
        if (!empty($_FILES['foto']['name'])) {
            if (!is_dir($upload_path)) {
                mkdir($upload_path, 0755, true);
            }

            $config['upload_path']   = $upload_path;
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['max_size']      = 2048; // 2 MB dalam KB
            $config['encrypt_name']  = TRUE;

            $this->upload->initialize($config);

            if ($this->upload->do_upload('foto')) {
                $upload_data = $this->upload->data();
                $data['foto'] = $upload_data['file_name'];

                // Perbarui sesi dengan foto baru
                $this->session->set_userdata('foto', $upload_data['file_name']);

                // Hapus foto lama jika ada dan bukan foto default
                if (!empty($foto_lama) && $foto_lama !== 'default.png' && file_exists($upload_path . $foto_lama)) {
                    unlink($upload_path . $foto_lama);
                }
            } else {
                // Tangkap dan kirim pesan error spesifik dari upload library
                $error_message = $this->upload->display_errors();
                $this->session->set_flashdata('error', strip_tags($error_message));
                redirect('akun');
            }
        }

        // Lakukan pembaruan ke database
        if ($this->Akun_model->update_akun($user_id, $data)) {
            $this->session->set_flashdata('message', 'Data akun berhasil diperbarui.');
        } else {
            $this->session->set_flashdata('error', 'Gagal memperbarui data akun.');
        }

        redirect('akun');
    }

    // Memproses pembaruan password
    public function update_password()
    {
        $user_id = $this->session->userdata('user_id');

        // Aturan validasi untuk password
        $this->form_validation->set_rules('password_lama', 'Password Lama', 'required');
        $this->form_validation->set_rules('password_baru', 'Password Baru', 'required|min_length[6]');
        $this->form_validation->set_rules('konfirmasi_password', 'Konfirmasi Password', 'required|matches[password_baru]');

        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('akun');
        }

        $password_lama = $this->input->post('password_lama');
        $password_baru = $this->input->post('password_baru');
        $akun = $this->Akun_model->get_akun($user_id);

        if (!$akun || !isset($akun->password) || md5($password_lama) !== $akun->password) {
            $this->session->set_flashdata('error', 'Password lama tidak cocok.');
            redirect('akun');
        }

        $data = ['password' => md5($password_baru)];

        if ($this->Akun_model->update_akun($user_id, $data)) {
            $this->session->set_flashdata('message', 'Password berhasil diperbarui.');
        } else {
            $this->session->set_flashdata('error', 'Gagal memperbarui password.');
        }

        redirect('akun');
    }
}
