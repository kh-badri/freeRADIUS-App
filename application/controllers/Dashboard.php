<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->database(); // Memastikan koneksi database tersedia
        $this->check_login(); // Pastikan user sudah login
    }

    // Fungsi untuk cek apakah user sudah login
    private function check_login()
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
    }

    // Fungsi utama untuk menampilkan dashboard
    public function index()
    {
        $data['title'] = 'Dashboard';
        $data['dark_mode'] = true;

        // Flashdata jika ada pesan sukses atau error
        if ($this->session->flashdata('success')) {
            $data['success_message'] = $this->session->flashdata('success');
        }
        if ($this->session->flashdata('error')) {
            $data['error_message'] = $this->session->flashdata('error');
        }

        // Query: jumlah user dan jumlah voucher
        $query_user_voucher = $this->db->query("
        SELECT 
            SUM(CASE WHEN type IS NULL OR type != 'voucher' THEN 1 ELSE 0 END) AS total_user,
            SUM(CASE WHEN type = 'voucher' THEN 1 ELSE 0 END) AS total_voucher
        FROM user
    ");
        $result_user_voucher = $query_user_voucher->row();

        // Query: jumlah user aktif (type = 'home' dan belum expired)
        $query_user_aktif = $this->db->query("
        SELECT COUNT(*) AS total_user_aktif 
        FROM user 
        WHERE expiration >= CURDATE() AND type = 'home'
    ");
        $result_user_aktif = $query_user_aktif->row();

        // Query: jumlah user expired (type = 'home' dan sudah lewat expired)
        $query_user_expired = $this->db->query("
        SELECT COUNT(*) AS total_user_expired 
        FROM user 
        WHERE expiration < CURDATE() AND type = 'home'
    ");
        $result_user_expired = $query_user_expired->row();

        // Query: jumlah layanan
        $query_bandwith = $this->db->query("SELECT COUNT(*) AS total_layanan FROM bandwith");
        $result_bandwith = $query_bandwith->row();

        // Query: jumlah NAS
        $query_nas = $this->db->query("SELECT COUNT(*) AS total_nas FROM nas");
        $result_nas = $query_nas->row();

        // Query: jumlah sesi
        $query_sesi = $this->db->query("SELECT COUNT(*) AS total_sesi FROM sesi");
        $result_sesi = $query_sesi->row();

        $query_voucher_aktif = $this->db->query("
    SELECT COUNT(*) AS total_voucher_aktif 
    FROM user 
    WHERE expiration >= CURDATE() AND type = 'voucher'
");
        $result_voucher_aktif = $query_voucher_aktif->row();

        // Query: jumlah voucher expired (expiration sudah lewat dan type = 'voucher')
        $query_voucher_expired = $this->db->query("
    SELECT COUNT(*) AS total_voucher_expired 
    FROM user 
    WHERE expiration < CURDATE() AND type = 'voucher'
");
        $result_voucher_expired = $query_voucher_expired->row();

        // Kirim semua data ke view
        $data['total_user'] = $result_user_voucher->total_user;
        $data['total_voucher'] = $result_user_voucher->total_voucher;
        $data['total_user_aktif'] = $result_user_aktif->total_user_aktif;
        $data['total_user_expired'] = $result_user_expired->total_user_expired;
        $data['total_layanan'] = $result_bandwith->total_layanan;
        $data['total_nas'] = $result_nas->total_nas;
        $data['total_sesi'] = $result_sesi->total_sesi;
        // Masukkan ke dalam array data untuk view
        $data['total_voucher_aktif'] = $result_voucher_aktif->total_voucher_aktif;
        $data['total_voucher_expired'] = $result_voucher_expired->total_voucher_expired;

        // Load semua view
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('dashboard', $data);
        $this->load->view('templates/footer');
    }
}
