<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model
{
    /**
     * Ambil semua data site
     */
    public function get_all()
    {
        return $this->db->get('site')->result();
    }

    /**
     * Generate username berdasarkan site_id dan urutan terakhir
     */
    public function generateUsername($site_id)
    {
        $this->db->select('kodesite');
        $this->db->where('id_site', $site_id);
        $result = $this->db->get('site')->row();

        if (!$result) return '';

        $kodesite = $result->kodesite;

        // Hitung jumlah user yang memakai prefix kodesite
        $this->db->like('username', $kodesite, 'after');
        $this->db->from('user');
        $count = $this->db->count_all_results();

        // Tambahkan urutan ke username
        $urutan = str_pad($count + 1, 3, '0', STR_PAD_LEFT);
        return $kodesite . $urutan;
    }

    /**
     * Hitung jumlah user yang masih aktif berdasarkan tanggal expiration
     */
    public function get_total_user_aktif()
    {
        $this->db->where('expiration >=', date('Y-m-d'));
        return $this->db->count_all_results('user');
    }

    /**
     * Ambil semua data user dengan optional filter tipe
     */
    public function get_user_filtered($type = null)
    {
        $this->db->select('user.*, user.kategori, user.koneksi, site.namasite as site, bandwith.namapaket, bandwith.harga as tarif, sesi.namasesi');
        $this->db->from('user');
        $this->db->join('site', 'site.id_site = user.site_id', 'left');
        $this->db->join('bandwith', 'bandwith.id_bw = user.bandwith_id', 'left');
        $this->db->join('sesi', 'sesi.id_sesi = user.sesi_id', 'left');

        if (!empty($type)) {
            $this->db->where('user.type', $type);
        }

        return $this->db->get()->result();
    }

    /**
     * Ambil data lengkap user dari suatu tabel (digunakan untuk listing)
     */
    public function get_data($table)
    {
        $this->db->select('user.*, bandwith.namapaket, bandwith.harga as tarif, sesi.namasesi, sesi.nilaisesi, site.namasite as site');
        $this->db->from($table);
        $this->db->join('bandwith', 'user.bandwith_id = bandwith.id_bw', 'left');
        $this->db->join('sesi', 'user.sesi_id = sesi.id_sesi', 'left');
        $this->db->join('site', 'user.site_id = site.id_site', 'left');
        return $this->db->get();
    }

    /**
     * Ambil 1 baris data user berdasarkan ID (simple)
     */
    public function getById($id)
    {
        return $this->db->get_where('user', ['id_user' => $id])->row();
    }

    /**
     * Ambil detail user lengkap berdasarkan ID
     */
    public function getUserById($id_user)
    {
        $this->db->select('user.*, site.namasite as site, bandwith.namapaket, bandwith.harga as tarif, sesi.namasesi');
        $this->db->from('user');
        $this->db->join('site', 'site.id_site = user.site_id', 'left');
        $this->db->join('bandwith', 'bandwith.id_bw = user.bandwith_id', 'left');
        $this->db->join('sesi', 'sesi.id_sesi = user.sesi_id', 'left');
        $this->db->where('user.id_user', $id_user);
        return $this->db->get()->row();
    }

    /**
     * Tambahkan data ke tabel
     */
    public function insert_data($data, $table)
    {
        $this->db->insert($table, $data);
    }

    public function update_data($id_user, $data)
    {
        $this->db->where('id_user', $id_user);
        $this->db->update('user', $data);
    }


    /**
     * Hapus data berdasarkan kondisi
     */
    public function delete($where, $table)
    {
        if (!empty($where)) {
            $this->db->where($where);
        }
        $this->db->delete($table);
    }
}
