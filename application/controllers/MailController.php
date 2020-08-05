<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *
 * @package controllers
 **/
class MailController extends CI_Controller
{

	public function __construct()
	{
        parent::__construct();
        $this->load->config('email');
        $this->load->library('email');

	}

    public function SetEmailContent($emailContent)
    {

        $this->email->from($emailContent->remitentEmail, $emailContent->reminentName);
        $this->email->to($emailContent->destinatary);
        $this->email->subject($emailContent->subject);
        $this->email->message($emailContent->message);

        $this->SendEmail($emailContent);

    }

    private function SendEmail($email)
    {
        if ($email->send()) {
            $this->session->set_flashdata('envio', 'Email enviado correctamente');
        } else {
            $this->session->set_flashdata('envio', 'No se a enviado el email');
        }
    }
}
?>