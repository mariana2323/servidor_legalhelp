<?php

class PreguntasFrecuentes extends CI_Controller
{
  public $success = 'success';
  public function __construct()
  {
    parent::__construct();
    $this->load->model("PreguntasFrecuentesModel");
    $this->load->model("GeneralModel");
  }
  public function getPreguntasFrecuentes(){
    $result = $this->PreguntasFrecuentesModel->fGetPreguntasFrecuentes();
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
  public function savePreguntas()
  {
    $data = json_decode($this->input->post('data'), TRUE);
    $res = $this->GeneralModel->fGrdSave("preguntas_frecuentes", "pre_id", $data);
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
  public function deletePreguntas()
  {
    $data = json_decode($this->input->post('data'), TRUE);
    $res = $this->GeneralModel->fGrdDelete("preguntas_frecuentes", "pre_id", $data);
    $r = array($this->success => $res[$this->success]);
    echo json_encode($r);
  }
}