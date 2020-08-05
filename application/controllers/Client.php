<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Controlador de la lista de clientes.
 *
 * @package controllers
 **/
class Client extends CI_Controller
{
    public function __construct()
    {
		parent::__construct();
		$this->load->model('Client_model');
		$this->load->model('Region_model');
    }

	/**
	 *
	 * @return void
	 **/
	function index ()
	{		#Lista de todos los clientes
		$clientList = $this->Client_model->get_clientList();
		$regionList = $this->Region_model->get_regionList();
		$data = array(
		'clientList' => $clientList,
		'regionList' => $regionList
	);

		$data['title'] = "Clientes";
		$this->setViewDesktop('clientList_view',$data);
	}

	private function setViewDesktop($view,$data)
	{
			$this->load->view("static/header",$data);
    		$this->load->view("static/sidebar");
    		$this->load->view($view, $data);
    		$this->load->view("static/footer");
	}
	/**
	 * Metodo movil. Muestra el perfil del cliente
	 *
	 * @return void
	 * @author Carlos <cartur70@gmail.com>
	 **/
	function mobile_index ($clientId)
	{
	    $this->load->model('Loan_model');
		$this->load->model('Payment_model');

		$this->db->trans_start();
		$clientInfo = $this->Client_model->get_clientByID($clientId);
		if (!$clientInfo) {
			redirect(_App_."404?".uri_string());
		}
		$paymentList = $this->Payment_model->get_paymentListByClientID($clientId);
		$regionList = $this->Region_model->get_regionList();

		$loans = $this->Loan_model->get_loanListByClient($clientId);

		$loanList = array();
		$loanHistory = array();

		if ($loans) {
			#	Luego clasificarlos en 2 arrays
			foreach ($loans as $loan) {
				if ($loan->prt_estado) {
					$loanList[] = $loan;
				} else {
					$loanHistory[] = $loan;
				}
			}
		} else {
			$loanList = $loanHistory = FALSE;
		}
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE)
		{
			redirect(_App_.'404_override');
		}		
		else
		{
			$data = array(
			'clientInfo' => $clientInfo,
			'loanList' => $loanList,
			'loanHistory' => $loanHistory,
			'paymentList' => $paymentList,
			'regionList' => $regionList
			);
			$data['title'] = $clientInfo->cli_nombre;
			$this->load->view("mobile/header");
    		$this->load->view("mobile/sidebar");
    		$this->load->view("mobile/client_view", $data);
    		$this->load->view("mobile/footer");
		}
	}


	/**
	 * Recibe el identificador del cliente y muestra su perfil.
	 *
	 * @return void
	 * @author Bryan Jimenez <brijir08@gmail.com>
	 **/
	function displayProfile($clientId)
	{
		$this->load->model('Loan_model');
		$this->load->model('Payment_model');

		$this->db->trans_start();
		# Pide la informacion de ese cliente
		$clientInfo = $this->Client_model->get_clientByID($clientId);

		if (!$clientInfo) {
			redirect(_App_."404?".uri_string());
		}

		$paymentList = $this->Payment_model->get_paymentListByClientID($clientId);
		$regionList = $this->Region_model->get_regionList();

		$loans = $this->Loan_model->get_loanListByClient($clientId);

		$loanList = array();
		$loanHistory = array();

		if ($loans) {
			#	Luego clasificarlos en 2 arrays
			foreach ($loans as $loan) {
				if ($loan->prt_estado) {
					$loanList[] = $loan;
				} else {
					$loanHistory[] = $loan;
				}
			}
		} else {
			$loanList = $loanHistory = FALSE;
		}
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE)
		{
			redirect(_App_.'404_override');
		}		
		else
		{
			$data = array(
			'clientInfo' => $clientInfo,
			'loanList' => $loanList,
			'loanHistory' => $loanHistory,
			'paymentList' => $paymentList,
			'regionList' => $regionList
			);
			$data['title'] = $clientInfo->cli_nombre;
			$this->load->view("static/header", $data);
			$this->load->view("static/sidebar");
			$this->load->view("client_view", $data);
			$this->load->view("static/footer");
		}
	}

	/**
	 * Crear un nuevo cliente
	 *
	 * @return void
	 * @author Gerson Rodriguez <nosreg216@gmail.com>
	 **/
	function addProfile()
	{
		$nombre = $this->input->post('nombre');
		$cedula = $this->input->post('cedula');
		$telefono = $this->input->post('telefono');
		$region = $this->input->post('region');
		$region2 = $this->input->post('region2');
		$region3 = $this->input->post('region3');
		$direccion = $this->input->post('direccion');
		$notas = $this->input->post('notas');
		$direccionGps = $this->input->post('direccionGps');

		$fecha  = unix_to_human(time(), TRUE, 'eu');
		
		$cedulaExis = $this->Client_model->cedula_client($cedula);
		
		if($cedulaExis == $cedula)
		{
			echo "<script>";
			echo "alert('Ya existe un cliente con esta cédula, vuelve a ingresar al cliente.');";  
			echo "history.back();";  //window.location = 'https://solucioneshym.co/clientes/'; tambien sirve para regresar a la página
			echo "</script>"; 
		}else{
			$data = array(
				'cli_nombre' => $nombre,
				'cli_telefono' => $telefono,
				'cli_region' => $region,
				'cli_region2' => $region2,
				'cli_region3' => $region3,
				'cli_direccion' => $direccion,
				'cli_notas' => $notas,
				'cli_registro' => $fecha,
				'cli_cedula' => $cedula,
				'cli_direccion_gps' => $direccionGps
				);
			$this->db->trans_start();
			$client = $this->Client_model->add_client($data);
			$this->db->trans_complete();

			if ($this->db->trans_status() === FALSE)
			{
				redirect(_App_.'clientes?err');
			}		
			else
			{
				redirect(_App_."clientes/$client");
			}
		}
	}

	/**
	 * Eliminar el cliente (Solo para desarrollo)
	 *
	 * @return void
	 * @author Gerson Rodriguez <nosreg216@gmail.com>
	 **/
	function deleteProfile()
	{	
		$client = $this->input->post('cliente');
		$this->db->trans_start();
		$this->Client_model->delete_client($client);
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE)
		{
			redirect(_App_.'clientes?err');
		}		
		else
		{
			redirect(_App_."clientes");
		}
	}

	/**
	 * Actualizar la informacion del cliente
	 *
	 * @return void
	 * @author Gerson Rodriguez <nosreg216@gmail.com>
	 **/
	function updateProfile()
	{
		$nombre = $this->input->post('nombre');
		$cedula = $this->input->post('cedula');
		$telefono = $this->input->post('telefono');
		$region = $this->input->post('region');
		$region2 = $this->input->post('region2');
		$region3 = $this->input->post('region3');
		$direccion = $this->input->post('direccion');
		$notas = $this->input->post('notas');
		$clientID = $this->input->post('clientID');
		$mobile = $this->input->post('mobile');
		$direccionGps = $this->input->post('direccionGps');
		
		$data = array(
			'cli_nombre' => $nombre,
			'cli_telefono' => $telefono,
			'cli_region' => $region,
			'cli_region2' => $region2,
			'cli_region3' => $region3,
			'cli_direccion' => $direccion,
			'cli_notas' => $notas,
			'cli_cedula' => $cedula,
			'cli_direccion_gps' => $direccionGps
			);
		$this->db->trans_start();
		$client = $this->Client_model->update_client($clientID, $data);
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE)
		{
			redirect(_App_.'clientes?err');
		}		
		else
		{
		    if($mobile !== NULL){
               redirect(_App_.'cobros/clientes/'.$client);
            }
            else{
               redirect(_App_.'clientes/'.$client);
            }
		}
	}
} // END class Client