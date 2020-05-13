<?php

class Tarjeta extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model("general_model");
  }
  public function readTarjeta()
  {
    $res = $this->general_model->fReadForma('', 'tarjeta', 'tar_id');
    if (!empty($res))
      $r = array("success" => true,
        "data" => $res);
    else
      $r = array("success" => false);

    echo json_encode($r);
  }
  public function saveTarjeta()
  {
    $data = json_decode($this->input->post('data'), TRUE);
    $res = $this->general_model->fGrdSave("tarjeta", "tar_id", $data);
    $result = $res['success'];
    $newId = $res['newId'];
    $error = $res['error'];
    if ($result)
      $r = array("success" => true,
        "newId" => $newId);
    else
      $r = array("success" => false,
        "error" => $error);

    echo json_encode($r);
  }
}