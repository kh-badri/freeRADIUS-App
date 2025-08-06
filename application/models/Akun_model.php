<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Akun_model extends CI_Model
{
    private $table = 'login';
    private $primary_key = 'id_login';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Mendapatkan data akun berdasarkan ID login.
     * @param int $id_login ID pengguna yang sedang login.
     * @return object|null Objek data akun jika ditemukan, atau null jika tidak.
     */
    public function get_akun($id_login)
    {
        try {
            return $this->db
                ->select('id_login, username, nama, no_hp, email, foto, password')
                ->where($this->primary_key, (int)$id_login)
                ->get($this->table)
                ->row();
        } catch (Exception $e) {
            log_message('error', 'Error in get_akun: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Memperbarui informasi akun.
     * @param int $id_login ID pengguna yang akan diperbarui.
     * @param array $data Data yang akan diperbarui.
     * @return bool True jika berhasil, False jika gagal.
     */
    public function update_akun($id_login, $data)
    {
        try {
            $this->db->where($this->primary_key, (int)$id_login);
            $this->db->update($this->table, $data);
            return $this->db->affected_rows() > 0;
        } catch (Exception $e) {
            log_message('error', 'Error in update_akun: ' . $e->getMessage());
            return false;
        }
    }
}
