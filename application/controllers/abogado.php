<?php

class Abogado extends CI_Controller
{
  public $success = 'success';
  public function __construct()
  {
    parent::__construct();
    $this->load->model("abogado_model");
    $this->load->model("general_model");
  }

  public function getAbogados()
  {
    $result = $this->abogado_model->fGetAbogados();
    if (!empty($result))
    {
      $r = array($this->success => true, "data" => $result);
    }
    else
    {
      $r = array($this->success => false);
    }
    echo json_encode($r);
  }
  public function saveAbogado()
  {
    $data = json_decode($this->input->post('data'), TRUE);
    $res = $this->general_model->fGrdSave("abogado", "abo_id", $data);
    $result = $res['success'];
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
  public function getEstadosAbogado()
  {
    $result = $this->abogado_model->fGetEstadosAbogado();
    if (!empty($result))
    {
      $r = array($this->success => true, "data" => $result);
    }
    else
    {
      $r = array($this->success => false);
    }
    echo json_encode($r);
  }
}