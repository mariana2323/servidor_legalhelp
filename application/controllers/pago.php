<?php

class Pago extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model("pago_model");
    $this->load->model("general_model");
  }
  public function habilitaPago()
  {
    $caso = $this->input->post('caso');
    $data = json_decode($this->input->post('data'), TRUE);
    $result = $this->pago_model->fHabilitaPago($caso, $data);
    if ($result)
      $r = array("success"=>true);
    else
      $r = array("success"=> false, "error"=>'Ha ocurrido un error habilitando el pago');
    echo json_encode($r);
  }

}