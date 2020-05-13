<?php

class TipoEspecialidad extends CI_Controller
{
  public $success = 'success';
  public function __construct()
  {
    parent::__construct();
    $this->load->model("tipo_especialidad_model");
    $this->load->model("general_model");
  }
  public function getTipoEspecialidades(){
    $result = $this->tipo_especialidad_model->fGetTipoEspecialidades();
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
  public function saveTipoEspecialidad()
  {
    $data = json_decode($this->input->post('data'), TRUE);
    $res = $this->general_model->fGrdSave("tipo_especialidad", "tes_id", $data);
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
  public function deleteTipoEspecialidad()
  {
    $data = json_decode($this->input->post('data'), TRUE);
    $res = $this->general_model->fGrdDelete("tipo_especialidad", "tes_id", $data);
    $r = array($this->success => $res[$this->success]);
    echo json_encode($r);
  }
}