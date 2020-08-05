<?php

defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Metodos de entrada y salida para los abonos a prestamos.
 *
 * @package models
 * @author Gerson Rodriguez <nosreg216@gmail.com>
 **/
class Payment_model extends CI_Model
{

    /**
     * NUEVO: Busca un pago por id
     *
     * @return void
     * @author Gerson Rodriguez <nosreg216@gmail.com>
     **/
    public function get_paymentByID($id)
    {
        $query = $this->db->get_where("dt_prt_abonos", array('abn_id' => $id));
        return ($query->num_rows() != 0) ? $query->row() : false;
    }

    /**
     * Retorna la lista de todos los pagos
     *
     * @return void
     * @author Gerson Rodriguez <nosreg216@gmail.com>
     **/
    public function get_paymentList()
    {
        $this->db->order_by('abn_fecha desc');
        $this->db->from('dt_prt_abonos as a');
        $this->db->join('dt_colaboradores as c', 'a.abn_autor = c.clb_id');
        $this->db->join('dt_clientes as cl', 'a.cli_id = cl.cli_id');
        $query = $this->db->get();
        return ($query->num_rows() != 0) ? $query->result() : false;
    }

    /**
     * undocumented function
     *
     * @return void
     * @author Gerson Rodriguez <nosreg216@gmail.com>
     **/
    public function get_paymentListRange($fecha_Inicial, $fecha_Final)
    {
        $this->db->order_by('abn_fecha desc');
        $this->db->from('dt_prt_abonos as a');
        $this->db->join('dt_colaboradores as c', 'a.abn_autor = c.clb_id');
        $this->db->join('dt_clientes as cl', 'a.cli_id = cl.cli_id');
        $range = "abn_fecha BETWEEN '$fecha_Inicial' AND '$fecha_Final'";
        $this->db->where($range);
        $query = $this->db->get();
        return ($query->num_rows() != 0) ? $query->result() : false;
    }

    /**
     * undocumented function
     *
     * @return void
     * @author Carlos Carreño <cartur70@gmail.com>
     **/
    public function get_paymentListRangeByRegion($region, $fecha_Inicial, $fecha_Final)
    {
        $this->db->order_by('abn_fecha desc');
        $this->db->from('dt_prt_abonos as a');
        $this->db->join('dt_colaboradores as c', 'a.abn_autor = c.clb_id');
        $this->db->join('dt_clientes as cl', 'a.cli_id = cl.cli_id');
        $range = "abn_fecha BETWEEN '$fecha_Inicial' AND '$fecha_Final'";
        $this->db->where($range);
        if ($region != 0) {
            $this->db->where(array('cl.cli_region' => $region));
        }
        $this->db->where('a.abn_status > 0');
        $query = $this->db->get();
        return ($query->num_rows() != 0) ? $query->result() : false;
    }

    /**
     * undocumented function
     *
     * @return void
     * @author Carlos Carreño <cartur70@gmail.com>
     **/
    public function get_totalPaymentListRangeByRegion($region, $fecha_Inicial, $fecha_Final)
    {
        $this->db->select_sum('a.abn_monto');
        $this->db->from('dt_prt_abonos as a');
        $this->db->join('dt_colaboradores as c', 'a.abn_autor = c.clb_id');
        $this->db->join('dt_clientes as cl', 'a.cli_id = cl.cli_id');
        $range = "abn_fecha BETWEEN '$fecha_Inicial' AND '$fecha_Final'";
        $this->db->where($range);
        if ($region != 0) {
            $this->db->where(array('cl.cli_region' => $region));
        }
        $this->db->where('a.abn_status > 0');
        $this->db->where("a.abn_contable = 1");
        $query = $this->db->get();
        return ($query->row('abn_monto') != '') ? $query->row('abn_monto') : 0;
    }

