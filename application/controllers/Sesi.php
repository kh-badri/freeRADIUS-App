<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sesi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('sesi_model');
        $this->check_login();
    }

    //Cek Login user
    private function check_login()
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login'); // Redirect ke login jika belum login
        }
    }

    public function index()
    {
        $data['title'] = 'Sesi Waktu';
        $data['sesi'] = $this->sesi_model->get_data('sesi')->result();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('sesi', $data);
        $this->load->view('templates/footer');
    }
    public function tambah()
    {
        $data['title'] = 'Tambah Sesi';

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('tambah_sesi');
        $this->load->view('templates/footer');
    }

    public function tambah_aksi()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->tambah();
        } else {
            $namasesi = $this->input->post('namasesi');
            $nilaisesi = $this->input->post('nilaisesi');

            // Cek apakah nama sesi sudah ada
            $exists = $this->db->where('namasesi', $namasesi)->get('sesi')->num_rows();

            if ($exists > 0) {
                $this->session->set_flashdata('error', 'Data sesi sudah ada !');
                redirect('sesi/tambah');
            } else {
                $data = array(
                    'namasesi'   => $namasesi,
                    'nilaisesi'  => $nilaisesi,
                );
                $this->sesi_model->insert_data($data, 'sesi');
                $this->session->set_flashdata('pesan', 'Data Berhasil Ditambahkan!');
                redirect('sesi');
            }
        }
    }

    public function edit($id)
    {
        $namasesi = $this->input->post('namasesi');
        $nilaisesi = $this->input->post('nilaisesi');

        // Cek duplikasi nama sesi (kecuali dirinya sendiri)
        $exists = $this->db->where('namasesi', $namasesi)
            ->where('id_sesi !=', $id)
            ->get('sesi')->num_rows();

        if ($exists > 0) {
            $this->session->set_flashdata('error', 'Data Sesi sudah ada !');
            redirect('sesi');
        }

        $this->db->where('id_sesi', $id)->update('sesi', [
            'namasesi' => $namasesi,
            'nilaisesi' => $nilaisesi
        ]);

        $this->session->set_flashdata('pesan', 'Data sesi berhasil diubah!');
        redirect('sesi');
    }


    public function _rules()
    {
        $this->form_validation->set_rules('namasesi', 'Jenis Layana', 'required', array(
            'required' => '%s wajib diisi !'
        ));

        $this->form_validation->set_rules('nilaisesi', 'nilai', 'required', array(
            'required' => '%s wajib diisi !'
        ));
    }

    public function delete($id)
    {
        $where = array('id_sesi' => $id);
        $this->sesi_model->delete($where, 'sesi');
        $this->session->set_flashdata('pesan', 'Data Berhasil Dihapus !');
        redirect('sesi');
    }
}
