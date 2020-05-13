<?php

class Usuario extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model("general_model");
    $this->load->model("usuario_model");
  }

  public function readUsuario()
  {
    $id = $this->session->session_user;
    $res = $this->general_model->fReadForma($id, 'usuario', 'usu_id');
    if (!empty($res))
      $r = array("success" => true,
        "data" => $res);
    else
      $r = array("success" => false);

    echo json_encode($r);
  }
  public function saveUsuario()
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
  public function cambiarContrasena()
  {
    $data = json_decode($this->input->post('data'), TRUE);
    $res = $this->usuario_model->fCambiarContrasena($data);
    $r = array("success" => $res);
    echo json_encode($r);
  }
}