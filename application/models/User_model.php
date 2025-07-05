<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model
{
    public function get_all()
    {
        return $this->db->get('site')->result();
    }

    public function generateUsername($site_id)
    {
        $this->db->select('kodesite');
        $this->db->where('id_site', $site_id);
        $result = $this->db->get('site')->row();

        if (!$result) return '';

        $kodesite = $result->kodesite;

        $this->db->like('username', $kodesite, 'after');
        $this->db->from('user');
        $count = $this->db->count_all_results();

        $urutan = str_pad($count + 1, 3, '0', STR_PAD_LEFT);
        return $kodesite . $urutan;
    }

    public function get_user_filtered($type = null)
    {
        $this->db->select('user.*, kategori.namakategori, kategori.tipe_kategori, site.namasite as site, bandwith.namapaket, bandwith.harga as tarif, sesi.namasesi');
        $this->db->from('user');
        $this->db->join('kategori', 'kategori.id_kategori = user.kategori_id', 'left');
        $this->db->join('site', 'site.id_site = user.site_id', 'left');
        $this->db->join('bandwith', 'bandwith.id_bw = user.bandwith_id', 'left');
        $this->db->join('sesi', 'sesi.id_sesi = user.sesi_id', 'left');

        // ✅ Filter berdasarkan kolom 'type' pada tabel 'user'
        if (!empty($type)) {
            $this->db->where('user.type', $type);
        }

        return $this->db->get()->result();
    }

    public function get_data($table)
    {
        $this->db->select('user.*, bandwith.namapaket, bandwith.harga as tarif, sesi.namasesi, sesi.nilaisesi, kategori.id_kategori, kategori.namakategori, kategori.tipe_kategori, site.namasite as site');
        $this->db->from($table);
        $this->db->join('bandwith', 'user.bandwith_id = bandwith.id_bw', 'left');
        $this->db->join('sesi', 'user.sesi_id = sesi.id_sesi', 'left');
        $this->db->join('kategori', 'user.kategori_id = kategori.id_kategori', 'left');
        $this->db->join('site', 'user.site_id = site.id_site', 'left');
        return $this->db->get();
    }

    public function getById($id)
    {
        return $this->db->get_where('user', ['id_user' => $id])->row();
    }

    public function getUserById($id_user)
    {
        $this->db->select('user.*, kategori.namakategori, kategori.tipe_kategori, site.namasite as site, bandwith.namapaket, bandwith.harga as tarif, sesi.namasesi');
        $this->db->from('user');
        $this->db->join('kategori', 'kategori.id_kategori = user.kategori_id', 'left');
        $this->db->join('site', 'site.id_site = user.site_id', 'left');
        $this->db->join('bandwith', 'bandwith.id_bw = user.bandwith_id', 'left');
        $this->db->join('sesi', 'sesi.id_sesi = user.sesi_id', 'left');
        $this->db->where('user.id_user', $id_user);
        return $this->db->get()->row();
    }

    public function insert_data($data, $table)
    {
        $this->db->insert($table, $data);
    }

    public function update_data($where, $data, $table)
    {
        $this->db->where($where);
        $this->db->update($table, $data);
    }

    public function delete($where, $table)
    {
        $this->db->where($where);
        $this->db->delete($table);
    }
}
