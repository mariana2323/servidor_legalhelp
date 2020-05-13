<?php

class Tipo_identificacion extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model("tipo_identificacion_model");
    $this->load->model("general_model");
  }
  public function getTipoIdentificacion()
  {
    $result = $this->tipo_identificacion_model->fGetTipoIdentificacion();
    if (!empty($result))
      $r = array("success" => true, "data" => $result);
    else
      $r = array("success" => false);
    echo json_encode($r);
  }
  public function saveTipoIdentificacion()
  {
    $data = json_decode($this->input->post('data'), TRUE);
    //$data = $this->input->post('data');
    //print_r($data);
    $res = $this->general_model->fGrdSave("tipo_identificacion", "tid_id", $data);
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
  public function deleteTipoIdentificacion()
  {
    $data = json_decode($this->input->post('data'), TRUE);
    $res = $this->general_model->fGrdDelete("tipo_identificacion", "tid_id", $data);
    $r = array("success" => $res["success"]);
    echo json_encode($r);
  }
}