<?php

class Pago extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model("PagoModel");
    $this->load->model("GeneralModel");
  }
  public function habilitaPago()
  {
    $caso = $this->input->post('caso');
    $data = json_decode($this->input->post('data'), TRUE);
    $result = $this->PagoModel->fHabilitaPago($caso, $data);
    if ($result)
    {
      $r = array("success" => true);
    }
    else
    {
      $r = array("success" => false, "error" => 'Ha ocurrido un error habilitando el pago');
    }
    echo json_encode($r);
  }

}