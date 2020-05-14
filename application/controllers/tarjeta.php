<?php

class Tarjeta extends CI_Controller
{
  public $success = 'success';
  public function __construct()
  {
    parent::__construct();
    $this->load->model("GeneralModel");
  }
  public function readTarjeta()
  {
    $res = $this->GeneralModel->fReadForma('', 'tarjeta', 'tar_id');
    if (!empty($res))
    {
      $r = array($this->success => true, "data" => $res);
    }
    else
    {

      $r = array($this->success => false);
    }
    echo json_encode($r);
  }
  public function saveTarjeta()
  {
    $data = json_decode($this->input->post('data'), TRUE);
    $res = $this->GeneralModel->fGrdSave("tarjeta", "tar_id", $data);
    $result = $res[$this->success];
    $newId = $res['newId'];
    $error = $res['error'];
    if ($result)
    {
      $r = array($this->success => true,
                 "newId"   => $newId);
    }
    else
    {
      $r = array($this->success => false,
                 "error"   => $error);
    }
    echo json_encode($r);
  }
}