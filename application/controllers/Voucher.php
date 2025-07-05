<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Voucher extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_voucher');
        $this->load->library('session');
    }

    public function index()
    {
        $data['title'] = 'Voucher';
        $data['bandwidth'] = $this->Model_voucher->get_all_bandwidth();
        $data['sesi'] = $this->Model_voucher->get_all_sesi();
        $data['pesan'] = $this->session->flashdata('pesan');

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('voucher', $data);
        $this->load->view('templates/footer');
    }

    public function generate()
    {
        // Mengambil data input dari form
        $type = $this->input->post('type');
        $prefix = $this->input->post('prefix');
        $jumlah = $this->input->post('jumlah');
        $expiration = $this->input->post('expiration');
        $simuluse = $this->input->post('simuluse');
        $bandwith_id = $this->input->post('bandwith_id');
        $sesi_id = $this->input->post('sesi_id');

        if (empty($prefix) || empty($jumlah) || empty($expiration) || empty($simuluse) || empty($bandwith_id) || empty($sesi_id)) {
            $this->session->set_flashdata('pesan', 'Semua field harus diisi!');
            redirect('voucher');
            return;
        }

        try {
            $vouchers = [];
            for ($i = 0; $i < $jumlah; $i++) {
                $username = $prefix . strtoupper(bin2hex(random_bytes(2)));
                $password = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
                $vouchers[] = [
                    'type' => $type,
                    'username' => $username,
                    'password' => $password, // Password tanpa hashing
                    'expiration' => $expiration,
                    'simuluse' => $simuluse,
                    'bandwith_id' => $bandwith_id,
                    'sesi_id' => $sesi_id,
                ];
            }

            // Simpan ke database
            $this->Model_voucher->insert_vouchers($vouchers);

            // Lakukan update setelah insert dengan data yang sama
            $update_data = ['expiration' => $expiration]; // Data yang ingin diupdate
            $this->Model_voucher->update_data(['expiration' => $expiration], $update_data);

            // Set pesan sukses
            $this->session->set_flashdata('pesan', 'Berhasil! </strong> ' . $jumlah . ' voucher telah Ditambahkan !');
        } catch (Exception $e) {
            // Set pesan error jika ada exception saat generate random bytes atau insert database
            $this->session->set_flashdata('pesan', 'Gagal Generate Voucher !');
        }

        // Redirect kembali ke halaman voucher
        redirect('voucher');
    }
}
