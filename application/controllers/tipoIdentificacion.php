<?php

class TipoIdentificacion extends CI_Controller
{
  public $success = 'success';
  public function __construct()
  {
    parent::__construct();
    $this->load->model("TipoIdentificacionModel");
    $this->load->model("GeneralModel");
  }
  public function getTipoIdentificacion()
  {
    $result = $this->TipoIdentificacionModel->fGetTipoIdentificacion();
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
  public function saveTipoIdentificacion()
  {
    $data = json_decode($this->input->post('data'), TRUE);
    $res = $this->GeneralModel->fGrdSave("tipo_identificacion", "tid_id", $data);
    $result = $res[$this->success];
    $newId = $res['newId'];
    $error = $res['error'];
    if ($result)
    {
      $r = array($this->success => true,
                 "newId"        => $newId);
    }
    else
    {
      $r = array($this->success => false,
                 "error"        => $error);
    }
    echo json_encode($r);
  }
  public function deleteTipoIdentificacion()
  {
    $data = json_decode($this->input->post('data'), TRUE);
    $res = $this->GeneralModel->fGrdDelete("tipo_identificacion", "tid_id", $data);
    $r = array($this->success => $res[$this->success]);
    echo json_encode($r);
  }
}