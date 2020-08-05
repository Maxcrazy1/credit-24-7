<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Controlador del perfil de los empleados.
 *
 * @package controllers
 * Carlos Carreño <cartur70@gmail.com>
 **/
class Expense extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Expense_model');
    }

    /**
     * Metodo principal. Muestra la lista de empleados activos.
     *
     * @return void
     * @author Carlos Carreño <cartur70@gmail.com>
     **/
    public function index()
    {
        $this->load->model('Region_model');
        if ($this->session->log_status == 'mobile') {
            $colab = $this->session->log_user;
            $this->db->trans_start();
            #    Pedir los contadores de objetos
            $day = date('N');
            switch ($day) {
                case 1:$day = 'L';
                    break;
                case 2:$day = 'K';
                    break;
                case 3:$day = 'M';
                    break;
                case 4:$day = 'J';
                    break;
                case 5:$day = 'V';
                    break;
                case 6:$day = 'S';
                    break;
                case 7:$day = 'D';
                    break;
            }

            $this->db->trans_start();

            $regionList = $this->Region_model->get_regionByColabDay($colab, $day);
            $expenseList = $this->Expense_model->get_expenseListTodayByColaborator($colab);

            $this->db->trans_complete();
            if ($this->db->trans_status() === false) {
                redirect(_App_ . '404_override');
            } else {
                $data = array(
                    'regionList' => $regionList,
                    'expenseList' => $expenseList,
                );
                /*Load the view files*/
                $data['title'] = "Inicio";
                $this->load->view("mobile/header");
                $this->load->view("mobile/sidebar");
                $this->load->view("mobile/expenses_view", $data);
                $this->load->view("mobile/footer");
            }
        } else {
            /*Load the login view file */
            $data['ref'] = $this->input->get('ref');
            $this->load->view('mobile/login_view', $data);
        }
    }

    /**
     * Metodo principal. Muestra la lista de empleados activos.
     *
     * @return void
     * @author Carlos Carreño <cartur70@gmail.com>
     **/
    public function addExpense()
    {
        $this->db->trans_start();
        #    Pedir la fecha de hoy
        $today = date('Y-m-d H:i:s');
        #    Pedir el nombre del usuario registrado
        $autor = $this->session->log_user;
        #    Pedir los datos del gasto
        $monto = $this->input->get('monto');
        $region = $this->input->get('region');
        $descripcion = $this->input->get('descripcion');
        #    Quitar las comas del monto
        $monto = str_replace(',', '', $monto);
        #    formar array de datos para insertar
        $data = array(
            'gas_autor' => $autor,
            'gas_region' => $region,
            'gas_descripcion' => $descripcion,
            'gas_monto' => $monto,
            'gas_fecha' => $today,
        );

        $this->Expense_model->add_expense($data);
        $this->db->trans_complete();

        if ($this->db->trans_status() === false) {
            redirect(_App_ . 'cobros/gastos?err');
        } else {
            redirect(_App_ . "cobros/gastos");
        }
    }

    public function removeExpense($expenseId, $colaboratorId = null)
    {
        $this->db->trans_start();
        $this->Expense_model->delete_expense($expenseId);
        $this->db->trans_complete();
        if ($this->session->log_status == 'mobile') {
            if ($this->db->trans_status() === false) {
                redirect(_App_ . 'cobros/gastos?err');
            } else {
                redirect(_App_ . "cobros/gastos");
            }
        } else {
            if ($this->db->trans_status() === false) {
                redirect(_App_ . 'colaboradores/$colaboratorId?err');
            } else {
                redirect(_App_ . "prestamos/");
            }
        }
    }
}
