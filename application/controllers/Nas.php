<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Nas extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('nas_model');
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
        $data['title'] = 'Nas';
        $data['nas'] = $this->nas_model->get_data('nas')->result();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('nas', $data);
        $this->load->view('templates/footer');
    }
    public function tambah()
    {
        $data['title'] = 'Tambah Nas';

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('tambah_nas');
        $this->load->view('templates/footer');
    }

    public function tambah_aksi()
    {
        $this->_rules();
        if ($this->form_validation->run() == FALSE) {
            $this->tambah();
        } else {
            $data = array(
                'nasname' => $this->input->post('nasname'),
                'shortname' => $this->input->post('shortname'),
                'type' => $this->input->post('type'),
                'secret' => $this->input->post('secret'),
                'community' => $this->input->post('community'),
            );
            $this->nas_model->insert_data($data, 'nas');
            $this->session->set_flashdata('pesan', 'Data Berhasil Ditambahkan !');
            redirect('nas');
        }
    }
    public function edit($id_nas)
    {
        $this->_rules();
        if ($this->form_validation->run() == FALSE) {
            $this->index();
        } else {
            $data = array(
                'id_nas' => $id_nas,
                'nasname' => $this->input->post('nasname'),
                'shortname' => $this->input->post('shortname'),
                'type' => $this->input->post('type'),
                'secret' => $this->input->post('secret'),
                'community' => $this->input->post('community'),
            );
            $this->nas_model->update_data($data, 'nas');
            $this->session->set_flashdata('pesan', 'Data Berhasil Diupdate !');
            redirect('nas');
        }
    }

    public function _rules()
    {
        $this->form_validation->set_rules('nasname', 'IP Server', 'required', array(
            'required' => '%s wajib diisi !'
        ));
        $this->form_validation->set_rules('shortname', 'Short Name', 'required', array(
            'required' => '%s wajib diisi !'
        ));
        $this->form_validation->set_rules('type', 'Type', 'required', array(
            'required' => '%s wajib diisi !'
        ));
        $this->form_validation->set_rules('secret', 'Secret', 'required', array(
            'required' => '%s wajib diisi !'
        ));
        $this->form_validation->set_rules('community', 'Community', 'required', array(
            'required' => '%s wajib diisi !'
        ));
    }

    public function delete($id)
    {
        $where = array('id_nas' => $id);
        $this->nas_model->delete($where, 'nas');
        $this->session->set_flashdata('pesan', 'Data Berhasil Dihapus !');
        redirect('nas');
    }
}
