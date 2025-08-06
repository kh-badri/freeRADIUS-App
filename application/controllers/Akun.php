<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Akun extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Akun_model');
        $this->load->library(['form_validation', 'upload', 'session']);
        $this->load->helper(['url', 'form']);
        $this->check_login();
    }

    // Cek apakah user sudah login
    private function check_login()
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
    }

    // Tampilkan halaman profil akun
    public function index()
    {
        $user_id = $this->session->userdata('user_id');
        if (!$user_id) {
            redirect('auth/login');
        }

        $akun = $this->Akun_model->get_akun($user_id);
        if (!$akun) {
            // Jika akun tidak ditemukan, buat objek kosong default
            $akun = (object)[
                'username' => '',
                'nama' => '',
                'no_hp' => '',
                'email' => '',
                'foto' => null,
                'password' => ''
            ];
        }

        $data = [
            'akun' => $akun,
            'title' => 'Profil Akun'
        ];

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('akun', $data);
        $this->load->view('templates/footer');
    }

    public function update_akun()
    {
        $user_id = $this->session->userdata('user_id');

        // Rules validasi form data teks
        $this->form_validation->set_rules('username', 'Username', 'trim|required');
        $this->form_validation->set_rules('nama', 'Nama', 'trim|required');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('no_hp', 'Nomor HP', 'trim|required|numeric');

        // Cek validasi form data teks
        if ($this->form_validation->run() === FALSE) {
            // Jika validasi gagal, tampilkan error dan kembali
            $this->session->set_flashdata('error', validation_errors());
            redirect('akun');
        }

        // Jika validasi form berhasil, lanjutkan proses
        $data = [
            'username' => $this->input->post('username', TRUE),
            'nama'     => $this->input->post('nama', TRUE),
            'email'    => $this->input->post('email', TRUE),
            'no_hp'    => $this->input->post('no_hp', TRUE),
        ];

        $foto_lama = $this->input->post('foto_lama', TRUE);
        $upload_path = './uploads/foto_profil/';

        // Logika upload foto hanya berjalan jika ada file baru
        if (!empty($_FILES['foto']['name'])) {
            // Pastikan direktori ada
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

                $this->session->set_userdata('foto', $upload_data['file_name']);

                if (!empty($foto_lama) && $foto_lama !== 'default.png' && file_exists($upload_path . $foto_lama)) {
                    unlink($upload_path . $foto_lama);
                }
            } else {
                // Ini adalah bagian kritis! Pesan error dari CodeIgniter harus ditampilkan
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


    public function update_password()
    {
        $user_id = $this->session->userdata('user_id');

        $this->form_validation->set_rules('password_lama', 'Password Lama', 'required');
        $this->form_validation->set_rules('password_baru', 'Password Baru', 'required|min_length[6]');
        $this->form_validation->set_rules('konfirmasi_password', 'Konfirmasi Password', 'required|matches[password_baru]');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('akun');
        } else {
            $password_lama = $this->input->post('password_lama');
            $password_baru = $this->input->post('password_baru');

            $akun = $this->Akun_model->get_akun($user_id);

            if ($akun && isset($akun->password)) {
                if (md5($password_lama) === $akun->password) {
                    $data = ['password' => md5($password_baru)];

                    if ($this->Akun_model->update_akun($user_id, $data)) {
                        $this->session->set_flashdata('message', 'Password berhasil diperbarui.');
                    } else {
                        $this->session->set_flashdata('error', 'Gagal memperbarui password.');
                    }
                } else {
                    $this->session->set_flashdata('error', 'Password lama tidak cocok.');
                }
            } else {
                $this->session->set_flashdata('error', 'Akun tidak ditemukan.');
            }

            redirect('akun');
        }
    }
}
