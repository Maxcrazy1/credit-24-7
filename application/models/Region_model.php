<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Region_model extends CI_Model {

	/**
	 * Devuelve la lista de todas las regiones
	 *
	 * @return Array<Object: Region>
	 * @author Bryan Jimenez <brijir08@gmail.com>
	 **/
	function get_regionList()
	{
		$this->db->from('dt_region');
		$this->db->order_by('reg_nombre');
		$query = $this->db->get();
		return ($query->num_rows() != 0) ? $query->result() : FALSE;
	}


	/**
	 * Devuelve la lista de todas las regiones
	 * Incluye la cantidad de clientes por region
	 *
	 * @return Array<Object: Region>
	 * @author Bryan Jimenez <brijir08@gmail.com>
	 **/
	function get_regionListComplete()
	{
		$this->db->select(array('reg_id','reg_nombre', 'count(cli_id) as cli_count'));
		$this->db->from('dt_region as r');
		$this->db->join('dt_clientes as c', 'r.reg_id = c.cli_region', 'left');
		$this->db->group_by('reg_nombre');
		$this->db->order_by('reg_nombre');
		$query = $this->db->get();
		return $query->result(); 
	}

	public function get_regionLoanList($region)
	{
		#$this->output->enable_profiler(TRUE);
		$this->db->select('c.cli_region, c.cli_region2, c.cli_region3, c.cli_id, c.cli_nombre, p.prt_id,p.prt_dia, p.prt_tipo, prt_fecha, max(a.abn_fecha) abn_fecha');
		$this->db->from('dt_prestamos p');
		$this->db->join('dt_clientes c', 'c.cli_id = p.prt_cliente');
		$this->db->join('dt_prt_abonos a', 'p.prt_id = a.prt_id', 'left');
		$this->db->where('prt_estado', 1);
		$this->db->where('c.cli_region', $region);
		$this->db->or_where('c.cli_region2', $region);
		$this->db->or_where('c.cli_region3', $region);
		$this->db->group_by('p.prt_id');
		$query = $this->db->get();

		return ($query->num_rows() != 0) ? $query->result() : FALSE;
	}
	
	
	/**
	 * Devuelve una lista anidada desde Region, Clientes, Prestamos y Abonos
	 * Donde se mostrará el ultimo pago del cliente
	 *
	 * @return Array<Object: Region>
	 * @author Alexis Hernández <alexis@suespacio.net>
	 **/
	 
	public function get_regionBlackList()
	{
		#$this->output->enable_profiler(TRUE);
		$this->db->select('c.cli_region, c.cli_id, c.cli_nombre, p.prt_id,p.prt_dia, p.prt_tipo, prt_fecha, max(a.abn_fecha) abn_fecha');
		$this->db->from('dt_prestamos p');
		$this->db->join('dt_clientes c', 'c.cli_id = p.prt_cliente');
		$this->db->join('dt_prt_abonos a', 'p.prt_id = a.prt_id');
		$this->db->where('prt_estado', 1);
		$this->db->group_by('p.prt_id');
		$query = $this->db->get();

		return ($query->num_rows() != 0) ? $query->result() : FALSE;
	}



	/**
	 * undocumented function
	 *
	 * @return Object: Region
	 * @author Bryan Jimenez <brijir08@gmail.com>
	 **/
	function get_regionByID($regionId)
	{
		$query = $this->db->get_where('dt_region', array('reg_id' => $regionId));
		return ($query->num_rows() != 0) ? $query->row() : FALSE;
	}


	/**
	* undocumented function
	*
	* @return void
	* @author Gerson Rodriguez <nosreg216@gmail.com>
	**/
	function get_regionByColabDay($colabID, $day)
	{
	    $this->db->distinct();
		#$this->output->enable_profiler(TRUE);
		$this->db->from('dt_region r');
		$this->db->join('dt_horarios h', 'r.reg_id = h.reg_id');
		$this->db->where('h.clb_id', $colabID);
		$this->db->where('h.hro_dia', $day);
		$this->db->order_by('r.reg_id');
		$query = $this->db->get();
		return ($query->num_rows() != 0) ? $query->result() : FALSE;
	}

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author Bryan Jimenez <brijir08@gmail.com>
	 **/
	function add_region($data)
	{
		return $this->db->insert('dt_region', $data);
	}

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author Bryan Jimenez <brijir08@gmail.com>
	 **/
	function update_region()
	{
	}

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author Bryan Jimenez <brijir08@gmail.com>
	 **/
	function delete_region($reg_id)
	{
		return $success = $this->db->delete('dt_region', array('reg_id' => $reg_id));
	}

}