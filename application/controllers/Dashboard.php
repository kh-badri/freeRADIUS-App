<?php

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->database(); // Pastikan database sudah dimuat
        $this->check_login(); // Pastikan user sudah login
    }

    // Fungsi untuk cek login
    private function check_login()
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login'); // Redirect ke login jika belum login
        }
    }

    // Fungsi untuk menampilkan dashboard
    public function index()
    {
        $data['title'] = 'Dashboard';
        $data['dark_mode'] = true; // Aktifkan dark mode

        $data['title'] = 'Dashboard';

        // Menambahkan flashdata pesan sukses login jika ada
        if ($this->session->flashdata('success')) {
            $data['success_message'] = $this->session->flashdata('success');
        }

        // Menambahkan flashdata pesan error jika ada
        if ($this->session->flashdata('error')) {
            $data['error_message'] = $this->session->flashdata('error');
        }

        // Query untuk menghitung jumlah user dan voucher
        $query_user_voucher = $this->db->query("
            SELECT 
                SUM(CASE WHEN type IS NULL OR type != 'voucher' THEN 1 ELSE 0 END) AS total_user,
                SUM(CASE WHEN type = 'voucher' THEN 1 ELSE 0 END) AS total_voucher
            FROM user
        ");
        $result_user_voucher = $query_user_voucher->row();

        // Query untuk menghitung jumlah layanan dari tabel bandwidth
        $query_bandwith = $this->db->query("SELECT COUNT(*) AS total_layanan FROM bandwith");
        $result_bandwith = $query_bandwith->row();

        // Query untuk menghitung jumlah kategori dari tabel kategori
        $query_kategori = $this->db->query("SELECT COUNT(*) AS total_kategori FROM kategori");
        $result_kategori = $query_kategori->row();

        // Query untuk menghitung jumlah nas dari tabel nas
        $query_nas = $this->db->query("SELECT COUNT(*) AS total_nas FROM nas");
        $result_nas = $query_nas->row();

        // Query untuk menghitung jumlah sesi dari tabel sesi
        $query_sesi = $this->db->query("SELECT COUNT(*) AS total_sesi FROM sesi");
        $result_sesi = $query_sesi->row();


        // Menyimpan hasil query ke dalam array data
        $data['total_user'] = $result_user_voucher->total_user;
        $data['total_voucher'] = $result_user_voucher->total_voucher;
        $data['total_layanan'] = $result_bandwith->total_layanan;
        $data['total_kategori'] = $result_kategori->total_kategori;
        $data['total_nas'] = $result_nas->total_nas;
        $data['total_sesi'] = $result_sesi->total_sesi;

        // Kirim data ke view
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('dashboard', $data); // Mengirimkan data ke view
        $this->load->view('templates/footer');
    }
}