    /**
     * Retorna la lista de todos los pagos hechos a un prestamo
     *
     * @return void
     * @author Gerson Rodriguez <nosreg216@gmail.com>
     **/
    public function get_paymentListByLoanID($loanId)
    {
        $this->db->order_by('abn_fecha desc');
        $this->db->from('dt_prt_abonos as a');
        $this->db->join('dt_usuarios as u', 'a.abn_autor = u.usr_id');
        $this->db->join('dt_colaboradores as c', 'a.abn_autor = c.clb_id', 'left');
        $this->db->where(array('a.prt_id' => $loanId));
        $query = $this->db->get();
        return ($query->num_rows() != 0) ? $query->result() : false;
    }

    /**
     * Retorna la lista de todos los pagos hechos a un prestamo
     *
     * @return void
     * @author Carlos Carreño <cartur70@gmail.com>
     **/
    public function get_paymentByLoanID($loanId)
    {
        $this->db->order_by('abn_fecha desc');
        $this->db->from('dt_prt_abonos');
        $this->db->where(array('prt_id' => $loanId));
        $query = $this->db->get();
        return ($query->num_rows() != 0) ? $query->result() : false;
    }

    /**
     * Devuelve la fecha del ultimo pago hecho a un prestamo
     *
     * @return void
     * @author Gerson Rodriguez <nosreg216@gmail.com>
     **/
    public function get_lastPayment($loanId)
    {
        $this->db->limit(1);
        $this->db->order_by('abn_fecha desc');
        $query = $this->db->get_where('dt_prt_abonos', array('prt_id' => $loanId));
        return ($query->num_rows() != 0) ? $query->row() : false;
    }

    /**
     * Devuelve el monto abonado del cliente
     *
     * @return void
     * @author Alexis Hernández <alexis@suespacio.net>
     **/
    public function get_abnMonto($loanId)
    {
        $this->db->select_sum('abn_monto');
        $this->db->where('prt_id', $loanId);
        $query = $this->db->get('dt_prt_abonos');
        return $query->row('abn_monto');
    }

    /**
     * Retorna la lista de todos los pagos hechos por un cliente
     *
     * @return void
     * @author Gerson Rodriguez <nosreg216@gmail.com>
     **/
    public function get_paymentListByClientID($clientId)
    {
        #$this->output->enable_profiler(TRUE);
        $this->db->order_by('abn_fecha desc');
        $this->db->from('dt_prt_abonos as a');
        $this->db->join('dt_colaboradores as c', 'a.abn_autor = c.clb_id');
        $this->db->where(array('a.cli_id' => $clientId));
        $this->db->limit(10);
        $query = $this->db->get();
        return ($query->num_rows() != 0) ? $query->result() : false;
    }

    /**
     * Retorna la lista de todos los cobros hechos por un colaborador
     *
     * @return void
     * @author Gerson Rodriguez <nosreg216@gmail.com>
     **/
    public function get_paymentListByColabID($colabId)
    {

        $today = date("Y-m-d", time());
        $this->db->order_by('abn_fecha desc');
        $this->db->from('dt_prt_abonos as a');
        $this->db->join('dt_colaboradores as c', 'a.abn_autor = c.clb_id');
        $this->db->join('dt_clientes as cl', 'a.cli_id = cl.cli_id');
        $this->db->where(array('a.abn_autor' => $colabId));
        $this->db->where("a.abn_fecha >= '$today'");
        $query = $this->db->get();
        return ($query->num_rows() != 0) ? $query->result() : false;
    }

    /**
     * Retorna la lista de todos los cobros hechos por un colaborador
     *
     * @return void
     * @author Gerson Rodriguez <nosreg216@gmail.com>
     **/
    public function get_todayRevenueByColabID($colabId)
    {
        #$this->output->enable_profiler(TRUE);
        $today = date("Y-m-d", time());
        $this->db->select_sum('abn_monto');
        $this->db->from('dt_prt_abonos');
        $this->db->where('abn_autor', $colabId);
        $this->db->where("abn_fecha >= '$today'");
        $this->db->where("abn_contable = 1");
        $query = $this->db->get();
        return ($query->num_rows() != 0) ? $query->row() : false;
    }

