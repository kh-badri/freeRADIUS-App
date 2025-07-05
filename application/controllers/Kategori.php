<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kategori extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('kategori_model'); // Model sudah diload
        $this->check_login(); // Cek login sebelum semua aksi
    }

    // Cek Login user
    private function check_login()
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login'); // Redirect ke login jika belum login
        }
    }

    public function index()
    {
        $data['title'] = 'Kategori';
        $data['kategori'] = $this->kategori_model->get_data('kategori')->result();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('kategori', $data);
        $this->load->view('templates/footer');
    }

    public function tambah()
    {
        $data['title'] = 'Tambah Kategori';

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('tambah_kategori');
        $this->load->view('templates/footer');
    }

    public function tambah_aksi()
    {
        $namakategori  = $this->input->post('namakategori');
        $tipe_kategori = $this->input->post('tipe_kategori');
        $site          = $this->input->post('site');

        // Cek apakah data dengan kombinasi yang sama sudah ada
        $cek = $this->kategori_model->cek_duplicated($namakategori, $tipe_kategori, $site);

        if ($cek) {
            $this->session->set_flashdata('error', 'Data kategori sudah ada!');
            redirect('kategori');
        }

        $data = [
            'namakategori'  => $namakategori,
            'tipe_kategori' => $tipe_kategori,
            'site'          => $site
        ];

        $this->kategori_model->insert($data); // ✅ sudah diperbaiki dari Kategori_model
        $this->session->set_flashdata('pesan', 'Kategori berhasil ditambahkan.');
        redirect('kategori');
    }

    public function edit($id_kategori)
    {
        $this->_rules();
        if ($this->form_validation->run() == FALSE) {
            $this->index();
        } else {
            $namakategori  = $this->input->post('namakategori');
            $tipe_kategori = $this->input->post('tipe_kategori');
            $site          = $this->input->post('site');

            // Cek apakah data dengan kombinasi tersebut sudah ada selain data ini
            $cek = $this->kategori_model->cek_duplicated_update($id_kategori, $namakategori, $tipe_kategori, $site);
            if ($cek > 0) {
                $this->session->set_flashdata('error', 'Data kategori dengan kombinasi tersebut sudah ada!');
                redirect('kategori');
            } else {
                $data = [
                    'id_kategori'   => $id_kategori,
                    'namakategori'  => $namakategori,
                    'tipe_kategori' => $tipe_kategori,
                    'site'          => $site,
                ];

                $this->kategori_model->update_data($data, 'kategori');
                $this->session->set_flashdata('pesan', 'Data berhasil diupdate.');
                redirect('kategori');
            }
        }
    }

    public function delete($id)
    {
        $where = ['id_kategori' => $id];
        $this->kategori_model->delete($where, 'kategori');
        $this->session->set_flashdata('pesan', 'Data berhasil dihapus!');
        redirect('kategori');
    }

    public function _rules()
    {
        $this->form_validation->set_rules('namakategori', 'Kategori', 'required', [
            'required' => '%s wajib diisi!'
        ]);

        $this->form_validation->set_rules('site', 'Site', 'required', [
            'required' => '%s wajib diisi!'
        ]);
    }
}
