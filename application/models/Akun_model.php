<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Akun_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Mendapatkan data akun berdasarkan id_login
     *
     * @param int $id_login
     * @return object|bool
     */
    public function get_akun($id_login)
    {
        try {
            return $this->db
                ->select('id_login, username, nama, no_hp, email, foto, password')
                ->from('login')
                ->where('id_login', (int)$id_login)
                ->get()
                ->row();
        } catch (Exception $e) {
            log_message('error', 'Error in get_akun: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Mengupdate informasi akun
     *
     * @param int $id_login
     * @param array $data
     * @return bool
     */
    public function update_akun($id_login, $data)
    {
        try {
            return $this->db
                ->where('id_login', (int)$id_login)
                ->update('login', $data);
        } catch (Exception $e) {
            log_message('error', 'Error in update_akun: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Mengupload foto profil ke database
     *
     * @param int $id_login
     * @param string $foto
     * @return bool
     */
    public function upload_foto($id_login, $foto)
    {
        try {
            return $this->db
                ->where('id_login', (int)$id_login)
                ->update('login', ['foto' => $foto]);
        } catch (Exception $e) {
            log_message('error', 'Error in upload_foto: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Mengambil data user untuk sidebar
     *
     * @param int $id_login
     * @return object|null
     */
    public function get_user_sidebar($id_login)
    {
        try {
            return $this->db
                ->select('nama, foto')
                ->from('login')
                ->where('id_login', (int)$id_login)
                ->get()
                ->row();
        } catch (Exception $e) {
            log_message('error', 'Error in get_user_sidebar: ' . $e->getMessage());
            return null;
        }
    }
}
