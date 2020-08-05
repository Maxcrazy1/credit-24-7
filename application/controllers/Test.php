<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Controlador de pruebas
 *
 * @package controllres
 * @author Gerson Rodriguez <nosreg216@gmail.com>
 **/
class Test extends CI_Controller
{

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author Gerson Rodriguez <nosreg216@gmail.com>
	 **/
	function testForm()
	{	
		$source = 'get';
		if (count($this->input->$source()) == 0) {
			$source = 'post';
		}

		$value = $this->input->$source('input');

		$data['value'] = $value;
		$this->load->view('test_view', $data);
	}

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author Gerson Rodriguez <nosreg216@gmail.com>
	 **/
	function index()
	{
		echo "<a href='/test/clientes'>Insertar clientes</a><br>";
		echo "<a href='/test/prestamos'>Insertar prestamos</a><br>";
		echo "<a href='/test/abonos'>Insertar abonos</a><br>";

		echo password_hash("adminHyM01", PASSWORD_DEFAULT);
	}

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author Gerson Rodriguez <nosreg216@gmail.com>
	 **/
	function clientes($count = 250)
	{
		while ($count > 0) {

			$this->load->model('Client_model');

			$name = ucfirst($this->generateRandomString(rand(5, 10)));
			$name = $name ." ". ucfirst($this->generateRandomString(rand(10, 15)));

			$data = array(
				'cli_nombre' => $name,
				'cli_telefono' => $this->generateRandomString(8, 'numero'),
				'cli_region' => rand(1, 7),
				'cli_direccion' => $this->generateRandomString(20),
				'cli_notas' => $this->generateRandomString(20),
				'cli_registro' => $this->generateRandomDate()
				);
			$client = $this->Client_model->add_client($data);
			$count = $count -1;
		}
		redirect(_App_."test");
	}

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author Gerson Rodriguez <nosreg216@gmail.com>
	 **/
	function prestamos()
	{
		$this->load->model('Client_model');
		$this->load->model('Loan_model');

		$clientList = $this->Client_model->get_clientList();
		foreach ($clientList as $client) {

			$monto = rand(2, 35) * 10000;
			$total = $this->calcTotalToPay($monto);
			$cuotas = $total / 10;
			$data = array(
				'prt_cliente' => $client->cli_id,
				'prt_fecha' => $this->generateRandomDate(),
				'prt_tipo' =>  $this->generateRandomString(1, 'tipo'),
				'prt_dia' =>  $this->generateRandomString(1, 'dia'),
				'prt_monto' => $monto,
				'prt_total' => $total,
				'prt_saldo' => $total,
				'prt_cuota' => $cuotas,
				'prt_notas' => "",
				'prt_autor' => rand(1,4)
				);
			$loan = $this->Loan_model->add_Loan($data);
		}
		redirect(_App_."test");
	}

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author Gerson Rodriguez <nosreg216@gmail.com>
	 **/
	function abonos()
	{
		$this->load->model('Payment_model');
		$this->load->model('Loan_model');

		$loanList = $this->Loan_model->getLoanListActive();

		foreach ($loanList as $loan) {

			if (rand(0,3) > 0) { # 75% de probabilidad
				#	Indica si el prestamo esta siendo liquidado
				$isComplete = false;
				#	Pedir los datos del prestamo
				$prestamo = $loan->prt_id;
				$cliente = $loan->prt_cliente;
				$saldo = $loan->prt_saldo;
				#	Pedir los datos del usuario
				$monto = $loan->prt_cuota * (rand(1,3)/2);
				$notas = "";
				#	Pedir el codigo del cobrador
				$cobrador = rand(1,10);
				#	Fecha y hora actual en formato standard
				$fecha  = $this->generateRandomDate();
				#	Quitar las comas de los numeros
				#	Restarle el monto del abono al saldo
				if ($monto >= $saldo) {
					$saldo = 0;
				} else {
					$saldo = $saldo - $monto;
				}
				#	Validar si el prestamo esta siendo liquidado
				$isComplete = ($saldo == 0);

				$prt_data = array(
					'prt_saldo' => $saldo,
					'prt_estado' => !$isComplete
					);

				$abn_data = array(
					'prt_id' => $prestamo,
					'cli_id' => $cliente,
					'abn_fecha' => $fecha,
					'abn_monto' => $monto,
					'abn_nota' => $notas,
					'abn_autor' => rand(1,4)
					);
				$this->Loan_model->update_loan($prestamo, $prt_data);
				$this->Payment_model->add_Payment($abn_data);
			}
		}
		redirect(_App_."test");
	}


	function generateRandomString($length = 10, $charset = 'nombre') {

		$characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		switch ($charset) {
			case 'nombre':
			$characters = 'abcdefghijklmnopqrstuvwxyz';
			break;
			case 'numero':
			$characters = '0123456789';
			break;
			case 'tipo' :
			$characters = 'DSQ';
			break;
			case 'dia' :
			$characters = 'LKMJVSD';
			break;
		}
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}


	/**
	 * Testing
	 *
	 * @return void
	 * @author Gerson Rodriguez <nosreg216@gmail.com>
	 **/
	function generateRandomDate()
	{
		$iDate = strtotime("2016-03-01");
		$fDate = time();
		$rDate = rand($iDate, $fDate);
		$date = date('Y-m-d h:i:s', $rDate);
		return $date;
	}

	function calcTotalToPay($monto)
	{
		#	calcular el n %, donde n son los intereses
		$intereses = 20;
		$extra = $monto * ($intereses / 100);
		return $monto + $extra;
	}

} // END class Test



