<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth_model extends CI_Model
{
    public function check_login($username, $password)
    {
        // Sanitize input untuk keamanan
        $username = $this->db->escape_str($username);
        $hashed_password = md5($password);

        // Query untuk mencocokkan username dan hashed password
        $this->db->where('username', $username);
        $this->db->where('password', $hashed_password);
        $query = $this->db->get('login');

        if ($query->num_rows() > 0) {
            return $query->row(); // Kembalikan data user jika cocok
        }
        return false; // Kembalikan false jika tidak cocok
    }
}
