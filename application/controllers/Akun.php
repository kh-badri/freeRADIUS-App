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

        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('no_hp', 'Nomor HP', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->index(); // tampil ulang halaman dengan error
        } else {
            $data = [
                'username' => $this->input->post('username'),
                'nama'     => $this->input->post('nama'),
                'email'    => $this->input->post('email'),
                'no_hp'    => $this->input->post('no_hp'),
            ];

            $foto_lama = $this->input->post('foto_lama');
            $upload_path = './uploads/foto_profil/';

            if (!empty($_FILES['foto']['name'])) {
                if (!is_dir($upload_path)) {
                    mkdir($upload_path, 0755, true);
                }

                $config['upload_path']   = $upload_path;
                $config['allowed_types'] = 'jpg|jpeg|png|gif';
                $config['max_size']      = 2048;
                $config['encrypt_name']  = TRUE;

                $this->upload->initialize($config);

                if ($this->upload->do_upload('foto')) {
                    $upload_data = $this->upload->data();
                    $data['foto'] = $upload_data['file_name'];

                    // Update session foto agar sidebar ikut berubah
                    $this->session->set_userdata('foto', $upload_data['file_name']);

                    // Hapus foto lama jika ada
                    if (!empty($foto_lama) && file_exists($upload_path . $foto_lama)) {
                        unlink($upload_path . $foto_lama);
                    }
                } else {
                    log_message('error', 'Upload gagal: ' . $this->upload->display_errors());
                    $this->session->set_flashdata('error', strip_tags($this->upload->display_errors()));
                    redirect('akun');
                }
            }

            if ($this->Akun_model->update_akun($user_id, $data)) {
                $this->session->set_flashdata('message', 'Data akun berhasil diperbarui.');
            } else {
                $this->session->set_flashdata('error', 'Gagal memperbarui data akun.');
            }

            redirect('akun');
        }
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
