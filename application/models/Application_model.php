<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Permite consultar y editar las preferencias de aplicacion
 *
 * @package models
 * @author Gerson Rodriguez <nosreg216@gmail.com>
 **/
class Application_model extends CI_Model
{

	/**
	 * Consulta el valor actual de los intereses
	 *
	 * @return Integer
	 * @author Gerson Rodriguez <nosreg216@gmail.com>
	 **/
	function get_interest()
	{
		$this->db->select('app_intereses');
		$query = $this->db->get('dt_application');
		return $query->row();
	}

	public function update_config($data)
	{
		#$this->output->enable_profiler(TRUE);
		$success = $this->db->update('dt_application', $data);
		return $success;
	}

	/**
	 * undocumented function
	 * 
	 * @return void
	 * @author Bryan Jimenez <brijir08@gmail.com>
	 **/
	function get_clientCount()
	{
		return $this->db->count_all_results('dt_clientes');
	}


	/**
	 * undocumented function
	 * 
	 * @return void
	 * @author Bryan Jimenez <brijir08@gmail.com>
	 **/
	function get_colaboratorCount()
	{
		$this->db->where(array('clb_estado' => "1"));
		return $this->db->count_all_results('dt_colaboradores');
	}

	/**
	 * undocumented function
	 * 
	 * @return void
	 * @author Bryan Jimenez <brijir08@gmail.com>
	 **/
	function get_loanCount()
	{
		$this->db->where(array('prt_estado' => "1"));
		return $this->db->count_all_results('dt_prestamos');
	}


	/**
	 * undocumented function
	 * 
	 * @return void
	 * @author Bryan Jimenez <brijir08@gmail.com>
	 **/
	function get_regionCount()
	{
		return $this->db->count_all_results('dt_region');
	}
	
	/**
	 * undocumented function
	 * 
	 * @return void
	 * @author Carlos Carreño <cartur70@gmail.com>
	 **/
	function get_clientCountBycolaborator($id)
	{
	    $this->db->distinct();
	    $this->db->select('reg_id');
	    $this->db->from('dt_horarios');
	    $this->db->where(array('clb_id' => $id));
	    $query = $this->db->get();
		$result = $query->result();
		$cant_clientes = 0;
		foreach($result as $row){
    		$this->db->distinct();
    	    $this->db->select('cli_id');
    	    $this->db->from('dt_clientes');
    	    $query = $this->db->where(array('cli_region' => $row->reg_id));
    		$cant = $this->db->count_all_results();
    		$cant_clientes = $cant_clientes + $cant;
		}
		return $cant_clientes;
	}
	
	/**
	 * undocumented function
	 * 
	 * @return void
	 * @author Carlos Carreño <cartur70@gmail.com>
	 **/
	function get_loanCountBycolaborator($id)
	{
		$this->db->where(array('prt_estado' => "1", 'prt_autor' => $id));
		return $this->db->count_all_results('dt_prestamos');
	}


	/**
	 * undocumented function
	 * 
	 * @return void
	 * @author Carlos Carreño <cartur70@gmail.com>
	 **/
	function get_regionCountBycolaborator($id)
	{
	    $this->db->distinct();
	    $this->db->select('reg_id');
	    $this->db->from('dt_horarios');
	    $this->db->where(array('clb_id' => $id));
		return $this->db->count_all_results();
	}
	
	/**
	 * undocumented function
	 * 
	 * @return void
	 * @author Carlos Carreño <cartur70@gmail.com>
	 **/
	function get_loanTodayCountBycolaborator($colab, $fecha_Inicial, $fecha_Final)
	{
	    $range = "prt_fecha BETWEEN '$fecha_Inicial' AND '$fecha_Final'";
		$this->db->where(array('prt_estado' => "1", 'prt_autor' => $colab));
		$this->db->where($range);
		return $this->db->count_all_results('dt_prestamos');
	}
	
	/**
	 * undocumented function
	 * 
	 * @return void
	 * @author Carlos Carreño <cartur70@gmail.com>
	 **/
	function get_totalLoanTodayBycolaborator($colab, $fecha_Inicial, $fecha_Final)
	{
	    $range = "prt_fecha BETWEEN '$fecha_Inicial' AND '$fecha_Final'";
		$this->db->select_sum('prt_monto');
		$this->db->where(array('prt_estado' => "1", 'prt_autor' => $colab));
		$this->db->where($range);
		$query = $this->db->get('dt_prestamos');
		$result = $query->result();
		return ($result[0]->prt_monto == '') ? 0 : $result[0]->prt_monto;
	}
	
	/**
	 * undocumented function
	 * 
	 * @return void
	 * @author Carlos Carreño <cartur70@gmail.com>
	 **/
	function get_totalRaisedTodayBycolaborator($colab, $fecha_Inicial, $fecha_Final)
	{
	    $range = "abn_fecha BETWEEN '$fecha_Inicial' AND '$fecha_Final'";
	    $this->db->select_sum('abn_monto');
		$this->db->where(array('abn_autor' => $colab));
		$this->db->where($range);
		$this->db->where('abn_contable = 1');
		$query = $this->db->get('dt_prt_abonos');
		$result = $query->result();
		return ($result[0]->abn_monto == '') ? 0 : $result[0]->abn_monto;
	}
	
	/**
	 * undocumented function
	 * 
	 * @return void
	 * @author Carlos Carreño <cartur70@gmail.com>
	 **/
	function get_totalAvailableBycolaborator($colab)
	{
	    $this->db->select('clb_disponible');
		$this->db->where(array('clb_id' => $colab));
		$query = $this->db->get('dt_colaboradores');
		$result = $query->result();
		return $result[0]->clb_disponible;
	}

} // END class Application_model