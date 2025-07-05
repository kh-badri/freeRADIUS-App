<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kategori_model extends CI_Model
{
    /**
     * Ambil data dari tabel
     */
    public function get_data($table)
    {
        return $this->db->get($table);
    }

    /**
     * Ambil semua data kategori (versi langsung)
     */
    public function get_all_kategori()
    {
        return $this->db->get('kategori')->result();
    }

    /**
     * Cek duplikasi saat insert
     */
    public function cek_duplicated($namakategori, $tipe_kategori, $site)
    {
        $this->db->where('namakategori', $namakategori);
        $this->db->where('tipe_kategori', $tipe_kategori);
        $this->db->where('site', $site);
        $query = $this->db->get('kategori');
        return $query->num_rows() > 0;
    }

    /**
     * Cek duplikasi saat update (abaikan id_kategori yg sedang diedit)
     */
    public function cek_duplicated_update($id_kategori, $namakategori, $tipe_kategori, $site)
    {
        $this->db->from('kategori');
        $this->db->where('namakategori', $namakategori);
        $this->db->where('tipe_kategori', $tipe_kategori);
        $this->db->where('site', $site);
        $this->db->where('id_kategori !=', $id_kategori);
        return $this->db->get()->num_rows();
    }

    /**
     * Insert data kategori (dipanggil dari controller tanpa parameter tabel)
     */
    public function insert($data)
    {
        return $this->db->insert('kategori', $data);
    }

    /**
     * Insert data dengan nama tabel fleksibel
     */
    public function insert_data($data, $table)
    {
        return $this->db->insert($table, $data);
    }

    /**
     * Update data berdasarkan id_kategori
     */
    public function update_data($data, $table)
    {
        $this->db->where('id_kategori', $data['id_kategori']);
        return $this->db->update($table, $data);
    }

    /**
     * Delete data berdasarkan kondisi
     */
    public function delete($where, $table)
    {
        return $this->db->delete($table, $where);
    }
}
