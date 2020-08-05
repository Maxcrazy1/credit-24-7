<?php

defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Maneja la creacion, consulta y modificacion de presatamos.
 * Tambien permite registrar abonos.
 *
 * @package controllers
 **/
class Loan extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Loan_model');
        $this->load->model('Client_model');
        $this->load->model('Region_model');
        $this->load->model('Payment_model');
        $this->load->helper('site');
    }

    /**
     * Muestra la lista de todos los creditos activos al dia de la consulta.
     *
     * @return void
     **/
    public function index()
    {
        $dataToView = $this->GetLoanActives();
        $dataToView['title'] = "Prestamos Activos";
        $this->load->view("static/header", $dataToView);
        $this->load->view("static/sidebar");
        $this->load->view('loanList_view', $dataToView);
        $this->load->view('static/footer');
    }

    /**
     * Muestra la lista de todos los creditos activos al dia de la consulta.
     *
     * @return void
     **/
    public function listDay()
    {
        #Lista de todos los colaboradores
        $loanList = $this->Loan_model->getLoanListActive();
        $clientList = $this->Client_model->get_clientList();
        $regionList = $this->Region_model->get_regionList();

        $data = array(
            'loanList' => $loanList,
            'clientList' => $clientList,
            'regionList' => $regionList,
        );

        $data['title'] = "Prestamos Activos";
        $this->load->view("static/header", $data);
        $this->load->view("static/sidebar");
        $this->load->view('loanListDay_view', $data);
        $this->load->view('static/footer');
    }

    /**
     * Muestra la lista de todos los pagos
     *
     * @return void
     **/
    public function reportPaymentRange($intervalo)
    {
        $paymentList = null;
        $fecha_Inicial = null;
        $fecha_Final = null;
        switch ($intervalo) {
            case 'rango':
                $fecha_Inicial = date('Y-m-d 00:00:00', strtotime($this->input->post('fecha_Inicial')));
                $fecha_Final = date('Y-m-d 23:59:59', strtotime($this->input->post('fecha_Final')));
                break;

            case 'hoy':
                $fecha_Inicial = date('Y-m-d 00:00:00', time());
                $fecha_Final = date('Y-m-d H:i:s', time());
                break;

            case 'semana':
                $fecha_Inicial = date('Y-m-d 23:59:59', strtotime("last Sunday"));
                $fecha_Final = date('Y-m-d H:i:s', time());
                break;

            case 'mes':
                $fecha_Inicial = date('Y-m-1 00:00:01', time());
                $fecha_Final = date("Y-m-d H:i:s", time());
                break;

            default:
                $paymentList = $this->Payment_model->get_paymentList();
                $sumaAbono = $this->Payment_model->get_revenueRange($this->input->post('fecha_Inicial'), $this->input->post('fecha_Final'));
                break;
        }

        $paymentList = $this->Payment_model->get_paymentListRange($fecha_Inicial, $fecha_Final);
        $sumaAbono = $this->Payment_model->get_revenueRange($fecha_Inicial, $fecha_Final);

        $data = array(
            'paymentList' => $paymentList,
            'intervalo' => $intervalo,
            'fecha_1' => date("d-m-Y", strtotime($fecha_Inicial)),
            'fecha_2' => date("d-m-Y", strtotime($fecha_Final)),
            'sumaAbono' => $sumaAbono,
        );

        $data['title'] = "Abonos por fecha";
        $this->load->view("static/header", $data);
        $this->load->view("static/sidebar");
        $this->load->view('paymentRangeList_view', $data);
        $this->load->view('static/footer');
    }

    /**
     *
     * @return void
     **/
    public function reportLoanRange()
    {
        $startDate = $this->input->post('fecha_Inicial');
        $endDate = $this->input->post('fecha_Final');

        if ($startDate == null or $endDate == null) {
            $fecha_Inicial = date('Y-m-d 00:00:00', time());
            $fecha_Final = date('Y-m-d 23:59:59', time());
        } else {
            $fecha_Inicial = date('Y-m-d 00:00:00', strtotime($startDate));
            $fecha_Final = date('Y-m-d 23:59:59', strtotime($endDate));
        }

        $loanList = $this->Loan_model->get_loanListRange($fecha_Inicial, $fecha_Final);
        $sumaReport = $this->Payment_model->GetRevenueRegionRangePrestamo($fecha_Inicial, $fecha_Final);

        $data = array(
            'loanList' => $loanList,
            'fecha_1' => date("d-m-Y", strtotime($fecha_Inicial)),
            'fecha_2' => date("d-m-Y", strtotime($fecha_Final)),
            'sumaReport' => $sumaReport,
        );
        $data['title'] = "Préstamos por fecha";

        $this->load->view("static/header", $data);
        $this->load->view("static/sidebar");
        $this->load->view('loanRangeList_view', $data);
        $this->load->view('static/footer');
    }

    /**
     * Muestra los informes en un rango de fechas y regiones.
     *
     * @return void
     * @author Carlos Carreño <cartur70@gmail.com>
     **/
    public function reportLoanRangeRegion()
    {
        $action = $this->input->post('tipo');
        $region = $this->input->post('region');
        $startDate = $this->input->post('fecha_inicial');
        $endDate = $this->input->post('fecha_final');

        if ($startDate == null or $endDate == null) {
            $fecha_inicial = date('Y-m-d 00:00:00', time());
            $fecha_final = date('Y-m-d 23:59:59', time());
        } else {
            $fecha_inicial = date('Y-m-d 00:00:00', strtotime($startDate));
            $fecha_final = date('Y-m-d 23:59:59', strtotime($endDate));
        }

        switch ($action) {
            case "0":
                $data = $this->GetLoanActives($region, ['startDate' => $fecha_inicial, 'endDate' => $fecha_final]);
                $data['title'] = "Prestamos Activos";
                $data['regionList'] = $this->Region_model->get_regionList();
                $data['id_region'] = $region;
                $data['fecha_inicial'] = date("Y-m-d", strtotime($fecha_inicial));
                $data['fecha_final'] = date("Y-m-d", strtotime($fecha_final));
                break;
            case "1":
                $this->load->model('Expense_model');
                $this->db->trans_start();
                $regionList = $this->Region_model->get_regionList();
                $expenseList = $this->Expense_model->get_expensesListRangeByRegion($region, $fecha_inicial, $fecha_final);
                $sumaReport = $this->formatAmount($this->Expense_model->get_totalExpensesListRangeByRegion($region, $fecha_inicial, $fecha_final));
                $this->db->trans_complete();
                if ($this->db->trans_status() === false) {
                    redirect(_App_ . '404_override');
                } else {
                    $data = array(
                        'sumaReport' => $sumaReport,
                        'id_region' => $region,
                        'regionList' => $regionList,
                        'expenseList' => $expenseList,
                        'fecha_inicial' => date("Y-m-d", strtotime($fecha_inicial)),
                        'fecha_final' => date("Y-m-d", strtotime($fecha_final)),
                        'informe' => $action,
                    );
                    $data['title'] = "Gastos por fecha y Región";
                }
                break;
            case "2":
                $this->db->trans_start();
                $regionList = $this->Region_model->get_regionList();
                $newLoanList = $this->Loan_model->get_newLoanListRangeByRegion($region, $fecha_inicial, $fecha_final);
                $sumaReport = $this->Payment_model->GetRevenueRegionRangePrestamo($fecha_inicial, $fecha_final, $region);
                $sumaReport = $this->formatAmount($sumaReport[0]->prt_monto);
                $this->db->trans_complete();
                if ($this->db->trans_status() === false) {
                    redirect(_App_ . '404_override');
                } else {
                    $data = array(
                        'sumaReport' => $sumaReport,
                        'id_region' => $region,
                        'regionList' => $regionList,
                        'newLoanList' => $newLoanList,
                        'fecha_inicial' => date("Y-m-d", strtotime($fecha_inicial)),
                        'fecha_final' => date("Y-m-d", strtotime($fecha_final)),
                        'informe' => $action,
                    );
                    $data['title'] = "Préstamos Nuevos Por Fecha y Región";
                }
                break;
            case "3":
                $this->db->trans_start();
                $regionList = $this->Region_model->get_regionList();
                $paymentList = $this->Payment_model->get_paymentListRangeByRegion($region, $fecha_inicial, $fecha_final);
                $sumaAbono = $this->Payment_model->get_totalPaymentListRangeByRegion($region, $fecha_inicial, $fecha_final);
                $sumaAbono = $this->formatAmount($sumaAbono);
                $this->db->trans_complete();
                if ($this->db->trans_status() === false) {
                    redirect(_App_ . '404_override');
                } else {
                    $data = array(
                        'sumaAbono' => $sumaAbono,
                        'id_region' => $region,
                        'regionList' => $regionList,
                        'paymentList' => $paymentList,
                        'fecha_inicial' => date("Y-m-d", strtotime($fecha_inicial)),
                        'fecha_final' => date("Y-m-d", strtotime($fecha_final)),
                        'informe' => $action,
                    );
                    $data['title'] = "Abonos Realizados Por Fecha y Región";
                }
                break;
            case "4":
                $data = $this->GetTotals($region, $fecha_inicial, $fecha_final);
                $data['total'] = $this->formatAmount($this->removeDecimals($data['totalPayments']) -
                    ($this->removeDecimals($data['totalExpense']) + $this->removeDecimals($data['totalnewLoan'])));

                $data['title'] = "Ingresos Netos Por Fecha y Región";
                $data['informe'] = $action;
                break;
            case "5":
                $data = $this->GetTotals($region, $fecha_inicial, $fecha_final);
                $data['expensesList'] = $this->Expense_model->get_expensesListRangeByRegion($region, $fecha_inicial, $fecha_final);
                $data['title'] = "Ganacias por Fecha y Región";
                $data['informe'] = $action;
                break;

        }

        $this->load->view("static/header", $data);
        $this->load->view("static/sidebar");
        $this->load->view('loanList_view', $data);
        $this->load->view('static/footer');

    }

    private function getTotalWinningsByRange($data)
    {
        $loans = $this->Loan_model->get_allLoanRangeByRegion($data['region'], $data['startDate'], $data['endDate']);
        $totalWinnings=0;
        if ($loans) {
            foreach ($loans as $loan) {
                $interes = is_null($loan->prt_rate_interes) ?
                $this->setInteresRate() : $loan->prt_rate_interes;
                $totalWinnings += $loan->totalCredited-($loan->totalCredited/floatval('1.'.$interes));
            }
        }

        return $totalWinnings;

    }

    private function removeDecimals($amount)
    {
        return filter_var($amount, FILTER_SANITIZE_NUMBER_INT);
    }

    private function GetTotals($region, $fecha_inicial, $fecha_final)
    {
        $this->load->model('Expense_model');
        $sumaReport = $this->Payment_model->GetRevenueRegionRangePrestamo($fecha_inicial, $fecha_final, $region);
        $sumaReport = $this->formatAmount($sumaReport[0]->prt_monto);
        $total1= $this->Expense_model->get_totalExpensesListRangeByRegion($region, $fecha_inicial, $fecha_final);
        $total2= $this->getTotalWinningsByRange(array('region' => $region, 'startDate' => $fecha_inicial, 'endDate' => $fecha_final));
        $totalNet= $this->getTotalWinningsByRange(array('region' => $region, 'startDate' => $fecha_inicial, 'endDate' => $fecha_final)) -
         $this->Expense_model->get_totalExpensesListRangeByRegion($region, $fecha_inicial, $fecha_final);

       $data = array(
            'id_region' => $region,
            'regionList' => $this->Region_model->get_regionList(),
            'totalPayments' => $this->formatAmount($this->Payment_model->get_totalPaymentListRangeByRegion($region, $fecha_inicial, $fecha_final)),
            'totalnewLoan' => $sumaReport,
            'totalExpense' => $this->formatAmount($this->Expense_model->get_totalExpensesListRangeByRegion($region, $fecha_inicial, $fecha_final)),
            'total' => $this->formatAmount($totalNet),
        );
        return $data;
    }

    private function formatAmount($amount)
    {
        $formatNumber = new NumberFormatter("en", NumberFormatter::DECIMAL);
        return $formatNumber->format($amount);

    }

    private function GetLoanActives($region = 0, $dates = [])
    {
        if (!key_exists('startDate', $dates) && !key_exists('endDate', $dates)) {
            $dates['startDate'] = date("Y-m-1");
            $dates['endDate'] = date("Y-m-d");
        }

        $sumaReport = $this->Loan_model->getTotalsLoan($region, $dates['startDate'], $dates['endDate']);
        $sumaReport = $this->formatAmount($sumaReport);

        return array(
            'loanList' => $this->Loan_model->getLoanListActive($region, $dates['startDate'], $dates['endDate']),
            'clientList' => $this->Client_model->get_clientList(),
            'sumaReport' => $sumaReport,
            'id_region' => 0,
            'informe' => 0,
        );

    }

    /**
     * Informacion del prestamo para el cliente movil
     *
     * @return void
     **/
    public function mobile_index($loanId)
    {

        $loanId = has_symbols($loanId) ? $loanId = decrypt($loanId) : $loanId;

        $loanInfo = $this->Loan_model->get_loanByID($loanId);
        $lastPayment = $this->Payment_model->get_lastPayment($loanId);
        $paymentList = $this->Payment_model->get_paymentListByLoanID($loanId);
        $dataClient = $this->Client_model->get_clientByID($loanInfo->prt_cliente);

        if ($paymentList) {
            $x = 0;
            foreach ($paymentList as $row) {
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
            'loanInfo' => $loanInfo,
            'dataClient' => $dataClient,
            'lastPayment' => $lastPayment,
            'paymentList' => $paymentList,
            'hoy' => $this->GetLetterToday(),
        );

        $data['title'] = 'Detalle del prestamo';
        $this->load->view("mobile/header", $data);
        $this->load->view("mobile/sidebar");
        $this->load->view('mobile/loan_view', $data);
        $this->load->view('mobile/footer');
    }

    /**
     * Muestra los detalles de un prestamo y permite editarlo.
     *
     * @return void
     * @author Carlos Carreño <cartur70@gmail.com>
     **/
    public function displayLoanInfo($loanId)
    {
        $this->load->model('Colaborator_model');
        $this->load->model('User_model');
        $this->db->trans_start();

        $loanInfo = $this->Loan_model->get_loanByID($loanId);
        $loanInfo->prt_rate_interes =  is_null($loanInfo->prt_rate_interes) || $loanInfo->prt_rate_interes==0?
        $this->setInteresRate() : $loanInfo->prt_rate_interes;

        $clientList = $this->Client_model->get_clientList();
        $clientInfo = $this->Client_model->get_clientByID($loanInfo->prt_cliente);
        $paymentList = $this->Payment_model->get_paymentListByLoanID($loanId);
        $colaborador = $this->Colaborator_model->get_colaboratorByID($loanInfo->prt_autor);
        $colaboratorList = $this->Colaborator_model->get_colaboratorList();
        $userList = $this->User_model->get_allUsersWithoutColaborators();

        if ($colaborador) {
            $loanInfo->clb_nombre = $colaborador->clb_nombre;
            $loanInfo->clb_id = $colaborador->clb_id;
        } else {
            $colaborador = $this->User_model->get_userByID($loanInfo->prt_autor);
            $loanInfo->clb_nombre = $colaborador->usr_name;
            $loanInfo->clb_id = $colaborador->usr_id;
        }

        if ($paymentList) {
            $x = 0;
            foreach ($paymentList as $row) {
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
            'clientList' => $clientList,
            'loanInfo' => $loanInfo,
            'clientInfo' => $clientInfo,
            'paymentList' => $paymentList,
            'colaboratorList' => $colaboratorList,
            'userList' => $userList,
        );

        $data['title'] = "Préstamo #" . $loanInfo->prt_id;
        $this->load->view('static/header', $data);
        $this->load->view('static/sidebar');
        $this->load->view('loan_view', $data);
        $this->load->view('static/footer');
    }

    /**
     * undocumented function
     *
     * @return void
     **/
    public function removeLoan()
    {
        $this->db->trans_start();
        $this->Loan_model->delete_loan($this->input->post('prestamo'));
        $this->db->trans_complete();

        if ($this->db->trans_status() === false) {
            redirect(_App_ . 'prestamos?err');
        } else {
            redirect(_App_ . "prestamos");
        }
    }

    /**
     *
     * @return void
     **/
    public function addLoan()
    {
        $this->load->model('Application_model');
        $this->db->trans_start();

        $interesRate = $this->setInteresRate($this->input->get('interes'));
        $monto = str_replace(',', '', $this->input->get('monto'));
        $mobile = $this->input->get('mobile');

        $data = array(
            'prt_cliente' => $this->input->get('cliente'),
            'prt_fecha' => unix_to_human(time(), true, 'eu'),
            'prt_tipo' => $this->input->get('tipo'),
            'prt_dia' => $this->GetLetterLoan($this->input->get('tipo')),
            'prt_monto' => $monto,
            'prt_total' => $this->calcTotalToPay($monto, $interesRate),
            'prt_saldo' => $this->calcTotalToPay($monto, $interesRate),
            'prt_rate_interes' => $interesRate,
            'prt_cuota' => str_replace(',', '', $this->input->get('cuotas')),
            'prt_notas' => $this->input->get('notas'),
            'prt_autor' => $this->session->log_user,
        );

        $loan = $this->Loan_model->add_Loan($data);
        $this->db->trans_complete();

        // Código apestoso que se debe reemplazar
        if ($this->db->trans_status() === false) {
            redirect(_App_ . 'prestamos?err');
        } else {
            if ($mobile !== null) {
                redirect(_App_ . "cobros/prestamos/$loan");
            } else {
                redirect(_App_ . "prestamos/$loan");
            }
        }
    }

    private function GetLetterToday()
    {
        switch (date("l")) {
            case "Sunday":
                return "D";
                break;
            case "Monday":
                return "L";
                break;
            case "Tuesday":
                return "K";
                break;
            case "Wednesday":
                return "M";
                break;
            case "Thursday":
                return "J";
                break;
            case "Friday":
                return "V";
                break;
            case "Saturday":
                return "S";
                break;
        }
    }

    public function GetLetterLoan($tipo)
    {
        return $tipo == 'S' ? $this->GetLetterToday() : '1';
    }

    /**
     * Calcula el nuevo monto, actualiza el saldo y el total
     * Tambien actualiza los pagos diario, semanal y quincenal
     *
     * @return void
     **/
    public function updateMonto()
    {

        $monto = $this->input->post('monto');
        $interesRate = $this->setInteresRate($this->input->post('interes'));
        $loanID = $this->input->post('prestamoID');
        $tipo = $this->input->post('tipo');
        $dia = null;

        #    Verifica el tipo de prestamo
        switch ($tipo) {
            case 'D':
                $dia = 1;
                break;

            case 'S':
                $dia = $this->input->post('dia');
                break;

            case 'Q':
                $dia = 1;
                break;

            default:
                $dia = $this->input->post('dia');
                break;
        }

        #    Quitar las comas de los numeros
        $monto = str_replace(',', '', $monto);

        #    Pedir el valor de los intereses
        #    Pedir el valor del monto abonado
        $abn_monto = $this->Payment_model->get_abnMonto($loanID);

        #    Calcular el monto total con los intereses
        $total = $this->calcTotalToPay($monto, $interesRate);

        #Calcular el nuevo saldo con el total actualizado
        $nuevoSaldo = $total - $abn_monto;

        $data = array(
            'prt_tipo' => $tipo,
            'prt_dia' => $dia,
            'prt_monto' => $monto,
            'prt_total' => $total,
            'prt_saldo' => $nuevoSaldo,
            'prt_rate_interes' => $interesRate,
        );

        $this->db->trans_start();
        $loan = $this->Loan_model->update_loan($loanID, $data);
        $this->db->trans_complete();

        if ($this->db->trans_status() === false) {
            redirect(_App_ . 'prestamos?err');
        } else {
            redirect(_App_ . "prestamos/$loan");
        }
    }

    private function setInteresRate($inputInteresRate = null)
    {
        $this->load->model('Application_model');
        return $inputInteresRate == '0' || is_null($inputInteresRate) ?
        $this->Application_model->get_interest()->app_intereses :
        $inputInteresRate;

    }

    /**
     *
     * @return Integer
     **/
    public function calcTotalToPay($monto, $intereses)
    {
        return $monto + ($monto * ($intereses / 100));
    }

    /**
     *
     * @return void
     **/
    public function confirmPayment()
    {
        #    Asignar el colaborador
        $data['colaborador'] = $this->session->log_user;

        #    Pedir los datos del prestamo
        $data['prestamo'] = $this->input->get('prestamo');
        $data['cliente'] = $this->input->get('cliente');
        $data['saldo'] = $this->input->get('saldo');

        #    Pedir los datos del usuario
        $data['monto'] = $this->input->get('monto');
        $data['notas'] = $this->input->get('notas');
        $data['autor'] = $this->input->get('notas');

        $this->load->view('mobile/header');
        $this->load->view('mobile/payment_view', $data);
        $this->load->view('mobile/footer');
    }

    private function setRedirectByActiveLoan($idCliente)
    {
        if (count($this->Loan_model->get_activeLoanListByClient($idCliente)) > 1) {
            return $this->session->log_role == "C" ? 'cobros/clientes/' . $idCliente : 'clientes/' . $idCliente;
        } else {
            return $this->session->log_role == "C" ? 'cobros/clientes/' : 'clientes/';
        }
    }

    private function setDatePaymentLoan()
    {
        return !isset($_GET['fechahora']) ?
        unix_to_human(time(), true, 'eu') :
        $this->input->get('fechahora');

    }

    private function substractAmountFromBalance($amount, $balance)
    {
        return $amount >= $balance ?
        $balance = 0 :
        $balance - $amount;
    }

    private function setStatusPayment($amount, $fee)
    {
        if ($amount >= $fee) {
            return 2;
        } elseif (($amount < $fee) && ($amount > 0)) {
            return 1;
        } else {
            return 0;
        }
    }

    private function updateLoanBalance()
    {
        $prestamo = $this->input->get('prestamo');
        $monto = $this->input->get('monto');
        $saldo = $this->substractAmountFromBalance($this->removeDecimals($monto),
            $this->input->get('saldo'));

        $loanData = array(
            'prt_saldo' => $saldo,
            'prt_estado' => ($saldo != 0),
            'prt_ultimoPago' => date('Y-m-d', time()),
        );

        $this->Loan_model->update_loan($prestamo, $loanData);
    }

    public function storePayLoan()
    {
        $this->load->model('Loan_Model');

        $prestamo = $this->input->get('prestamo');
        $cliente = $this->input->get('cliente');
        $monto = $this->removeDecimals($this->input->get('monto'));
        $user = isset($_GET['colaborador']) && $this->input->get('colaborador') != '-1' ?
        $this->input->get('colaborador') :
        $this->session->log_user;

        $redirection = $this->setRedirectByActiveLoan($cliente);

        $paymentData = array(
            'prt_id' => $prestamo,
            'cli_id' => $cliente,
            'abn_monto' => $monto,
            'abn_autor' => $user,
            'abn_fecha' => $this->setDatePaymentLoan(),
            'abn_nota' => $this->input->get('notas'),
            'abn_status' => $this->setStatusPayment($monto, $this->Loan_model->get_paymentCuota($prestamo)),
            'abn_contable' => !isset($_GET['contable']) ? 1 : 0,
        );

        $this->db->trans_start();
        $this->Payment_model->add_Payment($paymentData);
        $this->updateLoanBalance();
        $this->db->trans_complete();

        $this->redirectionWithoutName($redirection);

    }

    private function redirectionWithoutName($redirection)
    {
        if ($this->db->trans_status() === false) {
            redirect(_App_ . $redirection);
        } else {
            if ((isset($_GET['contable'])) and ($this->session->log_role == 'M')) {
                $this->load->model('Client_model');
                $this->load->model('User_model');
                // $clientInfo = $this->Client_model->get_clientByID($cliente);
                // $userInfo = $this->User_model->get_userByID($user);

                // $mensaje = 'Se ha modificado el siguiente registro: <br><br>';
                // $mensaje = $mensaje . '<table border="1"><caption>Detalle del item</caption><tr><th>Id Préstamo</th><th>Id Cliente</th>
                // <th>Fecha</th><th>Monto</th><th>Nota</th><th>Autor</th><th>Estatus</th><tr><td>' . $prestamo . '</td><td>' . $clientInfo->cli_nombre . '</td>
                // <td>' . $fecha . '</td><td>' . $monto . '</td><td>' . $notas . '</td><td>' . $userInfo->usr_name . '</td><td>' . $status . '</td></tr></table>';

            }
            redirect(_App_ . $redirection . "?modal=modal-success");
        }
    }
    /**
     * Procesa un abono a un prestamo
     *
     * @return void
     * @author Gerson Rodriguez <nosreg216@gmail.com>
     **/
    public function payBlackList()
    {
        #$this->output->enable_profiler(TRUE);
        $this->load->model('Payment_model');

        #    Pedir los datos del prestamo
        $prestamo = $this->input->get('prestamo');
        $cliente = $this->input->get('cliente');
        $saldo = $this->input->get('saldo');

        #    Pedir los datos del usuario
        $monto = $this->input->get('monto');
        $notas = $this->input->get('notas');

        #    Pedir el codigo del cobrador
        $user = $this->session->log_user;

        #    A donde redireccionar al terminar
        $rdr = $this->input->get('rdr');

        #    Fecha y hora actual en formato standard
        $fecha = strtotime(date('Y-m-d H:i:s', time()) . ' -2 year');
        $fecha_abono = date('Y-m-d H:i:s', $fecha);

        #    Quitar las comas de los numeros
        $monto = str_replace(',', '', $monto);

        #    Validar si el prestamo esta siendo liquidado
        $isComplete = ($saldo != 0);

        $prt_data = array(
            'prt_saldo' => $saldo,
            'prt_estado' => $isComplete,
            'prt_ultimoPago' => $fecha_abono,
        );

        $abn_data = array(
            'prt_id' => $prestamo,
            'cli_id' => $cliente,
            'abn_fecha' => $fecha_abono,
            'abn_monto' => $monto,
            'abn_nota' => $notas,
            'abn_autor' => $user,
        );
        $this->Loan_model->update_loan($prestamo, $prt_data);
        $this->Payment_model->add_Payment($abn_data);

        if ($this->db->trans_status() === false) {
            redirect(_App_ . $rdr . "prestamos/$prestamo?modal=modal-error");
        } else {
            redirect(_App_ . $rdr . "prestamos/$prestamo?modal=modal-success");
        }
    }

    public function substractAmount($monto, $saldo)
    {
        if ($monto >= $saldo) {
            $saldo = 0;
        } else {
            return $saldo - $monto;
        }
    }
    /**
     *
     * @return void
     **/
    public function confirmRepayLoan($payment_id)
    {
        $data['title'] = "Reembolsar abono";
        $data['abono'] = $payment_id;

        $this->load->view("static/header", $data);
        $this->load->view("static/sidebar");
        $this->load->view("repayLoan_view", $data);
        $this->load->view("static/footer");
    }

    /**
     * Actualiza un abono.
     *
     * @return void
     **/
    public function updatePayment($payment_id)
    {
        #$this->output->enable_profiler(TRUE);
        $this->load->model('Payment_model');

        #    Indica si el prestamo esta siendo liquidado
        $isComplete = false;

        #    Pedir los datos del prestamo
        $prestamo = $this->input->post('prestamo');
        $saldo = $this->input->post('saldo');
        $monto_pagado = $this->input->post('monto_pagado');

        #    Pedir los datos del usuario
        $monto = $this->input->post('monto');
        $fecha = $this->input->post('fecha');
        $nota = $this->input->post('nota');
        $autor = $this->input->post('colaborador');
        $contable = $this->input->post('contable');

        #    A donde redireccionar al terminar
        $rdr = $this->input->get('rdr');

        #    Quitar las comas de los numeros
        $monto = str_replace(',', '', $monto);
        $monto_pagado = str_replace(',', '', $monto_pagado);

        #    Devolver el monto anterior ya realizado
        $saldo1 = $saldo + $monto_pagado;

        #    Restarle el monto del abono al saldo
        if ($monto >= $saldo) {
            $saldo = 0;
        } else {
            $saldo = $saldo1 - $monto;
        }

        #    Validar si el prestamo esta siendo liquidado
        $isComplete = ($saldo == 0);

        #   Establecer el status del pago
        $cuota = $this->Loan_model->get_paymentCuota($prestamo);
        if ($monto >= $cuota) {
            $status = 2;
        } else {
            if (($monto < $cuota) && ($monto > 0)) {
                $status = 1;
            } else {
                $status = 0;
            }
        }

        $prt_data = array(
            'prt_saldo' => $saldo,
            'prt_estado' => !$isComplete,
        );

        $abn_data = array(
            'abn_fecha' => $fecha,
            'abn_monto' => $monto,
            'abn_nota' => $nota,
            'abn_autor' => $autor,
            'abn_status' => $status,
            'abn_contable' => $contable,
        );
        $this->db->trans_start();
        $this->Loan_model->update_loan($prestamo, $prt_data);
        $this->Loan_model->update_payment($payment_id, $abn_data);
        $this->db->trans_complete();

        if ($this->db->trans_status() === false) {
            redirect(_App_ . '404_override');
        } else {
            // if ($this->session->log_role == 'M') {
            // $this->load->model('Client_model');
            // $this->load->model('User_model');
            // $clientInfo = $this->Client_model->get_clientByID($cliente);
            // $userInfo = $this->User_model->get_userByID($user);
            // $mailConfig['mailpath'] = '/usr/sbin/sendmail';
            // // Detalles del protocolo
            // $mailConfig['protocol'] = 'sendmail';
            // $mailConfig['smtp_host'] = 'relay-hosting.secureserver.net';
            // $mailConfig['smtp_user'] = 'master@solucioneshym.co';
            // $mailConfig['smtp_pass'] = '*0master0*';
            // $mailConfig['smtp_port'] = '25';
            // $mailConfig['mailtype'] = 'html';

            // $this->load->library('email', $mailConfig);

            // //Correo que enviará el email y un nombre
            // $this->email->from('master@solucioneshym.co', 'Usuario Master');

            // //Destinatarios para los que va el email
            // $this->email->to('camilobeltranleon@gmail.com, master@solucioneshym.co');

            // //Asunto del mensaje
            // $this->email->subject("Modificación Manual de Pago");

            // //Mensaje a enviar
            // $mensaje = 'Se ha modificado el siguiente registro: <br><br>';
            // $mensaje = $mensaje . '<table border="1"><caption>Detalle del item</caption><tr><th>Id Préstamo</th><th>Id Cliente</th>
            // <th>Fecha</th><th>Monto</th><th>Nota</th><th>Autor</th><th>Estatus</th><tr><td>' . $prestamo . '</td><td>' . $clientInfo->cli_nombre . '</td>
            // <td>' . $fecha . '</td><td>' . $monto . '</td><td>' . $notas . '</td><td>' . $userInfo->usr_name . '</td><td>' . $status . '</td></tr></table>';

            // $this->email->message($mensaje);

            // //Envio del email
            // if ($this->email->send()) {
            //     $this->session->set_flashdata('envio', 'Email enviado correctamente');
            // } else {
            //     $this->session->set_flashdata('envio', 'No se a enviado el email');
            // }
            // }
            redirect(_App_ . $rdr . "prestamos/$prestamo?modal=modal-success");
        }
    }

    /**
     * Actualiza la info de un préstamo.
     *
     * @return void
     * @author Carlos Carreño <cartur70@gmail.com>
     **/
    public function updateInfoLoan($loan_id)
    {
        #    Pedir los datos del prestamo
        $cliente = $this->input->post('cliente');
        $autor = $this->input->post('colaborador');
        $fecha = $this->input->post('fecha');
        $notas = $this->input->post('notas');

        #    A donde redireccionar al terminar
        $rdr = $this->input->get('rdr');

        $prt_data = array(
            'prt_cliente' => $cliente,
            'prt_autor' => $autor,
            'prt_fecha' => $fecha,
            'prt_notas' => $notas,
        );

        $this->db->trans_start();
        $this->Loan_model->update_loan($loan_id, $prt_data);
        $this->db->trans_complete();

        if ($this->db->trans_status() === false) {
            redirect(_App_ . '404_override');
        } else {
            redirect(_App_ . $rdr . "prestamos/$loan_id?modal=modal-success");
            // $this->load->model('Client_model');
            // $this->load->model('User_model');
            // $clientInfo = $this->Client_model->get_clientByID($cliente);
            // $userInfo = $this->User_model->get_userByID($autor);
            // $mailConfig['mailpath'] = '/usr/sbin/sendmail';
            // // Detalles del protocolo
            // $mailConfig['protocol'] = 'sendmail';
            // $mailConfig['smtp_host'] = 'relay-hosting.secureserver.net';
            // $mailConfig['smtp_user'] = 'master@solucioneshym.co';
            // $mailConfig['smtp_pass'] = '*0master0*';
            // $mailConfig['smtp_port'] = '25';
            // $mailConfig['mailtype'] = 'html';

            // $this->load->library('email', $mailConfig);

            // //Correo que enviará el email y un nombre
            // $this->email->from('master@solucioneshym.co', 'Usuario Master');

            // //Destinatarios para los que va el email
            // $this->email->to('camilobeltranleon@gmail.com, master@solucioneshym.co');

            // //Asunto del mensaje
            // $this->email->subject("Modificación Manual de la información de Préstamo");

            // //Mensaje a enviar
            // $mensaje = 'Se ha modificado el siguiente registro: <br><br>';
            // $mensaje = $mensaje . '<table border="1"><caption>Detalle del item</caption><tr><th>Id Préstamo</th>
            // <th>Id Cliente</th><th>Fecha</th><th>Nota</th><th>Autor</th><tr><td>' . $loan_id . '</td>
            // <td>' . $clientInfo->cli_nombre . '</td><td>' . $fecha . '</td><td>' . $notas . '</td><td>' . $userInfo->usr_name . '</td>
            // </tr></table>';

            // $this->email->message($mensaje);

            // //Envio del email
            // if ($this->email->send()) {
            //     $this->session->set_flashdata('envio', 'Email enviado correctamente');
            // } else {
            //     $this->session->set_flashdata('envio', 'No se a enviado el email');
            // }
        }
    }

    /**
     * Procesa un abono a un prestamo
     *
     * @return void
     * @author Gerson Rodriguez <nosreg216@gmail.com>
     **/
    public function repayLoan($payment_id)
    {
        //$this->output->enable_profiler(TRUE);
        $this->load->model('Payment_model');

        $this->db->trans_start();
        #    Buscar la info del pago y el prestamo
        $payment = $this->Payment_model->get_paymentByID($payment_id);
        $prestamo = $this->Loan_model->get_loanByID($payment->prt_id);

        #    New Saldo
        $saldo = $prestamo->prt_saldo + $payment->abn_monto;

        $rdr = $this->input->get('rdr');

        #    Indica si el prestamo esta liquidado
        $isComplete = ($saldo > 0) ? false : true;

        $prt_data = array(
            'prt_saldo' => $saldo,
            'prt_estado' => !$isComplete,
        );

        #    Actualizar el prestamo
        $this->Loan_model->update_loan($prestamo->prt_id, $prt_data);
        #    Borrar el pago
        $this->Payment_model->delete_payment($payment_id);
        $this->db->trans_complete();

        $pid = $prestamo->prt_id;
        if ($this->db->trans_status() === false) {
            redirect(_App_ . $rdr . "prestamos/$pid?modal=modal-error");
        } else {
            redirect(_App_ . $rdr . "prestamos/$pid?modal=modal-success");
        }
    }

    /**
     * undocumented function
     *
     * @return void
     * @author Gerson Rodriguez <nosreg216@gmail.com>
     **/
    public function confirmLoan()
    {
        #$this->output->enable_profiler(TRUE);

        $data['cliente'] = $this->input->get('cliente');

        #    Pedir los datos del prestamo viejo (Abono)
        $data['prestamo'] = $this->input->get('o_prestamo');
        $data['saldo'] = $this->input->get('o_saldo');

        #    Pedir los datos del prestamo nuevo (Creacion)
        $data['monto'] = $this->input->get('n_monto');
        $data['cuotas'] = $this->input->get('n_cuotas');
        $data['notas'] = $this->input->get('n_notas');
        $data['tipo'] = $this->input->get('n_tipo');
        $data['dia'] = $this->input->get('n_dia');

        $this->load->view('mobile/header');
        $this->load->view('mobile/renew_view', $data);
        $this->load->view('mobile/footer');
    }

    /**
     *
     * @return void
     **/
    public function renewLoan()
    {
        // $this->output->enable_profiler(TRUE);
        $this->load->model('Payment_model');
        $this->load->model('Application_model');

        #    Pedir los datos del Cliente
        $cliente = $this->input->get('cliente');
        #    Pedir los datos del prestamo viejo (Abono)
        $prestamo = $this->input->get('prestamo');
        $saldo = $this->input->get('saldo');
        $oNotas = "liquidado por renovación";
        #    Pedir los datos del prestamo nuevo (Creacion)
        $monto = $this->input->get('monto');
        $cuotas = $this->input->get('cuotas');
        $nNotas = $this->input->get('notas');
        $tipo = $this->input->get('tipo');
        $dia = $this->input->get('dia');
        #    Pedir el codigo del cobrador
        $user = $this->session->log_user;
        #    Fecha y hora actual en formato standard
        $fecha = unix_to_human(time(), true, 'eu');

        $prt_data = array('prt_saldo' => 0, 'prt_estado' => 0);
        $abn_data = array(
            'prt_id' => $prestamo,
            'cli_id' => $cliente,
            'abn_fecha' => $fecha,
            'abn_monto' => $saldo,
            'abn_nota' => $oNotas,
            'abn_autor' => $user,
        );
        $this->db->trans_start();
        $this->Loan_model->update_loan($prestamo, $prt_data); # Actualizar el prestamo
        $this->Payment_model->add_Payment($abn_data); # Registrar el abono

        $intereses = $this->Application_model->get_interest();
        $total = $this->calcTotalToPay($monto, $intereses->app_intereses);
        $data = array(
            'prt_cliente' => $cliente,
            'prt_fecha' => $fecha,
            'prt_tipo' => $tipo,
            'prt_dia' => $dia,
            'prt_monto' => $monto,
            'prt_total' => $total,
            'prt_saldo' => $total,
            'prt_cuota' => $cuotas,
            'prt_notas' => $nNotas,
            'prt_autor' => $user,
        );

        $loan = $this->Loan_model->add_Loan($data);
        $this->db->trans_complete();

        if ($this->db->trans_status() === false) {
            redirect(_App_ . "cobros/prestamos?modal=modal-error");
        } else {
            redirect(_App_ . "cobros/prestamos/$loan?modal=modal-success");
        }
    }

    /**
     * Procesa los abonos de prestamo que fallaron al momento de ingresar
     *
     * @return void
     * @author Carlos Carreño <cartur70@gmail.com>
     **/
    public function updatePaymentsLoanCron()
    {
        $x = 0;
        $band = 0;
        $loans = $this->Loan_model->get_loanListToday();
        foreach ($loans as $loan) {
            $paymentList = $this->Payment_model->get_paymentByLoanID($loan->prt_id);
            $montoPagado = 0;
            foreach ($paymentList as $payment) {
                $montoPagado += floatval($payment->abn_monto);
            }
            $saldo = floatval($loan->prt_total) - $montoPagado;
            if (floatval($loan->prt_saldo) > $saldo) {
                if ($saldo > 0) {
                    $prt_estado = 1;
                } else {
                    $prt_estado = 0;
                }
                $prt_data = array(
                    'prt_saldo' => $saldo,
                    'prt_estado' => $prt_estado,
                );
                $this->db->trans_start();
                $success = $this->Loan_model->update_loan($loan->prt_id, $prt_data);
                $this->db->trans_complete();
                $success = 1;
                $band = 1;
                if ($success) {
                    $data[$x]["id"] = $loan->prt_id;
                    $data[$x]["saldo_actual"] = $saldo;
                    $x++;
                }
            }
        }
        $mailConfig['mailpath'] = '/usr/sbin/sendmail';
        // Detalles del protocolo
        $mailConfig['protocol'] = 'sendmail';
        $mailConfig['smtp_host'] = 'relay-hosting.secureserver.net';
        $mailConfig['smtp_user'] = 'master@solucioneshym.co';
        $mailConfig['smtp_pass'] = '*0master0*';
        $mailConfig['smtp_port'] = '25';
        $mailConfig['mailtype'] = 'html';

        $this->load->library('email', $mailConfig);

        //Correo que enviará el email y un nombre
        $this->email->from('master@solucioneshym.co', 'Usuario Master');

        //Destinatarios para los que va el email
        $this->email->to('camilobeltranleon@gmail.com, master@solucioneshym.co');

        //Asunto del mensaje
        $this->email->subject("Modificación Automática de Pagos - Cronjob");
        if ($band == 1) {
            //Mensaje a enviar
            $mensaje = 'Se han modificado los siguientes registros: <br><br>';
            $mensaje = $mensaje . '<table border="1"><caption>Detalle de los items</caption><tr><th>Id Préstamo</th><th>Nuevo Monto Restante</th></tr>';
            foreach ($data as $data_loan) {
                $mensaje = $mensaje . '<tr><td>' . $data_loan["id"] . '</td><td>' . $data_loan["saldo_actual"] . '</td></tr>';
            }
            $mensaje = $mensaje . '</table>';
        } else {
            $mensaje = 'No se han modificado registros en el dia de ayer<br><br>';
        }
        $this->email->message($mensaje);

        //Envio del email
        $this->email->send();
    }

} // Class most worst and overcharged of the world
