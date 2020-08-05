<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Expense_model extends CI_Model
{

    /**
     * undocumented function
     *
     * @return void
     * @author Carlos Carreño <cartur70@gmail.com>
     **/
    public function get_expenseListTodayByColaborator($colabId)
    {
        $today = date("Y-m-d", time());
        $this->db->from('dt_gastos_colaborador as g');
        $this->db->join('dt_region as r', 'g.gas_region = r.reg_id');
        $this->db->where(array('g.gas_autor' => $colabId));
        $this->db->where("g.gas_fecha = '$today'");
        $this->db->order_by('g.gas_id desc');
        $query = $this->db->get();
        return ($query->num_rows() != 0) ? $query->result() : false;
    }

    /**
     * undocumented function
     *
     * @return void
     * @author Carlos Carreño <cartur70@gmail.com>
     **/
    public function get_totalExpensesTodayBycolaborator($colab)
    {
        $today = date("Y-m-d", time());
        $this->db->select_sum('gas_monto');
        $this->db->where(array('gas_autor' => $colab));
        $this->db->where("gas_fecha = '$today'");
        $query = $this->db->get('dt_gastos_colaborador');
        $result = $query->result();
        return ($result[0]->gas_monto == '') ? 0 : $result[0]->gas_monto;
    }

    /**
     * undocumented function
     *
     * @return void
     * @author Carlos Carre���o <cartur70@gmail.com>
     **/
    public function get_expensesListRangeByRegion($region, $fecha_Inicial, $fecha_Final)
    {
        $this->db->order_by('gas_fecha desc');
        $this->db->from('dt_gastos_colaborador as g');
        $this->db->join('dt_region as r', 'g.gas_region = r.reg_id');
        $this->db->join('dt_colaboradores as c', 'g.gas_autor = c.clb_id');
        $range = "g.gas_fecha BETWEEN '$fecha_Inicial' AND '$fecha_Final'";
        $this->db->where($range);

        if (!$this->AreAllRegions($region)) {
            $this->db->where(array('g.gas_region' => $region));
        }

        $query = $this->db->get();
        return ($query->num_rows() != 0) ? $query->result() : false;
    }

    /**
     * undocumented function
     *
     * @return void
     * @author Carlos Carre���o <cartur70@gmail.com>
     **/
    public function get_totalExpensesListRangeByRegion($region, $fecha_Inicial, $fecha_Final)
    {
        $this->db->select_sum('g.gas_monto');
        $this->db->from('dt_gastos_colaborador as g');
        $this->db->join('dt_region as r', 'g.gas_region = r.reg_id');
        $this->db->join('dt_colaboradores as c', 'g.gas_autor = c.clb_id');
        $range = "gas_fecha BETWEEN '$fecha_Inicial' AND '$fecha_Final'";
        $this->db->where($range);
        if (!$this->AreAllRegions($region)) {
            $this->db->where(array('g.gas_region' => $region));
        }
        $query = $this->db->get();
        $result = $query->result();
        return ($result[0]->gas_monto == '') ? 0 : $result[0]->gas_monto;
    }

    private function AreAllRegions($region)
    {
        return ($region != 0) ? false : true;
    }

    /**
     * funcion para ingresar nuevo gasto
     *
     * @return void
     * @author Carlos Carreño <cartur70@gmail.com>
     **/
    public function add_expense($data)
    {
        $this->db->insert('dt_gastos_colaborador', $data);
        return $this->db->insert_id();
    }

    /**
     * funcion para eliminar un gasto
     *
     * @return void
     * @author Carlos Carreño <cartur70@gmail.com>
     **/
    public function delete_expense($expenceId)
    {
        $success = $this->db->delete('dt_gastos_colaborador', array('gas_id' => $expenceId));
        return $success;
    }
}
