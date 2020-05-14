<?php

class Usuario extends CI_Controller
{
  public $success = 'success';
  public function __construct()
  {
    parent::__construct();
    $this->load->model("GeneralModel");
    $this->load->model("UsuarioModel");
  }

  public function readUsuario()
  {
    $id = $this->session->session_user;
    $res = $this->GeneralModel->fReadForma($id, 'usuario', 'usu_id');
    if (!empty($res))
    {
      $r = array($this->success => true, "data"=> $res);
    }
    else
    {
      $r = array($this->success => false);
    }
    echo json_encode($r);
  }
  public function saveUsuario()
  {
    $data = json_decode($this->input->post('data'), TRUE);
    $res = $this->GeneralModel->fGrdSave("usuario", "usu_id", $data);
    $result = $res[$this->success];
    $newId = $res['newId'];
    $error = $res['error'];
    if ($result)
    {
      $r = array($this->success => true,"newId"=> $newId);
    }
    else
    {
      $r = array($this->success => false, "error"=> $error);
    }
    echo json_encode($r);
  }
  public function cambiarContrasena()
  {
    $data = json_decode($this->input->post('data'), TRUE);
    $res = $this->UsuarioModel->fCambiarContrasena($data);
    $r = array($this->success => $res);
    echo json_encode($r);
  }
}