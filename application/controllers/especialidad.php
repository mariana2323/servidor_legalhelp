<?php

class Especialidad extends CI_Controller
{
  public $success = 'success';
  public function __construct()
  {
    parent::__construct();
    $this->load->model("EspecialidadModel");
    $this->load->model("GeneralModel");
  }
  public function getEspecialidades(){
    $result = $this->EspecialidadModel->fGetEspecialidades();
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
  public function saveEspecialidad()
  {
    $data = json_decode($this->input->post('data'), TRUE);
    $res = $this->GeneralModel->fGrdSave("especialidad", "esp_id", $data);
    $result = $res[$this->success];
    $newId = $res['newId'];
    $error = $res['error'];
    if ($result)
    {
      $r = array($this->success => true, "newId" => $newId);
    }
    else
    {
      $r = array($this->success => false,"error" => $error);
    }
    echo json_encode($r);
  }
  public function deleteEspecialidad()
  {
    $data = json_decode($this->input->post('data'), TRUE);
    $res = $this->GeneralModel->fGrdDelete("especialidad", "esp_id", $data);
    $r = array($this->success => $res[$this->success]);
    echo json_encode($r);
  }
}