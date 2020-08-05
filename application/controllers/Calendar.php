<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Permite modificar las regiones para cada colaborador para cada dia de la semana.
 *
 * @package controllers
 * @author Gerson Rodriguez <nosreg216@gmail.com>
 **/
class Calendar extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Colaborator_model');
		$this->load->model('Calendar_model');
		$this->load->model('Region_model');
	}

	/**
	 * Carga los datos en las vistas
	 *
	 * @return void
	 * @author Gerson Rodriguez <nosreg216@gmail.com>
	 **/
	function index()
	{
		$this->db->trans_start();

		$scheduleList = $this->Calendar_model->get_allEntries();
		$colaboratorList = $this->Colaborator_model->get_colaboratorList();
		$regionList = $this->Region_model->get_regionList();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE)
		{
			redirect(_App_.'404_override');
		}		
		else
		{
			$data = array(
			'scheduleList' => $scheduleList,
			'colaboratorList' => $colaboratorList,
			'regionList' => $regionList
			);

			$data['title'] = "Horarios";
			$this->load->view('static/header', $data);
			$this->load->view('static/sidebar');
			$this->load->view('calendar_view', $data);
			$this->load->view('static/footer');
		}
	}

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author Gerson Rodriguez <nosreg216@gmail.com>
	 **/
	function addEntry()
	{
		$colab = $this->input->post('colaborador');
		$region = $this->input->post('region');
		$tipo = $this->input->post('tipo');
		$days = $this->input->post('dia[]');

		$this->db->trans_start();
		foreach ($days as $day) {

			$data = array(
				'clb_id' => $colab,
				'reg_id' => $region,
				'hro_dia' => $day,
				'prt_tipo' => $tipo
				);

			$horario = $this->Calendar_model->add_entry($data);
		}
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE)
		{
			redirect(_App_.'horarios?err');
		}		
		else
		{
			redirect(_App_."horarios?tab=$days[0]");
		}
	}

	function deleteEntry($hro_id)
	{	
		$this->db->trans_start();
		$horario = $this->Calendar_model->deleteEntry($hro_id);
		$tab = $this->input->get('tab');
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE)
		{
			redirect(_App_.'horarios?err');
		}		
		else
		{
			redirect(_App_."horarios?tab=".$tab);
		}
	}
} // END class Calendar