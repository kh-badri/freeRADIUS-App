<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Auth_model');
        $this->load->library('session');
        $this->load->library('form_validation');  // Pastikan form_validation dimuat
    }

    public function login()
    {
        // Jika sudah login, redirect ke dashboard
        if ($this->session->userdata('logged_in')) {
            redirect('dashboard');
        }

        // Set aturan validasi form
        $this->form_validation->set_rules('username', 'Username', 'required|min_length[4]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[8]');

        // Jika validasi form gagal
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('auth/login'); // Tampilkan form login jika validasi gagal
        } else {
            // Ambil input dari form
            $username = $this->input->post('username');
            $password = $this->input->post('password');

            // Cek login ke model
            $user = $this->Auth_model->check_login($username, $password);

            if ($user) {
                // Set sesi jika login berhasil
                $this->session->set_userdata([
                    'user_id' => $user->id_login,
                    'username' => $user->username,
                    'role' => $user->role,
                    'logged_in' => TRUE
                ]);
                // Set flashdata untuk pesan login berhasil
                $this->session->set_flashdata('success', 'Login successful! Welcome , ' . $user->username);
                redirect('dashboard');  // Redirect ke halaman dashboard setelah login
            } else {
                // Jika login gagal, set pesan error
                $this->session->set_flashdata('error', 'Invalid username or password');
                redirect('auth/login');
            }
        }
    }


    public function logout()
    {
        // Hapus sesi dan redirect ke halaman login
        $this->session->sess_destroy();
        redirect('auth/login');
    }
}
