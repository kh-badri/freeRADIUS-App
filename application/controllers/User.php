<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->model('site_model');
        $this->check_login();
    }

    private function check_login()
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
    }

    public function index()
    {
        $type = $this->input->get('type');

        $data['title'] = 'User';
        $data['user'] = $this->user_model->get_user_filtered($type);
        $data['bandwith'] = $this->db->get('bandwith')->result();
        $data['sesi'] = $this->db->get('sesi')->result();
        $data['site'] = $this->site_model->get_all();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('user', $data);
        $this->load->view('templates/footer');
    }

    public function get_kodepelanggan($site_id)
    {
        $username = $this->user_model->generateUsername($site_id);
        echo json_encode(['username' => $username]);
    }

    public function getUserById($id)
    {
        $user = $this->user_model->getUserById($id);
        echo json_encode($user ? $user : ['error' => 'User not found']);
    }

    public function tambah()
    {
        $data['title'] = 'Tambah User';
        $data['bandwith'] = $this->db->get('bandwith')->result();
        $data['sesi'] = $this->db->get('sesi')->result();
        $data['site'] = $this->site_model->get_all();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('tambah_user', $data);
        $this->load->view('templates/footer');
    }

    public function tambah_aksi()
    {
        $this->form_validation->set_rules('username', 'Username', 'required|is_unique[user.username]');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('expiration', 'Expiration', 'required');
        $this->form_validation->set_rules('simuluse', 'Simultaneous Use', 'required');
        $this->form_validation->set_rules('bandwith_id', 'Bandwith', 'required');
        $this->form_validation->set_rules('sesi_id', 'Sesi', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->tambah();
        } else {
            $data = [
                'username' => $this->input->post('username'),
                'password' => $this->input->post('password'),
                'expiration' => $this->input->post('expiration'),
                'simuluse' => $this->input->post('simuluse'),
                'bandwith_id' => $this->input->post('bandwith_id'),
                'sesi_id' => $this->input->post('sesi_id'),
                'kategori' => $this->input->post('kategori'),
                'koneksi' => $this->input->post('koneksi'),
            ];

            $optional_fields = ['nama_pelanggan', 'alamat', 'nomor_hp', 'ipaddress', 'site_id'];
            foreach ($optional_fields as $field) {
                $value = $this->input->post($field);
                if (!empty($value)) {
                    $data[$field] = $value;
                }
            }

            $this->user_model->insert_data($data, 'user');
            $this->session->set_flashdata('pesan', 'Data berhasil ditambahkan!');
            redirect('user');
        }
    }

    public function edit($id_user)
    {
        // Validasi minimal input
        $this->form_validation->set_rules('bandwith_id', 'Layanan', 'required');
        $this->form_validation->set_rules('sesi_id', 'Sesi', 'required');

        // Ambil data user berdasarkan ID
        $existing = $this->user_model->getUserById($id_user);

        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Edit User';
            $data['edit_user'] = $existing;
            $data['bandwith'] = $this->db->get('bandwith')->result();
            $data['sesi'] = $this->db->get('sesi')->result();
            $data['site'] = $this->site_model->get_all();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('edit_user', $data);
            $this->load->view('templates/footer');
        } else {
            // Fungsi bantu untuk cek kosong
            function get_input_or_existing($input, $existing_value)
            {
                $val = trim($input);
                return $val !== '' ? $val : $existing_value;
            }

            // Update data
            $update_data = [
                'nama_pelanggan' => get_input_or_existing($this->input->post('nama_pelanggan'), $existing->nama_pelanggan),
                'alamat'         => get_input_or_existing($this->input->post('alamat'), $existing->alamat),
                'nomor_hp'       => get_input_or_existing($this->input->post('nomor_hp'), $existing->nomor_hp),
                'username'       => $existing->username, // tidak diubah
                'expiration'     => get_input_or_existing($this->input->post('expiration'), $existing->expiration),
                'simuluse'       => get_input_or_existing($this->input->post('simuluse'), $existing->simuluse),
                'ipaddress'      => get_input_or_existing($this->input->post('ipaddress'), $existing->ipaddress),
                'site_id'        => get_input_or_existing($this->input->post('site_id'), $existing->site_id),
                'bandwith_id'    => get_input_or_existing($this->input->post('bandwith_id'), $existing->bandwith_id),
                'sesi_id'        => get_input_or_existing($this->input->post('sesi_id'), $existing->sesi_id),
                'kategori'       => get_input_or_existing($this->input->post('kategori'), $existing->kategori),
                'koneksi'        => get_input_or_existing($this->input->post('koneksi'), $existing->koneksi),
            ];

            // Password plaintext (tidak di-hash)
            $password = $this->input->post('password');
            $update_data['password'] = trim($password) !== '' ? $password : $existing->password;

            // Simpan ke database
            $this->user_model->update_data($id_user, $update_data);
            $this->session->set_flashdata('pesan', 'Data berhasil diperbarui!');
            redirect('user');
        }
    }


    public function delete($id)
    {
        if ($this->session->userdata('role') !== 'admin') {
            $this->session->set_flashdata('pesan', 'Akses ditolak.');
            redirect('user');
        }

        $where = ['id_user' => $id];
        $this->user_model->delete($where, 'user');
        $this->session->set_flashdata('pesan', 'Data berhasil dihapus.');
        redirect('user');
    }
}
