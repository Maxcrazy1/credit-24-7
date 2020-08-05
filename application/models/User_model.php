<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Contiene los metodos para crear, eliminar y modificar usuarios. Tambien incluye la validcion del login.
 *
 * @package default
 * @author Gerson Rodriguez <nosreg216@gmail.com>
 **/
class User_model extends CI_Model
{
	/**
	 * undocumented function
	 *
	 * @return void
	 * @author Bryan Jimenez <brijir08@gmail.com>
	 **/
	function add_User($data)
	{
		return $this->db->insert('dt_usuarios', $data);
	}

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author Bryan Jimenez <brijir08@gmail.com>
	 **/
	function delete_User($userId)
	{
		$success = $this->db->delete('dt_usuarios', array('usr_id' => $userId));
		return $success;
	}

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author Bryan Jimenez <brijir08@gmail.com>
	 **/
	function update_User($userId,$data)
	{
        $this->db->where(array('usr_id' => $userId));
		$success = $this->db->update('dt_usuarios', $data);
		return ($success) ? $userId : FALSE;
	}

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author Bryan Jimenez <brijir08@gmail.com>
	 **/
	function delete_admin($userId,$data)
	{
        $this->db->where(array('usr_id' => $userId));
		$success = $this->db->update('dt_usuarios', $data);
		return ($success) ? $userId : FALSE;
	}

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author Bryan Jimenez <brijir08@gmail.com>
	 **/
	function get_userList()
	{
        $this->db->from('dt_usuarios');
        $query = $this->db->where('usr_role', 'A');
        $query = $this->db->get();
        return ($query->num_rows() != 0) ? $query->result() : FALSE;
	}
	
	/**
	 * undocumented function
	 *
	 * @return void
	 * @author Bryan Jimenez <brijir08@gmail.com>
	 **/
	function get_allUsersWithoutColaborators()
	{
        $this->db->from('dt_colaboradores');
        $query = $this->db->get();
        $query1 = $query->result();
        $clb_id= array();
        foreach($query1 as $row){
            $clb_id[] = $row->clb_id;
        }
        $colaborators = implode(",",$clb_id);
        $ids = explode(",", $colaborators);

        $this->db->from('dt_usuarios');
        $this->db->where_not_in('usr_id', $ids);
        $query = $this->db->get();
        return ($query->num_rows() != 0) ? $query->result() : FALSE;
	}

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author Bryan Jimenez <brijir08@gmail.com>
	 **/
	function get_userByID($userId)
	{
        $query = $this->db->get_where('dt_usuarios', array('usr_id' => $userId));
        return ($query->num_rows() != 0) ? $query->row() : FALSE;
	}

	/**
	 * Recibe por parametro un telefono de usuario y devuelve sus datos.
	 *
	 * @return User
	 * @author Gerson Rodriguez <nosreg216@gmail.com>
	 **/
	function get_dataByPhoneNumber($number)
	{
		$this->db->from('dt_usuarios u');
		$this->db->join('dt_colaboradores c', 'u.usr_id = c.clb_id');
        $this->db->where('c.clb_telefono', $number);
        $query = $this->db->get();
        return ($query->num_rows() != 0) ? $query->row() : FALSE;
	}

	/**
	 * Recibe por parametro un usuario y devuelve sus datos.
	 *
	 * @return string
	 * @author Gerson Rodriguez <nosreg216@gmail.com>
	 **/
	function get_dataByUsername($username)
	{
        $query = $this->db->get_where('dt_usuarios', array('usr_name' => $username));
        return $row = $query->row(); 
	}


} // END class User_model