<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Site extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
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
        $data['title'] = 'Data Site';
        $data['site'] = $this->site_model->get_all();


        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('site', $data);
        $this->load->view('templates/footer');
    }

    public function tambah()
    {
        $data['title'] = 'Tambah Site';

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('tambah_site');
        $this->load->view('templates/footer');
    }

    public function tambah_aksi()
    {
        $this->form_validation->set_rules('namasite', 'Nama Site', 'required');
        $this->form_validation->set_rules('kodesite', 'Kode Site', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->tambah();
        } else {
            $data = [
                'namasite' => $this->input->post('namasite', true),
                'kodesite' => $this->input->post('kodesite', true)
            ];

            $this->site_model->insert_data($data, 'site');

            $this->session->set_flashdata('pesan', 'Data berhasil ditambahkan!');
            redirect('site');
        }
    }

    public function edit($id_site)
    {
        $this->form_validation->set_rules('namasite', 'Nama Site', 'required');
        $this->form_validation->set_rules('kodesite', 'Kode Site', 'required');

        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Edit Site';
            $data['site'] = $this->site_model->get_site_by_id($id_site);

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('edit_site', $data);
            $this->load->view('templates/footer');
        } else {
            $data = [
                'id_site' => $id_site,
                'namasite' => $this->input->post('namasite', true),
                'kodesite' => $this->input->post('kodesite', true)
            ];

            $this->site_model->update_data($data, 'site');

            $this->session->set_flashdata('pesan', 'Data berhasil diperbarui!');
            redirect('site');
        }
    }

    public function delete($id_site)
    {
        $where = ['id_site' => $id_site];
        $this->site_model->delete($where, 'site');

        $this->session->set_flashdata('pesan', 'Data berhasil dihapus!');
        redirect('site');
    }
}
