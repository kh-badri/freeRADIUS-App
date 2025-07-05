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
        $data['kategori'] = $this->db->get('kategori')->result();
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
        $data['kategori'] = $this->db->get('kategori')->result();
        $data['site'] = $this->site_model->get_all();

        // Ambil nilai unik dari kolom tipe_kategori
        $data['tipe_koneksi'] = $this->db->select('DISTINCT(tipe_kategori) as koneksi')->from('kategori')->get()->result();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('tambah_user', $data);
        $this->load->view('templates/footer');
    }


    public function tambah_aksi()
    {
        $this->form_validation->set_rules('username', 'Username', 'required');
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
            ];

            $optional_fields = ['nama_pelanggan', 'alamat', 'nomor_hp', 'ipaddress', 'kategori_id', 'site_id'];
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
        $this->form_validation->set_rules('bandwith_id', 'Layanan', 'required');
        $this->form_validation->set_rules('sesi_id', 'Sesi', 'required');
        $this->form_validation->set_rules('username', 'Username', 'required');

        if ($this->form_validation->run() == FALSE) {
            $data['user'] = $this->user_model->getUserById($id_user);
            $data['bandwith'] = $this->db->get('bandwith')->result();
            $data['sesi'] = $this->db->get('sesi')->result();
            $data['kategori'] = $this->db->get('kategori')->result();
            $data['site'] = $this->site_model->get_all();

            // Ambil semua koneksi unik dari tipe_kategori di tabel kategori
            $data['tipe_koneksi'] = $this->db
                ->select('DISTINCT(tipe_kategori) as koneksi')
                ->from('kategori')
                ->get()
                ->result();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('user', $data); // Modal edit berada di dalam view 'user.php'
            $this->load->view('templates/footer');
        } else {
            $update_data = [
                'nama_pelanggan' => $this->input->post('nama_pelanggan'),
                'alamat' => $this->input->post('alamat'),
                'nomor_hp' => $this->input->post('nomor_hp'),
                'username' => $this->input->post('username'),
                'password' => $this->input->post('password'),
                'expiration' => $this->input->post('expiration'),
                'simuluse' => $this->input->post('simuluse'),
                'ipaddress' => $this->input->post('ipaddress'),
                'kategori_id' => $this->input->post('kategori_id'),
                'site_id' => $this->input->post('site_id'),
                'bandwith_id' => $this->input->post('bandwith_id'),
                'sesi_id' => $this->input->post('sesi_id'),
                'koneksi' => $this->input->post('koneksi') // tambahkan field koneksi
            ];

            $where = ['id_user' => $id_user];
            $this->user_model->update_data($where, $update_data, 'user');

            $this->session->set_flashdata('pesan', 'Data berhasil diperbarui!');
            redirect('user');
        }
    }

    public function delete($id)
    {
        $where = ['id_user' => $id];
        $this->user_model->delete($where, 'user');
        $this->session->set_flashdata('pesan', 'Data berhasil dihapus.');
        redirect('user');
    }
}
