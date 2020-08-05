<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Client_model extends CI_Model {

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author Gerson Rodriguez <nosreg216@gmail.com>
	 **/
	function get_clientList()
	{
        $this->db->from('dt_clientes');
        $this->db->order_by('cli_nombre');
        $query = $this->db->get();
        return ($query->num_rows() != 0) ? $query->result() : FALSE;
	}

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author Gerson Rodriguez <nosreg216@gmail.com>
	 **/
	function get_clientByID($clientId)
	{
        $query = $this->db->get_where('dt_clientes', array('cli_id' => $clientId));
        return ($query->num_rows() != 0) ? $query->row() : FALSE;
	}

	function get_clientByDocumentId($documentId)
	{
        $query = $this->db->get_where('dt_clientes', array('cli_cedula' => $documentId));
        return ($query->num_rows() != 0) ? $query->row() : FALSE;
	}



	/**
	 * undocumented function
	 *
	 * @return void
	 * @author Carlos Carreño <cartur70@gmail.com>
	 **/
	function get_clientListByRegionAndType($region, $type)
	{
		#$this->output->enable_profiler(TRUE);
        $this->db->distinct();
		$this->db->select('c.cli_id, c.cli_nombre, c.cli_telefono, c.cli_cedula, p.prt_tipo, p.prt_dia, p.prt_ultimoPago, p.prt_fecha');
		$this->db->from('dt_clientes c');
		$this->db->join('dt_prestamos p', 'c.cli_id = p.prt_cliente');
		$this->db->where('p.prt_estado', 1);
		$this->db->where('c.cli_region', $region);
		$this->db->where('p.prt_tipo', $type);
		#$this->db->group_by('c.cli_id');
		$this->db->order_by('c.cli_nombre');
        $query = $this->db->get();
        //return ($query->num_rows() != 0) ? $query->result() : FALSE;
        if ($query->num_rows() == 0) {
            return false;
        }else{
            $query1 = $query->result();
            
            $cli_id= array();
            $x = 0;
            foreach($query1 as $row){
                $cli_id[] = $row->cli_id;
                
                $result_date = substr($row->prt_fecha,0,10);
                $today = date("Y-m-d");
                if ($result_date == $today) {
                    $statusColor = "bg-yellow-light";
                }else{
                
                    $status = 5;
                    $this->db->select('abn_id, abn_status, abn_fecha');
                    $this->db->from('dt_prt_abonos');
                    $this->db->where('cli_id', $row->cli_id);
                    $this->db->order_by('abn_id desc');
                    $this->db->limit(1);
                    $query = $this->db->get();
    
                    $result_status = $query->row('abn_status');
                    $result_date = substr($query->row('abn_fecha'),0,10);
                    if ($result_date == $today){
                        $status = ($result_status != '') ? $result_status : 5;
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
                    }else{
                        $statusColor = "";
                    }
                }
                $query1[$x]->status = $statusColor;
    			$x++;
            }
            
            return $query1;
        }
	}
	
	/**
	 * undocumented function
	 *
	 * @return void
	 * @author Carlos Carreño <cartur70@gmail.com>
	 **/
	function get_clientListByRegionAndTypeWithoutLoan($region, $type, $clientlist)
	{
        if (is_array($clientlist) || is_object($clientlist))
        {
            $cli_id= array();
            foreach($clientlist as $row){
                $cli_id[] = $row->cli_id;
            }
            $clients = implode(",",$cli_id);
            $ids = explode(",", $clients);
        }else{
            $ids = [0];
        }
        $this->db->select('cli_id, cli_nombre, cli_telefono, cli_cedula');
        $this->db->from('dt_clientes');
        $this->db->where('cli_region', $region);
        $this->db->where_not_in('cli_id', $ids);
        $this->db->order_by('cli_nombre');
        $query = $this->db->get();
        $queryfinal = $query->result();
        return (count($queryfinal) != 0) ? $queryfinal : FALSE;
	}

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author Bryan Jimenez <brijir08@gmail.com>
	 **/
	function get_historyClientByID($clientId)
	{
        /**$this->db->from('dt_prestamos as p'); **/
        $this->db->order_by('prt_fecha desc');
        $query = $this->db->get_where('dt_prestamos', array('prt_cliente' => $clientId));
        return $query->result();
	}

	/**
	 * Genera la lista de clientes con pagos pendientes al dia de hoy.
	 *
	 * @return void
	 * @author Gerson Rodriguez <nosreg216@gmail.com>
	 **/
	function get_PendingClientList()
	{
	}

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author Gerson Rodriguez <nosreg216@gmail.com>
	 **/
	function add_Client($data)
	{
	   $this->db->insert('dt_clientes', $data);
	   return $this->db->insert_id();
	}
    
	/**
	 * undocumented function
	 *
	 * Obtener cédula de cliente para comparar
	 *
	 * @return void
	 * @author Alexis Hernández <alexis@suespacio.net>
	 **/
	function cedula_client($cedula)
	{
	   $this->db->select('cli_cedula');
	   $this->db->where('cli_cedula', $cedula);
	   $query = $this->db->get('dt_clientes');
	   return $query->row('cli_cedula');
	}
	
	/**
	 * undocumented function
	 *
	 * @return void
	 * @author Gerson Rodriguez <nosreg216@gmail.com>
	 **/
	function update_client($clientID,$data)
	{
		#$this->output->enable_profiler(TRUE);
		$this->db->where(array('cli_id' => $clientID));
		$success = $this->db->update('dt_clientes', $data);
		return ($success) ? $clientID : FALSE;
	}

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author Gerson Rodriguez <nosreg216@gmail.com>
	 **/
	function delete_client($clientID)
	{
		$this->db->delete('dt_prt_abonos', array('cli_id' => $clientID));
		$this->db->delete('dt_prestamos', array('prt_cliente' => $clientID));
		$this->db->delete('dt_clientes', array('cli_id' => $clientID));
		return 1;
	}

}