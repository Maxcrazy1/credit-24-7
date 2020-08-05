<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Controla la inicio y cierre de sesiones.
 * Controla la creacion y modificacion de usuarios.
 *
 * @package controllers
 * @author Gerson Rodriguez <nosreg216@gmail.com>
 **/
class User extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('User_model');
	}

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author Bryan Jimenez <brijir08@gmail.com>
	 **/
	function index()
	{	
		$this->db->trans_start();
        #Lista de todos los colaboradores
		$userList = $this->User_model->get_userList();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE)
		{
			redirect(_App_.'404_override');
		}		
		else
		{
			$data = array(
			'userList' => $userList
			);

			$data['title'] = "Usuarios";
			$this->load->view("static/header", $data);
			$this->load->view("static/sidebar");
			# Cargar la vista de usuarios pasandole por parametro la lista de usuarios
			$this->load->view("userList_view",$data);
			$this->load->view("static/footer");
		}
	}

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author Bryan Jimenez <brijir08@gmail.com>
	 **/
	function addProfile()
	{
		$this->load->model('Colaborator_model');
		
		#	set up variables
		$nombre = $this->input->post('nombre');
		$telefono = $this->input->post('telefono');
		$notas = $this->input->post('notas');

		$usuario = $this->input->post('usuario');
		$email = $this->input->post('correo');	
		$pass = $this->input->post('password');
		$password = password_hash($pass, PASSWORD_DEFAULT);

		$this->db->trans_start();
		$profile_data = array(
			'clb_nombre' => $nombre,
			'clb_usuario' => $usuario,
			'clb_telefono' => $telefono,
			'clb_notas' => $notas,
			'clb_role' => 'A'
			);
		$colaborator = $this->Colaborator_model->add_Colaborator($profile_data);

		$user_data = array(
			'usr_id' => $colaborator,
			'usr_name' => $usuario,
			'usr_pwd' => $password,
			'usr_email' => $email,
			'usr_role' => 'A'
			);
		$user = $this->User_model->add_User($user_data);
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE)
		{
			redirect(_App_.'usuarios?err');
		}		
		else
		{
			redirect(_App_."usuarios/$colaborator");
		}
	}

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author Bryan Jimenez <brijir08@gmail.com>
	 **/
	function removeUser()
	{
		$userId = $this->input->post('usuario');
		$this->db->trans_start();
		$user = $this->User_model->delete_User($userId);
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE)
		{
			redirect(_App_.'usuarios?err');
		}		
		else
		{
			redirect(_App_."usuarios");
		}
	}

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author Bryan Jimenez <brijir08@gmail.com>
	 **/
	function removeAdmin()
	{
		$this->load->model('Colaborator_model');

		$userId = $this->input->post('usuario');
		$this->db->trans_start();
		$data1 = array(
			'clb_role' => "C"
			);
		$data = array(
			'usr_role' => "C",
			'usr_name' => "noaccess",
			'usr_email' => "colaborator"
			);
		$colab = $this->Colaborator_model->change_colab($userId,$data1);
		$user = $this->User_model->delete_admin($userId,$data);
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE)
		{
			redirect(_App_.'usuarios?err');
		}		
		else
		{
			redirect(_App_."usuarios");
		}
	}

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author Bryan Jimenez <brijir08@gmail.com>
	 **/
	function updateProfile()
	{
		$userId = $this->input->post('usuario');
		$nombre = $this->input->post('nombre');
		$email = $this->input->post('correo');
		
		$this->db->trans_start();
		$data = array(
			'usr_name' => $nombre,
			'usr_email' => $email
			);

		$user = $this->User_model->update_User($userId,$data);
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE)
		{
			redirect(_App_.'usuarios?err');
		}		
		else
		{
			redirect(_App_.'usuarios/'.$user);
		}
	}

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author Bryan Jimenez <brijir08@gmail.com>
	 **/
	function displayProfile($userId)
	{
		$this->load->model('Payment_model');
		$this->load->model('Loan_model');

		$this->db->trans_start();
		# Pide la informacion de ese cliente
		$userInfo = $this->User_model->get_userByID($userId);
		if (!$userInfo) {
			redirect(_App_."404?".uri_string());
		}
		$paymentList = $this->Payment_model->get_paymentListByColabID($userId);
		$loanList = $this->Loan_model->get_loanListByColabID($userId);
		$revenueColab = $this->Payment_model->get_todayRevenueByColabID($userId);
		if ($revenueColab->abn_monto == NULL) {
			$revenueColab->abn_monto = 0;
		}
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE)
		{
			redirect(_App_.'404_override');
		}		
		else
		{
			$data = array(
			'userInfo' => $userInfo,
			'paymentList' => $paymentList,
			'revenueColab' => $revenueColab->abn_monto,
			'loanList' => $loanList
			);

			$data['title'] = "Perfil: " . $userInfo->usr_name;
			$this->load->view("static/header", $data);
			$this->load->view("static/sidebar");
			$this->load->view("user_view", $data);
			$this->load->view("static/footer");
		}
	}


	/**
	 * undocumented function
	 *
	 * @return void
	 * @author Gerson Rodriguez <nosreg216@gmail.com>
	 **/
	function changePassword()
	{
		$user = $this->session->log_user;

		$pass1 = $this->input->get('password1');
		$pass2 = $this->input->get('password2');

		if ($pass1 === $pass2 AND $pass1 != '1234') {
			$hash = password_hash($pass1, PASSWORD_DEFAULT);
			$data = array( 'usr_pwd' => $hash, 'pwd_temp' => 0 );

			$this->db->trans_start();
			$success = $this->User_model->update_User($user, $data);
			$this->db->trans_complete();

			if ($this->db->trans_status() === FALSE)
			{
				redirect(_App_.'cobros/error');
			}		
			else
			{
				redirect(_App_.'cobros');
			}
		} else {
			$vData['error'] = TRUE;
			$this->load->view("mobile/restore_view", $vData);
		}
	}

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author Gerson Rodriguez <nosreg216@gmail.com>
	 **/
	function changeAdminPassword()
	{
		$user = $this->session->log_user;

		$pass1 = $this->input->get('password1');
		$pass2 = $this->input->get('password2');

		if ($pass1 === $pass2 AND $pass1 != '1234') {
			$hash = password_hash($pass1, PASSWORD_DEFAULT);
			$data = array( 'usr_pwd' => $hash, 'pwd_temp' => 0 );

			$this->db->trans_start();
			$success = $this->User_model->update_User($user, $data);
			$this->db->trans_complete();

			if ($this->db->trans_status() === FALSE)
			{
				redirect(_App_.'/error');
			}		
			else
			{
				redirect(_App_);
			}
		} else {
			$vData['error'] = TRUE;
			$vData['title'] = "Cambiar contraseña";
			$this->load->view("static/header", $vData);
			$this->load->view("restore_view");
			$this->load->view("restore_view", $vData);
		}
	}

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author Gerson Rodriguez <nosreg216@gmail.com>
	 **/
	function restorePassword($userID)
	{
		$this->load->model('Colaborator_model');
		$hash = password_hash('1234', PASSWORD_DEFAULT);
		$data = array( 'usr_pwd' => $hash, 'pwd_temp' => 1 );

		$this->db->trans_start();
		$success = $this->User_model->update_User($userID, $data);
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE)
		{
			redirect(_App_.'colaboradores?ref=error');
		}		
		else
		{
			redirect(_App_.'colaboradores/'.$userID.'?modal=modal-reset');
		}
	}

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author Gerson Rodriguez <nosreg216@gmail.com>
	 **/
	function restoreAdminPassword()
	{
		$username = $this->input->post('name');
		if ($username == NULL) {
			redirect(_App_);
		}
		$this->db->trans_start();
		$userData = $this->User_model->get_dataByUsername($username);

		if ($userData) {
			$userID = $userData->usr_id;
			$email = $userData->usr_email;
			$temp = $this->generateRandomString(8);

			$hash = password_hash($temp, PASSWORD_DEFAULT);
			$data = array( 'usr_pwd' => $hash, 'pwd_temp' => 1);
			$success = $this->User_model->update_User($userID, $data);
			$this->db->trans_complete();

			if ($this->db->trans_status() === FALSE)
			{
				redirect(_App_.'usuarios?modal=modal-error');
			}		
			else
			{
				$this->send_email($email, $temp);
				redirect(_App_.'?modal=modal-reset-ok');
			}
		} else {
			redirect(_App_.'usuarios?modal=modal-error');
		}
	}

function generateRandomString($length = 8) {
	$characters = '1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$charactersLength = strlen($characters);
	$randomString = '';
	for ($i = 0; $i < $length; $i++) {
		$randomString .= $characters[rand(0, $charactersLength - 1)];
	}
	return $randomString;
}

public function send_email($email, $temp)
{
	$this->load->library('email');
	$msg="<p>Su solicitud de cambio de contraseña fue procesada correctamente.<p>";
	$msg=$msg."<p>Su nueva contraseña temporal es: $temp<p>";
	$this->email->from('registro@solucioneshym.co', 'Gestion de cuentas Credit 24/7');
	$this->email->to($email);
	$this->email->subject('Cambio de Clave | Solucioneshym.co');
	$this->email->message($msg);
	$this->email->send();
}
} // END class User