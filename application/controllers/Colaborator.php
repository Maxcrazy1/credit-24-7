<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Controlador del perfil de los empleados.
 *
 * @package controllers
 * Bryan Jimenez <brijir08@gmail.com>
 **/
class Colaborator extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Colaborator_model');
	}

	/**
	 * Metodo principal. Muestra la lista de empleados activos.
	 *
	 * @return void
	 * @author Gerson Rodriguez <nosreg216@gmail.com>
	 **/
	function index ()
	{		
		#Lista de todos los colaboradores
		$this->db->trans_start(TRUE);

		$colaboratorList = $this->Colaborator_model->get_colaboratorList();

		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE)
		{
			redirect(_App_.'colaboradores?err');
		}		
		else
		{
			$data = array(
			'colaboratorList' => $colaboratorList
			);

			$data['title'] = "Colaboradores";
			$this->load->view("static/header", $data);
			$this->load->view("static/sidebar");
			# Cargar la vista de colaboradores pasandole por parametro la lista de colaboradores
			$this->load->view("colaboratorList_view",$data);
			$this->load->view("static/footer");
		}
	}

	/**
	 * Recibe el codigo de emepleado y muestra su perfil.
	 *
	 * @return void
	 * Carlos Carreño <cartur70@gmail.com>
	 **/
	function displayProfile($colaboratorId)
	{
		$this->load->model('Payment_model');
		$this->load->model('Loan_model');
		
		$this->load->model('Client_model');
		$this->load->model('Region_model');
		
		$this->load->model('Application_model');
		$this->load->model('Expense_model');

		# Pide la informacion de ese cliente
		$this->db->trans_start();

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
        # RegionList recoge la lista de clientes por region para el colaborador
		$regionList = $this->Region_model->get_regionByColabDay($colaboratorId, $day);

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
        # expenseList lista los gastos del colaborador en el dia
        $expenseList = $this->Expense_model->get_expenseListTodayByColaborator($colaboratorId);

		$colaboratorInfo = $this->Colaborator_model->get_colaboratorByID($colaboratorId);
		if (!$colaboratorInfo) {
			redirect(_App_."404?".uri_string());
		}
		$paymentList = $this->Payment_model->get_paymentListByColabID($colaboratorId);
		$loanList = $this->Loan_model->get_loanListByColabID($colaboratorId);
		$revenueColab = $this->Payment_model->get_todayRevenueByColabID($colaboratorId);
		if ($revenueColab->abn_monto == NULL) {
			$revenueColab->abn_monto = 0;
		}

			#	Pedir los contadores de objetos
			$fecha_Inicial = date('Y-m-d 00:00:00', time());
			$fecha_Final = date('Y-m-d H:i:s', time());
			$loanTotal = $this->Application_model->get_totalLoanTodayBycolaborator($colaboratorId, $fecha_Inicial, $fecha_Final);
			$expensesTotal = $this->Expense_model->get_totalExpensesTodayBycolaborator($colaboratorId);
			$raisedTotal = $this->Application_model->get_totalRaisedTodayBycolaborator($colaboratorId, $fecha_Inicial, $fecha_Final);
			$availableTotal = $this->Application_model->get_totalAvailableBycolaborator($colaboratorId);
			$total = ($availableTotal + $raisedTotal) - ($expensesTotal + $loanTotal);

		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE)
		{
			redirect(_App_.'colaboradores?err');
		}		
		else
		{
		    if ($paymentList){
    		    $x = 0;
    		    foreach($paymentList as $row) {
        		    $status = $row->abn_status;
        		    $status = ($status == '') ? 5 : $status;
        		    switch ($status) {
                        case 0:
                            $statusColor = "bg-red-light";
                            break;
                        case 1:
                            $statusColor = "bg-aqua-light";
                            break;
                        case 2:
                            $statusColor = "bg-green-light";
                            break;
                        default:
                            $statusColor = "";
                            break;
                    }
        		    $paymentList[$x]->abn_status = $statusColor;
        		    $x++;
		        }
		    }
			$data = array(
			'colaboratorInfo' => $colaboratorInfo,
			'paymentList' => $paymentList,
			'revenueColab' => $revenueColab->abn_monto,
			'loanList' => $loanList,
			
			'regionList' => $regionList,
			'expenseList' => $expenseList,
			
			'loanTotal' => $loanTotal,
			'expensesTotal' => $expensesTotal,
			'raisedTotal' => $raisedTotal,
			'availableTotal' => $availableTotal,
			'total' => $total
			);

			$data['title'] = $colaboratorInfo->clb_nombre;
			$this->load->view("static/header", $data);
			$this->load->view("static/sidebar");
			$this->load->view("colaborator_view", $data);
			$this->load->view("static/footer");
		}		
	}

	/**
	 * Crear un nuevo colaborador
	 *
	 * @return void
	 * @author Gerson Rodriguez <nosreg216@gmail.com>
	 **/
	function addProfile()
	{
		$this->load->model('User_model');
		
		#	set up variables
		$nombre = $this->input->post('nombre');
		$telefono = $this->input->post('telefono');
		$notas = $this->input->post('notas');
		
		$usuario = $this->input->post('usuario');
		$pass = $this->input->post('password');
		$password = password_hash($pass, PASSWORD_DEFAULT);
		
		$telExis = $this->Colaborator_model->tel_colaborador($telefono);
		if($telExis == $telefono)
		{
			echo "<script>";
			echo "alert('Ya existe un colaborador con este teléfono, vuelve a ingresar al colaborador.');";  
			echo "history.back();";  //window.location = 'https://solucioneshym.co/colaboradores/'; tambien sirve para regresar a la página
			echo "</script>"; 
		}else{

			$this->db->trans_start();

			$profile_data = array(
				'clb_nombre' => $nombre,
				'clb_usuario' => $usuario,
				'clb_telefono' => $telefono,
				'clb_notas' => $notas,
				'clb_role' => 'C'
				);

			$colaborator = $this->Colaborator_model->add_Colaborator($profile_data);

			$user_data = array(
				'usr_id' => $colaborator,
				'usr_name' => $usuario,
				'usr_pwd' => $password,
				'usr_email' => 'colaborator',
				'usr_role' => 'C'
				);

			$user = $this->User_model->add_User($user_data);
			$this->db->trans_complete();

			if ($this->db->trans_status() === FALSE)
			{
				redirect(_App_.'colaboradores?err');
			}
			else
			{
				redirect(_App_."colaboradores/$colaborator");
			}
		}
	}

	/**
	 * Actualizar la informacion del colaborador
	 *
	 * @return void
	 * @author Bryan Jimenez <brijir08@gmail.com>
	 **/
	function updateProfile()
	{
		$nombre = $this->input->post('nombre');
		$telefono = $this->input->post('telefono');
		$notas = $this->input->post('notas');
		$colaboratorID = $this->input->post('colaboratorID');

		$data = array(
			'clb_nombre' => $nombre,
			'clb_telefono' => $telefono,
			'clb_notas' => $notas,
			);
		$this->db->trans_start();

		$colaborator = $this->Colaborator_model->update_colaborator($colaboratorID,$data);

		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE)
		{
			redirect(_App_.'colaboradores?err');
		}		
		else
		{
			redirect(_App_.'colaboradores/'.$colaborator);
		}
	}
	
	/**
	 * Actualizar la informacion del colaborador
	 *
	 * @return void
	 * @author Bryan Jimenez <brijir08@gmail.com>
	 **/
	function updateAvailable()
	{
		$disponible = $this->input->post('disponible');
		$colaboratorID = $this->input->post('colaboratorID');

		$data = array(
			'clb_disponible' => $disponible
			);
		$this->db->trans_start();

		$colaborator = $this->Colaborator_model->update_colaborator($colaboratorID,$data);

		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE)
		{
			redirect(_App_.'colaboradores?err');
		}		
		else
		{
			redirect(_App_.'colaboradores/'.$colaborator);
		}
	}

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author Gerson Rodriguez <nosreg216@gmail.com>
	 **/
	function toogleStatus($colabId, $status)
	{
		$redirect = $this->input->get('rdr');

		$data = array(
			'clb_id' => $colabId,
			'clb_estado' => $status,
			);
		$this->db->trans_start();
		$colaborator = $this->Colaborator_model->update_colaborator($colabId,$data);
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE)
		{
			redirect(_App_.'colaboradores?err');
		}		
		else
		{
			if ($redirect == 'list') {
				redirect(_App_.'colaboradores/');
			} else {
				redirect(_App_.'colaboradores/'.$colaborator);	
			}
		}
		
	}

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author Gerson Rodriguez <nosreg216@gmail.com>
	 **/
	function toogleStatusAll($status)
	{
		$this->db->trans_start();
		$data = array( 'clb_estado' => $status );
		$success = $this->Colaborator_model->update_colaboratorList($data);
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE)
		{
			redirect(_App_.'colaboradores?err');
		}		
		else
		{
			redirect(_App_.'colaboradores');
		}
	}

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author Gerson Rodriguez <nosreg216@gmail.com>
	 **/
	function deleteProfile()
	{
		$this->db->trans_start();

		$colaborator = $this->input->post('colaborador');
		$this->Colaborator_model->delete_colaborator($colaborator);

		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE)
		{
        redirect(_App_.'colaboradores?err');
		}		
		else
		{
        redirect(_App_.'colaboradores');
		}
	}
	
	/**
	 * Usa el codigo del empleado en sesion para mostrar su perfil
	 *
	 * @return void
	 * @author Carlos Carreño <cartur70@gmail.com>
	 **/
	function myProfile()
	{
	    $this->load->model('Payment_model');
	    $this->load->model('Loan_model');

		# Pide la informacion de ese cliente
		$this->db->trans_start();
        $colaboratorId = $this->session->log_user;
		$colaboratorInfo = $this->Colaborator_model->get_colaboratorByID($colaboratorId);
		if (!$colaboratorInfo) {
			redirect(_App_."404?".uri_string());
		}
	    $revenueColab = $this->Payment_model->get_todayRevenueByColabID($colaboratorId);
		if ($revenueColab->abn_monto == NULL) {
			$revenueColab->abn_monto = 0;
		}
        
        $paymentList = $this->Payment_model->get_paymentListByColabID($colaboratorId);
		$loanList = $this->Loan_model->get_loanListByColabID($colaboratorId);
        
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE)
		{
			redirect(_App_.'colaboradores?err');
		}		
		else
		{
            if ($paymentList){
    		    $x = 0;
    		    foreach($paymentList as $row) {
        		    $status = $row->abn_status;
        		    $status = ($status == '') ? 5 : $status;
        		    switch ($status) {
                        case 0:
                            $statusColor = "bg-red-light";
                            break;
                        case 1:
                            $statusColor = "bg-aqua-light";
                            break;
                        case 2:
                            $statusColor = "bg-green-light";
                            break;
                        default:
                            $statusColor = "";
                            break;
                    }
        		    $paymentList[$x]->abn_status = $statusColor;
        		    $x++;
		        }
		    }
			
			$data = array(
			'colaboratorInfo' => $colaboratorInfo,
			'revenueColab' => $revenueColab->abn_monto,
			'paymentList' => $paymentList,
			'loanList' => $loanList
			);

			$this->load->view("mobile/header");
    		$this->load->view("mobile/sidebar");
    		$this->load->view("mobile/profile_view", $data);
    		$this->load->view("mobile/footer");
		}
	}
	
	/**
	 * Muestras los cobros y prestamos del dia realizados por un empleado.
	 *
	 * @return void
	 * @author Carlos Carreño <cartur70@gmail.com>
	 **/
	function displayLoanColaboratorToday()
	{
		$this->load->model('Payment_model');
		$this->load->model('Loan_model');

		# Pide la informacion de ese cliente
		$this->db->trans_start();

        $colaboratorId = $this->session->log_user;
		$colaboratorInfo = $this->Colaborator_model->get_colaboratorByID($colaboratorId);
		if (!$colaboratorInfo) {
			redirect(_App_."404?".uri_string());
		}
		$paymentList = $this->Payment_model->get_paymentListByColabID($colaboratorId);
		$loanList = $this->Loan_model->get_loanListByColabID($colaboratorId);
		$revenueColab = $this->Payment_model->get_todayRevenueByColabID($colaboratorId);
		if ($revenueColab->abn_monto == NULL) {
			$revenueColab->abn_monto = 0;
		}

		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE)
		{
			redirect(_App_.'colaboradores?err');
		}		
		else
		{
		    if ($paymentList){
    		    $x = 0;
    		    foreach($paymentList as $row) {
        		    $status = $row->abn_status;
        		    $status = ($status == '') ? 5 : $status;
        		    switch ($status) {
                        case 0:
                            $statusColor = "bg-red-light";
                            break;
                        case 1:
                            $statusColor = "bg-aqua-light";
                            break;
                        case 2:
                            $statusColor = "bg-green-light";
                            break;
                        default:
                            $statusColor = "";
                            break;
                    }
        		    $paymentList[$x]->abn_status = $statusColor;
        		    $x++;
		        }
		    }
			$data = array(
			'paymentList' => $paymentList,
			'revenueColab' => $revenueColab->abn_monto,
			'loanList' => $loanList
			);

			$this->load->view("mobile/header");
    		$this->load->view("mobile/sidebar");
    		$this->load->view("mobile/loantodaylist_view", $data);
    		$this->load->view("mobile/footer");
		}
	}

} // END class Colaborator