    /**
     * Retorna la lista de todos los cobros hechos por un colaborador
     *
     * @return void
     * @author Gerson Rodriguez <nosreg216@gmail.com>
     **/
    public function get_todayPaymentListByColabID($clb_id)
    {
        $sql = "SELECT * FROM dt_prt_abonos WHERE abn_autor = $clb_id and date(abn_fecha) = curdate() order by abn_fecha";
        $query = $this->db->query($sql);
        return ($query->num_rows() != 0) ? $query->result() : false;
    }

    /**
     * undocumented function
     *
     * @return void
     * @author Gerson Rodriguez <nosreg216@gmail.com>
     **/
    public function add_Payment($data)
    {
        #$this->output->enable_profiler(TRUE);
        return $this->db->insert('dt_prt_abonos', $data);
    }

    /**
     * undocumented function
     *
     * @return void
     * @author Gerson Rodriguez <nosreg216@gmail.com>
     **/
    public function get_revenueToday()
    {
        #$this->output->enable_profiler(TRUE);
        $today = date('Y-m-d');
        $this->db->select_sum('abn_monto');
        $this->db->where("abn_fecha >= '$today'");
        $this->db->where("abn_contable = 1");
        $query = $this->db->get('dt_prt_abonos');
        return $query->result();
    }

    /**
     * undocumented function
     *
     * @return void
     * @author Gerson Rodriguez <nosreg216@gmail.com>
     **/
    public function get_revenueTodayPrestamo()
    {
        #$this->output->enable_profiler(TRUE);
        $today = date('Y-m-d');
        $this->db->select_sum('prt_monto');
        $this->db->where("prt_fecha >= '$today'");
        $query = $this->db->get('dt_prestamos');
        return $query->result();
    }

    /**
     * undocumented function
     *
     * @return void
     * @author Gerson Rodriguez <nosreg216@gmail.com>
     **/
    public function get_revenueRange($start, $end)
    {
        #$this->output->enable_profiler(TRUE);
        $this->db->select_sum('abn_monto');
        $this->db->where("abn_fecha >= '$start'");
        $this->db->where("abn_fecha <= '$end'");
        $this->db->where("abn_contable = 1");
        $query = $this->db->get('dt_prt_abonos');
        return $query->result();
    }

    /**
     * undocumented function
     *
     * @return void
     * @author Gerson Rodriguez <nosreg216@gmail.com>
     **/
    public function GetRevenueRegionRangePrestamo($start, $end, $region = 0)
    {
        #$this->output->enable_profiler(TRUE);
        $this->db->select_sum('prt_monto');
        $this->db->from('dt_prestamos p');
        $this->db->join('dt_clientes c', "p.prt_cliente = c.cli_id");
        $this->db->where("prt_fecha >= '$start'");
        $this->db->where("prt_fecha <= '$end'");
        if ($region != 0) {
            $this->db->where("c.cli_region='$region'");
        }
        $query = $this->db->get();
        return $query->result();

    }

    public function GetRevenueRegionRangeList($start, $end, $region = 0)
    {
        $this->db->select('*');
        $this->db->from('dt_prestamos p');
        $this->db->join('dt_clientes c', "p.prt_cliente = c.cli_id");
        $this->db->where("prt_fecha >= '$start'");
        $this->db->where("prt_fecha <= '$end'");
        if ($region != 0) {
            $this->db->where("c.cli_region='$region'");
        }
        $query = $this->db->get();
        return $query->result();

    }

    /**
     * undocumented function
     *
     * @return void
     * @author Gerson Rodriguez <nosreg216@gmail.com>
     **/
    public function delete_payment($paymentID)
    {
        $this->db->delete('dt_prt_abonos', array('abn_id' => $paymentID));
    }

} // END class Payment_model
