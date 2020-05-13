<?php

class Rol extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model("rol_model");
    $this->load->model("general_model");
  }
  public function getRoles(){
    $filtro = $this->input->get('filtro');
    $result = $this->rol_model->fGetRoles($filtro);
    if (!empty($result))
      $r = array("success"=>true, "data"=>$result);
    else
      $r = array("success"=> false);
    echo json_encode($r);
  }
  public function getRolesCombo()
  {
    $result = $this->rol_model->fGetRolesCombo();
    if (!empty($result))
      $r = array("success"=>true, "data"=>$result);
    else
      $r = array("success"=> false);
    echo json_encode($r);
  }
  public function saveRol()
  {
    $data = json_decode($this->input->post('data'), TRUE);
    $res = $this->general_model->fGrdSave("usuario", "usu_id", $data);
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