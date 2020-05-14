<?php

class DetallePago extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model("DetallePagoModel");
    $this->load->helper('file');
  }

  public function getDetallePago()
  {
    $result = $this->DetallePagoModel->fGetDetallePago();
    if (!empty($result))
    {
      $r = array("success" => true, "data" => $result);
    }
    else
    {
      $r = array("success" => false);
    }
    echo json_encode($r);
  }
}