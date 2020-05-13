<?php

class preguntas_frecuentes extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model("preguntas_frecuentes_model");
    $this->load->model("general_model");
  }
  public function getPreguntasFrecuentes(){
    $result = $this->preguntas_frecuentes_model->fGetPreguntasFrecuentes();
    if (!empty($result))
      $r = array("success"=>true, "data"=>$result);
    else
      $r = array("success"=> false);
    echo json_encode($r);
  }
  public function savePreguntas()
  {
    $data = json_decode($this->input->post('data'), TRUE);
    $res = $this->general_model->fGrdSave("preguntas_frecuentes", "pre_id", $data);
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
  public function deletePreguntas()
  {
    $data = json_decode($this->input->post('data'), TRUE);
    $res = $this->general_model->fGrdDelete("preguntas_frecuentes", "pre_id", $data);
    $r = array("success" => $res["success"]);
    echo json_encode($r);
  }
}