<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_voucher extends CI_Model
{
    // Fungsi untuk menambahkan voucher
    public function insert_vouchers($vouchers)
    {
        $this->db->insert_batch('user', $vouchers); // Menyimpan data voucher ke dalam tabel 'user'
    }

    public function update_data($where, $data)
    {
        $this->db->where($where);
        $this->db->update('user', $data);
    }


    // Fungsi untuk mengambil semua data dari tabel 'bandwith'
    public function get_all_bandwidth()
    {
        $query = $this->db->get('bandwith');
        if ($query->num_rows() > 0) {
            return $query->result();  // Mengembalikan hasil query jika ada data
        }
        return []; // Mengembalikan array kosong jika tidak ada data
    }

    // Fungsi untuk mengambil semua data dari tabel 'sesi'
    public function get_all_sesi()
    {
        $query = $this->db->get('sesi');
        if ($query->num_rows() > 0) {
            return $query->result(); // Mengembalikan hasil query jika ada data
        }
        return []; // Mengembalikan array kosong jika tidak ada data
    }
}
