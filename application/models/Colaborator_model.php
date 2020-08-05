<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Colaborator_model extends CI_Model {

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author Bryan Jimenez <brijir08@gmail.com>
	 **/
	function get_colaboratorList()
	{
		$this->db->from('dt_colaboradores');
		$this->db->order_by('clb_role, clb_nombre');
		$query = $this->db->get();
		return ($query->num_rows() != 0) ? $query->result() : FALSE;
	}

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author Bryan Jimenez <brijir08@gmail.com>
	 **/
	function get_colaboratorByID($colaboratorId)
	{
		$query = $this->db->get_where('dt_colaboradores', array('clb_id' => $colaboratorId));
		return ($query->num_rows() != 0) ? $query->row() : FALSE;
	}

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author Bryan Jimenez <brijir08@gmail.com>
	 **/
	function get_colaboratorByNumber($number)
	{
		$query = $this->db->get_where('dt_colaboradores', array('clb_telefono' => $number));
		return $query->row(); 
	}
	
	/**
	 * undocumented function
	 *
	 * @return void
	 * @author Bryan Jimenez <brijir08@gmail.com>
	 **/
	function get_colaboratorByUser($user)
	{
		$query = $this->db->get_where('dt_colaboradores', array('clb_usuario' => $user));
		return $row = $query->row();
	}

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author Bryan Jimenez <brijir08@gmail.com>
	 **/
	function get_colaboratorListByRegion()
	{
	}


	/**
	 * Insertar los datos del Colab.
	 *
	 * @return Boolean
	 * @author Gerson Rodriguez <nosreg216@gmail.com>
	 **/
	function add_Colaborator($data)
	{
		$this->db->insert('dt_colaboradores', $data);
		return $this->db->insert_id();
	}
	
	/**
	 * undocumented function
	 *
	 * Obtener cédula de cliente para comparar
	 *
	 * @return void
	 * @author Alexis Hernández <alexis@suespacio.net>
	 **/
	function tel_colaborador($telefono)
	{
	   $this->db->select('clb_telefono');
	   $this->db->where('clb_telefono', $telefono);
	   $query = $this->db->get('dt_colaboradores');
	   return $query->row('clb_telefono');
	}

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author Bryan Jimenez <brijir08@gmail.com>
	 **/
	function update_colaborator($colaboratorID,$data)
	{
		#$this->output->enable_profiler(TRUE);
		$this->db->where(array('clb_id' => $colaboratorID));
		$success = $this->db->update('dt_colaboradores', $data);
		return ($success) ? $colaboratorID : FALSE;
	}

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author Bryan Jimenez <brijir08@gmail.com>
	 **/
	function change_colab($colaboratorID,$data)
	{
		#$this->output->enable_profiler(TRUE);
		$this->db->where(array('clb_id' => $colaboratorID));
		$success = $this->db->update('dt_colaboradores', $data);
		return ($success) ? $colaboratorID : FALSE;
	}

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author Bryan Jimenez <brijir08@gmail.com>
	 **/
	function update_colaboratorList($data)
	{
		#$this->output->enable_profiler(TRUE);
		$success = $this->db->update('dt_colaboradores', $data);
		return $success;
	}

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author Bryan Jimenez <brijir08@gmail.com>
	 **/
	function delete_colaborator($colaboratorID)
	{
		$this->db->delete('dt_prt_abonos', array('abn_autor' => $colaboratorID));
		$this->db->delete('dt_prestamos', array('prt_autor' => $colaboratorID));
		$this->db->delete('dt_colaboradores', array('clb_id' => $colaboratorID));
		$this->db->delete('dt_usuarios', array('usr_id' => $colaboratorID));
		return 1;
	}


}