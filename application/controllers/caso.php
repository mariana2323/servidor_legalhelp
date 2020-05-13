<?php

class Caso extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model("caso_model");
    $this->load->model("general_model");
  }
  public function getCasos(){
    $filtro = $this->input->get('filtro');
    $result = $this->caso_model->fGetCasos($filtro);
    if (!empty($result))
      $r = array("success"=>true, "data"=>$result);
    else
      $r = array("success"=> false);
    echo json_encode($r);
  }
  public function saveCaso()
  {
    $data = json_decode($this->input->post('data'), TRUE);
    $res = $this->general_model->fGrdSave("caso", "cas_id", $data);
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
  public function readCaso()
  {
    $id = $this->input->post('id');
    $res = $this->general_model->fReadForma($id, 'caso', 'cas_id');
    if (!empty($res))
      $r = array("success" => true,
        "data" => $res);
    else
      $r = array("success" => false);

    echo json_encode($r);
  }
}