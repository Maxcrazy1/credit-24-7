<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * undocumented class
 *
 * @package models
 * @author Gerson Rodriguez <nosreg216@gmail.com>
 **/
class Calendar_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * undocumented function
     *
     * @return Array<Object>
     * @author Gerson Rodriguez <nosreg216@gmail.com>
     **/
    function get_allEntries()
    {
        $this->db->select('h.hro_id, h.prt_tipo, c.clb_nombre, h.hro_dia, r.reg_nombre');
        $this->db->from('dt_horarios h'); 
        $this->db->join('dt_colaboradores c', 'h.clb_id = c.clb_id');
        $this->db->join('dt_region r', 'h.reg_id = r.reg_id');
        $this->db->order_by('c.clb_nombre');
        $query = $this->db->get(); 

        return ($query->num_rows() != 0) ? $query->result() : FALSE;
    }

    /**
     * undocumented function
     *
     * @return void
     * @author Gerson Rodriguez <nosreg216@gmail.com>
     **/
    function add_entry($data)
    {
     #$this->output->enable_profiler(TRUE);
	   $this->db->insert('dt_horarios', $data);
	   return $this->db->insert_id();
    }
   	
   	/**
   	 * undocumented function
   	 *
   	 * @return void
   	 * @author Gerson Rodriguez <nosreg216@gmail.com>
   	 **/
   	function deleteEntry($hro_id)
   	{
      return $success = $this->db->delete('dt_horarios', array('hro_id' => $hro_id));
    }

    function deleteEntryByRegion($reg_id)
    {
      return $success = $this->db->delete('dt_horarios', array('reg_id' => $reg_id));
    }

} // END class Schedule_model