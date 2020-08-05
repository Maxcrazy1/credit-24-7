<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Loan_model extends CI_Model
{

    /**
     * undocumented function
     *
     * @return void
     * @author Gerson Rodriguez <nosreg216@gmail.com>
     **/
    public function getLoanListActive($region = null, $startDate = null, $endDate = null)
    {
        $this->db->select('p.*, c.cli_id, c.cli_nombre');
        $this->db->from('dt_prestamos as p');
        $this->db->join('dt_clientes as c', 'p.prt_cliente = c.cli_id');
        $this->db->order_by('prt_fecha desc');
        $this->db->where(array('prt_estado' => 1));
        if (!is_null($startDate) and !is_null($endDate)) {
            $this->db->where("prt_fecha BETWEEN '$startDate' AND '$endDate'");
        }

        if (!is_null($region)) {
            if ($region != 0) {
                $this->db->where(array('c.cli_region' => $region));
            }
        }
        $query = $this->db->get();
        return ($query->num_rows() != 0) ? $query->result() : false;
    }

    public function getTotalsLoan($region = 0, $startDate = null, $endDate = null)
    {
        $this->db->select_sum('p.prt_monto');
        $this->db->from('dt_prestamos as p');
        $this->db->join('dt_clientes as c', 'p.prt_cliente = c.cli_id');
        $this->db->order_by('prt_fecha desc');
        $this->db->where(array('prt_estado' => 1));

        if (!is_null($startDate) and !is_null($endDate)) {
            $this->db->where("prt_fecha BETWEEN '$startDate' AND '$endDate'");
        }

        if ($region != 0) {
            $this->db->where(array('c.cli_region' => $region));
        }

        $query = $this->db->get();

        return ($query->row('prt_monto') != '') ? $query->row('prt_monto') : 0;
    }

    /**
     * undocumented function
     *
     * @return void
     * @author Carlos Carreño <cartur70@gmail.com>
     **/
    public function get_loanListToday()
    {
        $today = date("Y-m-d", strtotime('-1 days'));
        $this->db->from('dt_prestamos');
        $this->db->where(array('prt_estado' => 1, 'prt_ultimoPago' => $today));
        //$this->db->where('prt_ultimoPago' => $today);
        $query = $this->db->get();
        return ($query->num_rows() != 0) ? $query->result() : false;
    }

    /**
     * undocumented function
     *
     * @return void
     * @author Carlos Carreño <cartur70@gmail.com>
     **/
    public function get_loanIDsToday()
    {
        $today = date("Y-m-d", strtotime('-1 days'));
        $this->db->select('prt_id');
        $this->db->from('dt_prestamos');
        $this->db->where(array('prt_estado' => 1, 'prt_ultimoPago' => $today));
        //$this->db->where('prt_ultimoPago' => $today);
        $query = $this->db->get();
        return ($query->num_rows() != 0) ? $query->result() : false;
    }

    /**
     * undocumented function
     *
     * @return void
     * @author Gerson Rodriguez <nosreg216@gmail.com>
     **/
    public function get_loanListRange($fecha_Inicial, $fecha_Final)
    {
        $this->db->from('dt_prestamos as p');
        $this->db->join('dt_clientes as c', 'p.prt_cliente = c.cli_id');
        $this->db->order_by('prt_fecha desc');
        $this->db->where(array('prt_estado' => 1));
        $range = "prt_fecha BETWEEN '$fecha_Inicial' AND '$fecha_Final'";
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
    public function get_newLoanListRangeByRegion($region, $fecha_Inicial, $fecha_Final)
    {
        $this->db->distinct();
        $this->db->select('p.prt_id');
        $this->db->from('dt_prestamos p');
        $this->db->join('dt_prt_abonos a', 'p.prt_id = a.prt_id');
        $this->db->where('p.prt_estado', 1);
        $this->db->order_by('p.prt_id');
        $query = $this->db->get();
        if ($query->num_rows() == 0) {
            return false;
        } else {
            $query1 = $query->result();
            $cli_id = array();
            $x = 0;
            $prt_id = array();
            foreach ($query1 as $row) {
                $loans = implode(",", $prt_id);
                $ids = explode(",", $loans);

                $this->db->select('p.*,SUM(ab.abn_monto) as totalCredited');
                $this->db->from('dt_prestamos as p');
                $this->db->join('dt_clientes as c', 'p.prt_cliente = c.cli_id');
                $this->db->join('dt_prt_abonos as ab', 'p.prt_id = ab.prt_id');
                $this->db->where(array('p.prt_estado' => 1));
                $this->db->group_by('p.prt_id');
                $this->db->order_by('p.prt_fecha desc');
                if ($region != 0) {
                    $this->db->where(array('c.cli_region' => $region));
                }
                $range = "prt_fecha BETWEEN '$fecha_Inicial' AND '$fecha_Final'";
                $this->db->where($range);
                $query = $this->db->get();
                return ($query->num_rows() != 0) ? $query->result() : false;
            }
        }
    }

    public function get_allLoanRangeByRegion($region, $fecha_Inicial, $fecha_Final)
    {
        $this->db->select('p.*,SUM(ab.abn_monto) as totalCredited');
        $this->db->from('dt_prestamos as p');
        $this->db->join('dt_clientes as c', 'p.prt_cliente = c.cli_id');
        $this->db->join('dt_prt_abonos as ab', 'p.prt_id = ab.prt_id');
        $this->db->group_by('p.prt_id');
        $this->db->order_by('p.prt_fecha desc');
        if ($region != 0) {
            $this->db->where(array('c.cli_region' => $region));
        }
        $range = "ab.abn_fecha BETWEEN '$fecha_Inicial' AND '$fecha_Final'";
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
    public function get_totalNewLoanListRangeByRegion($region, $fecha_Inicial, $fecha_Final)
    {
        $this->db->distinct();
        $this->db->select('p.prt_id');
        $this->db->from('dt_prestamos p');
        $this->db->join('dt_prt_abonos a', 'p.prt_id = a.prt_id');
        $this->db->where('p.prt_estado', 1);
        $this->db->order_by('p.prt_id');
        $query = $this->db->get();
        if ($query->num_rows() == 0) {
            return false;
        } else {
            $query1 = $query->result();
            $cli_id = array();
            $x = 0;
            $prt_id = array();
            foreach ($query1 as $row) {
                $prt_id[] = $row->prt_id;
            }
            $loans = implode(",", $prt_id);
            $ids = explode(",", $loans);

            $this->db->select_sum('p.prt_monto');
            $this->db->from('dt_prestamos as p');
            $this->db->join('dt_clientes as c', 'p.prt_cliente = c.cli_id');
            $this->db->order_by('p.prt_fecha desc');
            $this->db->where(array('p.prt_estado' => 1));
            if ($region != 0) {
                $this->db->where(array('c.cli_region' => $region));
            }
            $this->db->where_not_in('p.prt_id', $ids);
            $range = "prt_fecha BETWEEN '$fecha_Inicial' AND '$fecha_Final'";
            $this->db->where($range);
            $query = $this->db->get();
            return ($query->row('prt_monto') != '') ? $query->row('prt_monto') : 0;
        }
    }

    /**
     * undocumented function
     *
     * @return void
     * @author Gerson Rodriguez <nosreg216@gmail.com>
     **/
    public function get_loanListByClient($clientID)
    {
        $this->db->order_by('prt_fecha desc');
        $this->db->where('prt_cliente', $clientID);
        $query = $this->db->get('dt_prestamos');
        return ($query->num_rows() != 0) ? $query->result() : false;
    }

    /**
     * Retorna la lista de todos los prestamos hechos por un colaborador
     *
     * @return void
     * @author Gerson Rodriguez <nosreg216@gmail.com>
     **/
    public function get_loanListByColabID($colabId)
    {
        $today = date("Y-m-d", time());
        $this->db->order_by('prt_fecha desc');
        $this->db->from('dt_prestamos as p');
        $this->db->join('dt_colaboradores as c', 'p.prt_autor = c.clb_id');
        $this->db->join('dt_clientes as cl', 'p.prt_cliente = cl.cli_id');
        $this->db->where(array('p.prt_autor' => $colabId));
        $this->db->where("p.prt_fecha > '$today'");
        $query = $this->db->get();
        return ($query->num_rows() != 0) ? $query->result() : false;
    }

    /**
     * undocumented function
     *
     * @return void
     * @author Gerson Rodriguez <nosreg216@gmail.com>
     **/
    public function get_activeLoanListByClient($clientID)
    {
        $this->db->order_by('prt_fecha desc');
        $this->db->where('prt_estado', 1);
        $this->db->where('prt_cliente', $clientID);
        $query = $this->db->get('dt_prestamos');
        return ($query->num_rows() != 0) ? $query->result() : false;
    }

    /**
     * undocumented function
     *
     * @return void
     * @author Gerson Rodriguez <nosreg216@gmail.com>
     **/
    public function get_loanByID($loanId)
    {
        $query = $this->db->get_where('dt_prestamos', array('prt_id' => $loanId));
        return ($query->num_rows() != 0) ? $query->row() : false;
    }

    /**
     * undocumented function
     *
     * @return void
     * @author Gerson Rodriguez <nosreg216@gmail.com>
     **/
    public function add_Loan($data)
    {
        $this->db->insert('dt_prestamos', $data);
        return $this->db->insert_id();
    }

    /**
     * undocumented function
     *
     * @return void
     * @author Gerson Rodriguez <nosreg216@gmail.com>
     **/
    public function update_loan($loanID, $data)
    {
        #$this->output->enable_profiler(TRUE);
        $this->db->where(array('prt_id' => $loanID));
        $success = $this->db->update('dt_prestamos', $data);
        return ($success) ? $loanID : false;
    }

    /**
     * undocumented function
     *
     * @return void
     * @author Gerson Rodriguez <nosreg216@gmail.com>
     **/
    public function delete_loan($loanID)
    {
        $success = $this->db->delete('dt_prt_abonos', array('prt_id' => $loanID));
        if ($success) {
            $success = $this->db->delete('dt_prestamos', array('prt_id' => $loanID));
        }
        return $success;
    }

    /**
     * undocumented function
     *
     * @return void
     * @author Carlos Carre単o <cartur70@gmail.com>
     **/
    public function get_paymentCuota($loanId)
    {
        $this->db->select_sum('prt_cuota');
        $this->db->where('prt_id', $loanId);
        $query = $this->db->get('dt_prestamos');
        return $query->row('prt_cuota');
    }

    /**
     * undocumented function
     *
     * @return void
     * @author Carlos Carre単o <cartur70@gmail.com>
     **/
    public function update_payment($payment_id, $data)
    {
        $this->db->where(array('abn_id' => $payment_id));
        $success = $this->db->update('dt_prt_abonos', $data);
        return ($success) ? $payment_id : false;
    }
}
