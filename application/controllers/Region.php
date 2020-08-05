<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Permite ver, crear ye eliminar las regiones para los horarios.
 *
 * @package controllers
 * @author Gerson Rodriguez <nosreg216@gmail.com>
 **/
class Region extends CI_Controller
{

	public function __construct()
    {
        parent::__construct();
		$this->load->model('Region_model');
		$this->load->model('Client_model');
    }

	/**
	 * Carga las vistas
	 *
	 * @return void
	 * @author Gerson Rodriguez <nosreg216@gmail.com>
	 **/
	function index()
	{
		$this->db->trans_start();
		#Lista de todos los clientes
		$regionList = $this->Region_model->get_regionListComplete();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE)
		{
			redirect(_App_.'404_override');
		}		
		else
		{
			$data = array(
			'regionList' => $regionList
			);

			$data['title'] = "Regiones";
			$this->load->view('static/header', $data);
			$this->load->view('static/sidebar');
			# Cargar la vista de regiones pasandole por parametro la lista de regiones
			$this->load->view('regionList_view',$data);
			$this->load->view('static/footer');
		}
	}

	/**
	 * Toma el nombre del formulario para agregar una nueva region
	 *
	 * @return void
	 * @author Gerson Rodriguez <nosreg216@gmail.com>
	 **/
	function addRegion()
	{	
		$this->db->trans_start();
		$region = $this->input->post('name');
		$data = array(
			'reg_nombre' => ucfirst($region)
		);
		$success = $this->Region_model->add_region($data);
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE)
		{
			redirect(_App_."regiones?err");
		}		
		else
		{
			redirect(_App_."regiones?scs");
		}
	}

	function displayRegion($regionId)
	{
		$this->db->trans_start();
		# Pide la informacion de ese cliente
		$RegionInfo = $this->Region_model->get_regionByID($regionId);
		if (!$RegionInfo) {
			redirect(_App_."404?".uri_string());
		}
		$loanList = $this->Region_model->get_regionLoanList($regionId);
		$loanListD = $loanListS = $loanListQ = array();

		if ($loanList) {
			foreach ($loanList as $loan) {
				switch ($loan->prt_tipo) {
					case 'D': $loanListD[] = $loan; break;
					case 'S': $loanListS[] = $loan; break;
					case 'Q': $loanListQ[] = $loan; break;
				}
			}

			if (count($loanListD) == 0) { $loanListD = FALSE; }
			if (count($loanListS) == 0) { $loanListS = FALSE; }
			if (count($loanListQ) == 0) { $loanListQ = FALSE; }
		}
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE)
		{
			redirect(_App_.'404_override');
		}		
		else
		{
			$data = array(
			'RegionInfo' => $RegionInfo,
			'loanListD' => $loanListD,
			'loanListS' => $loanListS,
			'loanListQ' => $loanListQ
			);

			$data['title'] = $RegionInfo->reg_nombre;
			$this->load->view("static/header", $data);
			$this->load->view("static/sidebar");
			$this->load->view("region_view", $data);
			$this->load->view("static/footer");
		}
	}
	
	/**
	 * Muestra todos pagos de los clientes, desde su ultimo pago hecho
	 * Muestra desde los prestamos diarios, semanales y quincenales 
	 *
	 * @return void
	 * @author Alexis Hernández <alexis@suespacio.net>
	 **/
	function blackListCli()
	{
		$this->db->trans_start();
		$loanList = $this->Region_model->get_regionBlackList();
		$loanListD = $loanListS = $loanListQ = array();

		if ($loanList) {
			foreach ($loanList as $loan) {
				switch ($loan->prt_tipo) {
					case 'D': $loanListD[] = $loan; break;
					case 'S': $loanListS[] = $loan; break;
					case 'Q': $loanListQ[] = $loan; break;
				}
			}

			if (count($loanListD) == 0) { $loanListD = FALSE; }
			if (count($loanListS) == 0) { $loanListS = FALSE; }
			if (count($loanListQ) == 0) { $loanListQ = FALSE; }
		}
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE)
		{
			redirect(_App_.'404_override');
		}		
		else
		{
			$data = array(
			
			'loanListD' => $loanListD,
			'loanListS' => $loanListS,
			'loanListQ' => $loanListQ
			);

			$data['title'] = "Lista Negra";
			$this->load->view("static/header", $data);
			$this->load->view("static/sidebar");
			$this->load->view("blackList_view", $data);
			$this->load->view("static/footer");
		}
	}
	
	/**
	 * Muestra todos pagos de los clientes, desde su ultimo pago hecho
	 * Muestra desde los prestamos diarios, semanales y quincenales 
	 * Lista de la 1er semana de retraso de pago
	 *
	 * @return void
	 * @author Alexis Hernández <alexis@suespacio.net>
	 **/
	function oneWeeksCli()
	{
		$this->db->trans_start();
		$loanList = $this->Region_model->get_regionBlackList();
		$loanListD = $loanListS = $loanListQ = array();

		if ($loanList) {
			foreach ($loanList as $loan) {
				switch ($loan->prt_tipo) {
					case 'D': $loanListD[] = $loan; break;
					case 'S': $loanListS[] = $loan; break;
					case 'Q': $loanListQ[] = $loan; break;
				}
			}

			if (count($loanListD) == 0) { $loanListD = FALSE; }
			if (count($loanListS) == 0) { $loanListS = FALSE; }
			if (count($loanListQ) == 0) { $loanListQ = FALSE; }
		}
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE)
		{
			redirect(_App_.'404_override');
		}		
		else
		{
			$data = array(
			
			'loanListD' => $loanListD,
			'loanListS' => $loanListS,
			'loanListQ' => $loanListQ
			);

			$data['title'] = "Lista 1er semana";
			$this->load->view("static/header", $data);
			$this->load->view("static/sidebar");
			$this->load->view("oneWeek_view", $data);
			$this->load->view("static/footer");
		}
	}
	
	/**
	 * Muestra todos pagos de los clientes, desde su ultimo pago hecho
	 * Muestra desde los prestamos diarios, semanales y quincenales 
	 * Lista de la 2da semana de retraso de pago
	 *
	 * @return void
	 * @author Alexis Hernández <alexis@suespacio.net>
	 **/
	function twoWeeksCli()
	{
		$this->db->trans_start();
		$loanList = $this->Region_model->get_regionBlackList();
		$loanListD = $loanListS = $loanListQ = array();

		if ($loanList) {
			foreach ($loanList as $loan) {
				switch ($loan->prt_tipo) {
					case 'D': $loanListD[] = $loan; break;
					case 'S': $loanListS[] = $loan; break;
					case 'Q': $loanListQ[] = $loan; break;
				}
			}

			if (count($loanListD) == 0) { $loanListD = FALSE; }
			if (count($loanListS) == 0) { $loanListS = FALSE; }
			if (count($loanListQ) == 0) { $loanListQ = FALSE; }
		}
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE)
		{
			redirect(_App_.'404_override');
		}		
		else
		{
			$data = array(
			
			'loanListD' => $loanListD,
			'loanListS' => $loanListS,
			'loanListQ' => $loanListQ
			);

			$data['title'] = "Lista 2da semana";
			$this->load->view("static/header", $data);
			$this->load->view("static/sidebar");
			$this->load->view("twoWeeks_view", $data);
			$this->load->view("static/footer");
		}
	}
	
	/**
	 * Muestra todos pagos de los clientes, desde su ultimo pago hecho
	 * Muestra desde los prestamos diarios, semanales y quincenales 
	 * Lista de la 3er semana de retraso de pago
	 *
	 * @return void
	 * @author Alexis Hernández <alexis@suespacio.net>
	 **/
	function threeWeeksCli()
	{
		$this->db->trans_start();
		$loanList = $this->Region_model->get_regionBlackList();
		$loanListD = $loanListS = $loanListQ = array();

		if ($loanList) {
			foreach ($loanList as $loan) {
				switch ($loan->prt_tipo) {
					case 'D': $loanListD[] = $loan; break;
					case 'S': $loanListS[] = $loan; break;
					case 'Q': $loanListQ[] = $loan; break;
				}
			}

			if (count($loanListD) == 0) { $loanListD = FALSE; }
			if (count($loanListS) == 0) { $loanListS = FALSE; }
			if (count($loanListQ) == 0) { $loanListQ = FALSE; }
		}
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE)
		{
			redirect(_App_.'404_override');
		}		
		else
		{
			$data = array(
			
			'loanListD' => $loanListD,
			'loanListS' => $loanListS,
			'loanListQ' => $loanListQ
			);

			$data['title'] = "Lista 3er semana";
			$this->load->view("static/header", $data);
			$this->load->view("static/sidebar");
			$this->load->view("threeWeeks_view", $data);
			$this->load->view("static/footer");
		}
	}
	
	/**
	 * Muestra todos pagos de los clientes, desde su ultimo pago hecho
	 * Muestra desde los prestamos diarios, semanales y quincenales 
	 * Lista de la 4ta semanas de retraso de pago
	 *
	 * @return void
	 * @author Alexis Hernández <alexis@suespacio.net>
	 **/
	function fourWeeksCli()
	{
		$this->db->trans_start();
		$loanList = $this->Region_model->get_regionBlackList();
		$loanListD = $loanListS = $loanListQ = array();

		if ($loanList) {
			foreach ($loanList as $loan) {
				switch ($loan->prt_tipo) {
					case 'D': $loanListD[] = $loan; break;
					case 'S': $loanListS[] = $loan; break;
					case 'Q': $loanListQ[] = $loan; break;
				}
			}

			if (count($loanListD) == 0) { $loanListD = FALSE; }
			if (count($loanListS) == 0) { $loanListS = FALSE; }
			if (count($loanListQ) == 0) { $loanListQ = FALSE; }
		}
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE)
		{
			redirect(_App_.'404_override');
		}		
		else
		{
			$data = array(
			
			'loanListD' => $loanListD,
			'loanListS' => $loanListS,
			'loanListQ' => $loanListQ
			);

			$data['title'] = "Lista 4ta semana";
			$this->load->view("static/header", $data);
			$this->load->view("static/sidebar");
			$this->load->view("fourWeeks_view", $data);
			$this->load->view("static/footer");
		}
	}
	
	/**
	 * Muestra todos pagos de los clientes, desde su ultimo pago hecho
	 * Muestra desde los prestamos diarios, semanales y quincenales 
	 * Lista de la 5ta semana de retraso de pago
	 *
	 * @return void
	 * @author Alexis Hernández <alexis@suespacio.net>
	 **/
	function fiveWeeksCli()
	{
		$this->db->trans_start();
		$loanList = $this->Region_model->get_regionBlackList();
		$loanListD = $loanListS = $loanListQ = array();

		if ($loanList) {
			foreach ($loanList as $loan) {
				switch ($loan->prt_tipo) {
					case 'D': $loanListD[] = $loan; break;
					case 'S': $loanListS[] = $loan; break;
					case 'Q': $loanListQ[] = $loan; break;
				}
			}

			if (count($loanListD) == 0) { $loanListD = FALSE; }
			if (count($loanListS) == 0) { $loanListS = FALSE; }
			if (count($loanListQ) == 0) { $loanListQ = FALSE; }
		}
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE)
		{
			redirect(_App_.'404_override');
		}		
		else
		{
			$data = array(
			
			'loanListD' => $loanListD,
			'loanListS' => $loanListS,
			'loanListQ' => $loanListQ
			);

			$data['title'] = "Lista 5ta semana";
			$this->load->view("static/header", $data);
			$this->load->view("static/sidebar");
			$this->load->view("fiveWeeks_view", $data);
			$this->load->view("static/footer");
		}
	}
	
	function removeRegion($reg_id)
	{	
		$this->load->model('Calendar_model');
		$this->db->trans_start();
		$horario = $this->Calendar_model->deleteEntryByRegion($reg_id);
		$region = $this->Region_model->delete_region($reg_id);
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE)
		{
			redirect(_App_.'regiones?err');
		}		
		else
		{
			redirect(_App_."regiones");
		}
	}

} // END class Region