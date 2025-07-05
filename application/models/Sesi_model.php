<?php
defined('BASEPATH') or exit('No direct script acces allowed');

class Sesi_model extends CI_Model
{

    public function get_data($table)
    {
        return $this->db->get($table);
    }
    public function get_all_sesi()
    {
        return $this->db->get('sesi')->result();
    }
    public function insert_data($data, $table)
    {
        $this->db->insert($table, $data);
    }
    public function update_data($data, $table)
    {
        $this->db->where('id_sesi', $data['id_sesi']);
        $this->db->update($table, $data);
    }
    public function delete($where, $table)
    {
        $this->db->where($where);
        $this->db->delete($table);
    }
    // Metode untuk mengambil data dari tabel sesi
    public function get_sesi()
    {
        // Menjalankan query untuk mengambil semua data dari tabel sesi
        $query = $this->db->get('sesi');  // Pastikan nama tabel sesuai dengan yang ada di database
        return $query->result();  // Mengembalikan hasil query dalam bentuk array objek
    }
}
