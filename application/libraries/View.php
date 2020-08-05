<?php

class View { 
    function set_viewDesktop($view,$data){
        $this->load->view("static/header", $data);
        $this->load->view("static/sidebar");
        $this->load->view($view, $data);
        $this->load->view("static/footer");
    }
}

?>