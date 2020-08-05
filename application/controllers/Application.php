<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Application extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('User_model');
		$this->load->model('Application_model');
	}

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author Gerson Rodriguez <nosreg216@gmail.com>
	 **/
	function index()
	{
		$this->load->model('Payment_model');
		/*Login Validation */
		if ($this->session->log_status == 'success') {
			$this->db->trans_start();

			#	Pedir los contadores de objetos
			$loanTotal = $this->Application_model->get_loanCount();
			$colabTotal = $this->Application_model->get_colaboratorCount();
			$clientTotal = $this->Application_model->get_clientCount();
			$regionTotal = $this->Application_model->get_regionCount();

			#	Calcular los ingresos totales
			$week = date('Y-m-d 23:59:59', strtotime('last sunday'));
			$month = date('Y-m-01');
			$today = date('Y-m-d H:i:s');

			$revenueToday = $this->Payment_model->get_revenueToday();
			$revenueWeek = $this->Payment_model->get_revenueRange($week, $today);
			$revenueMonth = $this->Payment_model->get_revenueRange($month, $today);
			
			$expensesToday = $this->Payment_model->get_revenueTodayPrestamo();
			$expensesWeek = $this->Payment_model->GetRevenueRegionRangePrestamo($week, $today);
			$expensesMonth = $this->Payment_model->GetRevenueRegionRangePrestamo($month, $today);

			$this->db->trans_complete();

			#	Cuando no hay pagos, el monto debe ser 0. La funcion retorna null.
			if (!$revenueToday[0]->abn_monto) {
				$revenueToday[0]->abn_monto = 0;
			}

			if (!$revenueWeek[0]->abn_monto) {
				$revenueWeek[0]->abn_monto = 0;
			}

			if (!$revenueMonth[0]->abn_monto) {
				$revenueMonth[0]->abn_monto = 0;
			}

			if ($this->db->trans_status() === FALSE)
			{
				redirect(_App_.'404_override');
			}		
			else
			{
				$data = array(
				'loanTotal' => $loanTotal,
				'colabTotal' => $colabTotal,
				'clientTotal' => $clientTotal,
				'regionTotal' => $regionTotal,

				'revenueToday' => $revenueToday,
				'revenueWeek' => $revenueWeek,
				'revenueMonth' => $revenueMonth,
				
				'expensesToday' => $expensesToday,
				'expensesWeek' => $expensesWeek,
				'expensesMonth' => $expensesMonth
				
				);
			
				/*Load the view files*/
				$data['title'] = "Inicio";
				$this->load->view("static/header", $data);
				$this->load->view("static/sidebar");
				$this->load->view("dashboard_view", $data);
				$this->load->view("static/footer");
			}
		} else {	
			
			$data['ref'] = $this->input->get('ref');
			/*Load the login view file */
			$this->load->view('login_view', $data);
		}
	}
	
	/**
	 * undocumented function
	 *
	 * @return void
	 * @author Carlos Carreño <cartur70@gmail.com>
	 **/
	function client_index()
	{	
		$this->load->model('Client_model');
		$this->load->model('Region_model');
		$this->load->model('Payment_model');

		/*Login Validation */
		if ($this->session->log_status == 'mobile') {

			$colab = $this->session->log_user;
			$day = date('N');
			switch ($day) {
				case 1: $day = 'L'; break;
				case 2: $day = 'K'; break;
				case 3: $day = 'M'; break;
				case 4: $day = 'J'; break;
				case 5: $day = 'V'; break;
				case 6: $day = 'S'; break;
				case 7: $day = 'D'; break;
			}
			$date = date('d');

			$this->db->trans_start();

			$regionList = $this->Region_model->get_regionByColabDay($colab, $day);

			if ($regionList) {
				foreach ($regionList as $region) {
					$clientList = $this->Client_model->get_clientListByRegionAndType($region->reg_id,$region->prt_tipo);
					
					$clientList2 = $this->Client_model->get_clientListByRegionAndTypeWithoutLoan($region->reg_id,$region->prt_tipo,$clientList);
					
					$a = $clientList;
					/* Filtrar solo los que esten al cobro este dia */
					$cleanList = array();
					if($clientList) {
						foreach ($clientList as $info) {
						switch ($info->prt_tipo) {
							case 'D': $cleanList[] = $info; break;
							case 'S': if ($info->prt_dia == $day) { $cleanList[] = $info; } break;
							case 'Q': if ($date % 15 == 0) { $cleanList[] = $info;} break; 
						}
					}
					}
					$region->clientList = (count($cleanList) > 0 ) ? $cleanList : FALSE;
					$region->clientListwithoutloan = $clientList2;
					$region->prueba = $a;
				}
			}
			
			$revenue = $this->Payment_model->get_todayRevenueByColabID($colab);
			if ($revenue->abn_monto == NULL) {
				$revenue->abn_monto = 0;
			}

			$this->db->trans_complete();

			if ($this->db->trans_status() === FALSE)
			{
				redirect(_App_.'404_override');
			}		
			else
			{
				$data = array(
				'today' => $day,
				'regionList' => $regionList,
				'revenue' => $revenue->abn_monto
				);

				/*Load the view files*/
				$this->load->view("mobile/header");
				$this->load->view("mobile/sidebar");
				$this->load->view("mobile/clientList_view", $data);
				$this->load->view("mobile/footer");
			}
			
		} else {	
			/*Load the login view file */
			$data['ref'] = $this->input->get('ref');
			$this->load->view('mobile/login_view', $data);
		}
	}

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author Carlos Carreño
	 **/
	function mobile_index()
	{	
	    $this->load->model('Payment_model');
	    if ($this->session->log_status == 'mobile') {

            $colab = $this->session->log_user;
			$this->db->trans_start();
			#	Pedir los contadores de objetos
			$loanTotal = $this->Application_model->get_loanCountBycolaborator($colab);
			$clientTotal = $this->Application_model->get_clientCountBycolaborator($colab);
			$regionTotal = $this->Application_model->get_regionCountBycolaborator($colab);

			#	Calcular los ingresos totales
			$week = date('Y-m-d 23:59:59', strtotime('last sunday'));
			$month = date('Y-m-01');
			$today = date('Y-m-d H:i:s');

			$revenueToday = $this->Payment_model->get_revenueToday();
			$revenueWeek = $this->Payment_model->get_revenueRange($week, $today);
			$revenueMonth = $this->Payment_model->get_revenueRange($month, $today);
			
			$expensesToday = $this->Payment_model->get_revenueTodayPrestamo();
			$expensesWeek = $this->Payment_model->GetRevenueRegionRangePrestamo($week, $today);
			$expensesMonth = $this->Payment_model->GetRevenueRegionRangePrestamo($month, $today);

			$this->db->trans_complete();

			#	Cuando no hay pagos, el monto debe ser 0. La funcion retorna null.
			if (!$revenueToday[0]->abn_monto) {
				$revenueToday[0]->abn_monto = 0;
			}

			if (!$revenueWeek[0]->abn_monto) {
				$revenueWeek[0]->abn_monto = 0;
			}

			if (!$revenueMonth[0]->abn_monto) {
				$revenueMonth[0]->abn_monto = 0;
			}

			if ($this->db->trans_status() === FALSE)
			{
				redirect(_App_.'404_override');
			}		
			else
			{
				$data = array(
				'loanTotal' => $loanTotal,
				'clientTotal' => $clientTotal,
				'regionTotal' => $regionTotal,

				'revenueToday' => $revenueToday,
				'revenueWeek' => $revenueWeek,
				'revenueMonth' => $revenueMonth,

				'expensesToday' => $expensesToday,
				'expensesWeek' => $expensesWeek,
				'expensesMonth' => $expensesMonth
				
				);
			
				/*Load the view files*/
				$data['title'] = "Inicio";
        		$this->load->view("mobile/header");
        		$this->load->view("mobile/sidebar");
        		$this->load->view("mobile/dashboard_view", $data);
        		$this->load->view("mobile/footer");
			}
		} else {
			/*Load the login view file */
			$data['ref'] = $this->input->get('ref');
			$this->load->view('mobile/login_view', $data);
		}
	}
	
	/**
	 * undocumented function
	 *
	 * @return void
	 * @author Carlos Carreño <cartur70@gmail.com>
	 **/
	function mobile_colaboratorDayAccounting()
	{
	    $this->load->model('Expense_model');
	    if ($this->session->log_status == 'mobile') {
	        $colab = $this->session->log_user;
			$this->db->trans_start();
			#	Pedir los contadores de objetos
			$fecha_Inicial = date('Y-m-d 00:00:00', time());
			$fecha_Final = date('Y-m-d H:i:s', time());
			$loanTotal = $this->Application_model->get_totalLoanTodayBycolaborator($colab, $fecha_Inicial, $fecha_Final);
			$expensesTotal = $this->Expense_model->get_totalExpensesTodayBycolaborator($colab);
			$raisedTotal = $this->Application_model->get_totalRaisedTodayBycolaborator($colab, $fecha_Inicial, $fecha_Final);
			$availableTotal = $this->Application_model->get_totalAvailableBycolaborator($colab);
			$total = ($availableTotal + $raisedTotal) - ($expensesTotal + $loanTotal);
			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE)
			{
				redirect(_App_.'404_override');
			}		
			else
			{
				$data = array(
				'loanTotal' => $loanTotal,
				'expensesTotal' => $expensesTotal,
				'raisedTotal' => $raisedTotal,
				'availableTotal' => $availableTotal,
				'total' => $total
				);
    	        /*Load the view files*/
    			$data['title'] = "Inicio";
        		$this->load->view("mobile/header");
        		$this->load->view("mobile/sidebar");
        		$this->load->view("mobile/accounting_view", $data);
        		$this->load->view("mobile/footer");
			}
	    } else {
			/*Load the login view file */
			$data['ref'] = $this->input->get('ref');
			$this->load->view('mobile/login_view', $data);
		}
	}

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author Gerson Rodriguez <nosreg216@gmail.com>
	 **/
	function config_index()
	{	
		$this->db->trans_start();
		$intereses = $this->Application_model->get_interest();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE)
		{
			redirect(_App_.'404_override');
		}		
		else
		{
			$data['intereses'] = $intereses->app_intereses;

			$data['title'] = "configuración";
			$this->load->view('static/header', $data);
			$this->load->view('static/sidebar');
			$this->load->view('settings_view', $data);
			$this->load->view('static/footer');
		}
	}

	public function updateConfig()
	{	
		$intereses = $this->input->post('intereses');

		$this->db->trans_start();
		if ($intereses > 0) {
			$data['app_intereses'] = $intereses;
			$success = $this->Application_model->update_config($data);
		}
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE)
		{
			redirect(_App_.'404_override');
		}		
		else
		{
			redirect(_App_.'configuracion?modal=modal-update');
		}
	}

	/**
	 * Valida el usuario y la contraseña para permitir el acceso.
	 *
	 * @return boolean
	 * @author Gerson Rodriguez <nosreg216@gmail.com>
	 **/
	function login()
	{
		$this->load->model('Colaborator_model');

		#	Tomar los valores del formulario.
		$username = $this->input->post('username');
		$password = $this->input->post('password');

		$this->db->trans_start();

		#	Solicitar la informacion del usuario.
		$userInfo = $this->User_model->get_dataByUsername($username);
		if (!$userInfo) {
			redirect(_App_.'error');
		}

		#	Definir los datos del usuario para la cookie.
		$hash = $userInfo->usr_pwd;
		$user = $userInfo->usr_id;
		$role = $userInfo->usr_role;
		
		$name = empty($userInfo->usr_name) ? "Usuario":$userInfo->usr_name;

		#	Validar la informacion.
		$access = password_verify($password, $hash);
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE)
		{
			redirect(_App_.'error');
		}		
		else
		{
			if($access AND ($role == 'A' OR $role == 'M')) {
				$this->session->log_user = empty($user)?"Admin_Master":$user;
				$this->session->log_name = empty($name)?"Admin_Master":$name;
				$this->session->log_role = $role;
				$this->session->log_status = 'success';
			}
			if ($userInfo->pwd_temp == 1) {
				$data['title'] = "Cambiar contraseña";
				$data['error'] = FALSE;
				$this->load->view("static/header", $data);
				$this->load->view("restore_view");
			} else {
				#	Reireccionar a la pagina de inicio.
				$ref = $this->input->post('ref');
				redirect(_App_.$ref);
			}
		}
	}

	/**
	 * Valida el usuario y la contraseña para permitir el acceso.
	 *
	 * @return boolean
	 * @author Gerson Rodriguez <nosreg216@gmail.com>
	 **/
	/**
	 * Valida el usuario y la contraseña para permitir el acceso.
	 *
	 * @return boolean
	 * @author Gerson Rodriguez <nosreg216@gmail.com>
	 **/
	function mobile_login()
	{
		$this->load->model('Colaborator_model');

		#	Tomar los valores del formulario.
		$usuario = $this->input->get('username');
		$password = $this->input->get('password');

		$this->db->trans_start();
		#	Solicitar la informacion del colab.
		$colaboratorInfo = $this->Colaborator_model->get_colaboratorByUser($usuario);
		if (!$colaboratorInfo) { redirect(_App_.'cobros/error'); }

		#	Definir los datos del colab.
		$colab = $colaboratorInfo->clb_id;
		$name = $colaboratorInfo->clb_nombre;
		$role = $colaboratorInfo->clb_role;
		
		#	Solicitar la informacion del usuario.
		$userInfo = $this->User_model->get_userByID($colab);
		
		#	Definir los datos del usuario.
		$hash = $userInfo->usr_pwd;
		//$role = $userInfo->usr_role;

		#	Validar la informacion.
		$access = password_verify($password, $hash);
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE)
		{
			redirect(_App_.'cobros/error');
		}		
		else
		{
			if (!$colaboratorInfo->clb_estado) {
				redirect(_App_.'cobros/errorI');
			}

			if($access AND $role == 'C'){
				#	Guardar los datos en la cookie.
			    $this->session->log_role = $role;
			    $this->session->log_status = 'mobile';
			    $this->session->log_user = $colab;
			    $this->session->log_name = $name;

			if ($userInfo->pwd_temp) {
				/*Load the view files*/
				$data['error'] = FALSE;
				$this->load->view("mobile/restore_view", $data);
			} else {
				#	Reireccionar a la pagina de inicio.
				$ref = $this->input->post('ref');
				redirect(_App_.'cobros'.$ref);
			}
		}
	}
	}

	/**
	 * Destruye la sesion y redirecciona al login
	 *
	 * @return void
	 * @author Gerson Rodriguez <nosreg216@gmail.com>
	 **/
	function logout()
	{
		$this->session->sess_destroy();
		$ref = $this->input->get('ref');
		redirect(_App_.$ref);
	}

	/**
	 * Pagina de error: 404 No encontrado
	 *
	 * @return void
	 * @author Gerson Rodriguez <nosreg216@gmail.com>
	 **/
	function error_404()
	{
		$this->load->view("static/header");
		$this->load->view("static/sidebar");
		$this->load->view("errors/404");
		$this->load->view("static/footer");
	}
}
