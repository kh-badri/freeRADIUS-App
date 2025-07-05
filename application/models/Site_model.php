<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Site_model extends CI_Model
{
    public function get_all()
    {
        return $this->db->get('site')->result();
    }

    public function get_site_by_id($id_site)
    {
        return $this->db->get_where('site', ['id_site' => $id_site])->row();
    }

    public function insert_data($data, $table)
    {
        return $this->db->insert($table, $data);
    }

    public function update_data($data, $table)
    {
        $this->db->where('id_site', $data['id_site']);
        return $this->db->update($table, $data);
    }

    public function delete($where, $table)
    {
        $this->db->where($where);
        return $this->db->delete($table);
    }
}
