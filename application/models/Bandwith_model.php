<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Bandwith_model extends CI_Model
{

    public function getTarifById($id)
    {
        return $this->db->get_where('bandwith', ['id_bw' => $id])->row();
    }
    // Ambil semua data dari tabel tertentu (gunakan result untuk objek, result_array untuk array)
    public function get_data($table)
    {
        return $this->db->get($table)->result(); // Menggunakan result() untuk mendapatkan objek
    }

    //cek data sudah ada ketika tambah data
    public function cek_duplicated_bandwith($namapaket)
    {
        $this->db->where('namapaket', $namapaket);
        return $this->db->get('bandwith')->num_rows() > 0;
    }

    //cek data sudah ada ketika update data
    public function cek_duplicated_bandwith_update($namapaket, $id_bw)
    {
        $this->db->where('namapaket', $namapaket);
        $this->db->where('id_bw !=', $id_bw); // abaikan diri sendiri
        return $this->db->get('bandwith')->num_rows() > 0;
    }

    // Ambil semua data dari tabel bandwith
    public function get_all_bandwith()
    {
        $this->db->select('*'); // Bisa tambahkan kolom spesifik jika diperlukan
        $this->db->from('bandwith'); // Pastikan nama tabel sesuai dengan database
        $query = $this->db->get();
        return $query->result(); // Menggunakan result() untuk mendapatkan objek, bisa gunakan result_array() jika ingin array
    }

    // Tambah data ke tabel tertentu
    public function insert_data($data, $table)
    {
        return $this->db->insert($table, $data);
    }

    // Perbarui data berdasarkan id_bw
    public function update_data($data, $table)
    {
        $this->db->where('id_bw', $data['id_bw']);
        return $this->db->update($table, $data);
    }

    // Hapus data dari tabel tertentu
    public function delete($where, $table)
    {
        $this->db->where($where);
        return $this->db->delete($table);
    }

    // Alternatif untuk mendapatkan data bandwidth dengan nama kolom yang lebih eksplisit
    public function get_bandwith()
    {
        $this->db->select('*'); // Bisa tambahkan kolom spesifik jika diperlukan
        $this->db->from('bandwith'); // Pastikan nama tabel sesuai dengan database
        $query = $this->db->get();
        return $query->result(); // Menggunakan result() untuk mendapatkan objek
    }
}
