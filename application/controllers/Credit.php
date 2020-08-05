<?php

defined('BASEPATH') or exit('No direct script access allowed');
/**
 *
 * @package controllers
 **/
class Credit extends CI_Controller
{

    public function __construct()
    {
		parent::__construct();
        $this->load->model('Loan_model');
        $this->load->model('Payment_model');
		$this->load->model('Client_model');
		$this->load->model('Region_model');
    }

    public function index()
    {
        $data['title'] = "Prestamos Activos";
        $this->load->view("static/header", $data);
        $this->load->view("mobile/sidebar");
        $this->load->view('query_pay', $data);
        $this->load->view('mobile/footer');

    }

    public function displayUserCreditInfo()
    {
        $documentId = $this->input->post('document-id');

        $dataClient = $this->Client_model->get_clientByDocumentId($documentId);
        if (!$dataClient) {
            redirect(_App_."404?".uri_string());
        }
        $regionList = $this->Region_model->get_regionList();

        $paymentList = $this->Payment_model->get_paymentListByClientID($dataClient->cli_id);
        $loans = $this->Loan_model->get_loanListByClient($dataClient->cli_id);

        $loanList = array();
        $loanHistory = array();

        if ($loans) {
            #    Luego clasificarlos en 2 arrays
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

            $data = array(
            'clientInfo' => $dataClient,
            'loanList' => $loanList,
            'loanHistory' => $loanHistory,
            'paymentList' => $paymentList,
		    'regionList' => $regionList
			);
			
        $data['title'] = $dataClient->cli_nombre;
        $this->load->view("static/header", $data);
        $this->load->view("static/sidebar");
        $this->load->view("mobile/client_view", $data);
        $this->load->view('static/footer');

    }
}