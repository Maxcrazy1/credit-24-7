<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 *
 * @package controllers
 **/
class ViewController extends CI_Controller
{
    public function setViewDesktop($view, $data = null)
    {
        $this->load->view("static/header", $data);
        $this->load->view("static/sidebar");
        $this->load->view($view, $data);
        $this->load->view("static/footer");
    }

    public function setViewMobile($view, $data = null)
    {
        $this->load->view("mobile/header", $data);
        $this->load->view("mobile/sidebar");
        $this->load->view($view, $data);
        $this->load->view("mobile/footer");
    }

}
