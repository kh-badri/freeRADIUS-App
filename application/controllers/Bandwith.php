<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Bandwith extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->check_login();
        $this->load->model('bandwith_model');
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
        $data['title'] = 'Layanan';
        // Tidak perlu memanggil result() karena data sudah berupa array
        $data['bandwith'] = $this->bandwith_model->get_data('bandwith');
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('bandwith', $data);
        $this->load->view('templates/footer');
    }

    public function tambah()
    {
        $data['title'] = 'Tambah Layanan';

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('tambah_bandwith');
        $this->load->view('templates/footer');
    }

    // application/controllers/Bandwith.php
    public function tambah_aksi()
    {
        $this->load->model('Bandwith_model');

        $namapaket = $this->input->post('namapaket');
        $nilaipaket = $this->input->post('nilaipaket');
        $harga = $this->input->post('harga');

        // Cek apakah nama paket sudah ada
        if ($this->Bandwith_model->cek_duplicated_bandwith($namapaket)) {
            $this->session->set_flashdata('error', 'paket sudah ada!');
            redirect('bandwith');
            return;
        }

        $this->form_validation->set_rules('namapaket', 'Nama Paket', 'required');
        $this->form_validation->set_rules('nilaipaket', 'Nilai Paket', 'required');
        $this->form_validation->set_rules('harga', 'Harga', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('pesan', validation_errors());
            redirect('bandwith');
        } else {
            $data = array(
                'namapaket'   => $namapaket,
                'nilaipaket'  => $nilaipaket,
                'harga'       => $harga,
            );

            $this->Bandwith_model->insert_data($data, 'bandwith');
            $this->session->set_flashdata('pesan', 'Data berhasil ditambahkan');
            redirect('bandwith');
        }
    }


    public function edit($id_bw)
    {
        $this->_rules();

        $namapaket  = $this->input->post('namapaket');
        $nilaipaket = $this->input->post('nilaipaket');
        $harga      = $this->input->post('harga');

        // Cek jika nama paket sudah ada untuk ID lain
        if ($this->bandwith_model->cek_duplicated_bandwith_update($namapaket, $id_bw)) {
            $this->session->set_flashdata('error', 'Data paket sudah ada!');
            redirect('bandwith');
            return;
        }

        if ($this->form_validation->run() == FALSE) {
            $this->index();
        } else {
            $data = array(
                'id_bw'      => $id_bw,
                'namapaket'  => $namapaket,
                'nilaipaket' => $nilaipaket,
                'harga'      => $harga,
            );

            $this->bandwith_model->update_data($data, 'bandwith');
            $this->session->set_flashdata('pesan', 'Data Berhasil Diupdate');
            redirect('bandwith');
        }
    }


    public function _rules()
    {
        $this->form_validation->set_rules('namapaket', 'Jenis Layanan', 'required', array(
            'required' => '%s wajib diisi !'
        ));
    }

    public function delete($id)
    {
        $where = array('id_bw' => $id);
        $this->bandwith_model->delete($where, 'bandwith');
        $this->session->set_flashdata('pesan', 'Data Berhasil Dihapus');
        redirect('bandwith');
    }
}
