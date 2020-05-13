<?php

class Login extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model("login_model");
  }

  public function index()
  {
    $usr = $this->input->post("email");
    $pwd = $this->input->post("password");

    $result = $this->login_model->fLogin($usr, $pwd);
    if (!empty($result))
    {
      //Variable de sesión para el permiso de acceso
      //$this->session->set_userdata('session_nick', $result["acceso"]);
      //Variable de sesión para el usuario
      $this->session->set_userdata('session_user', $result["usu_id"]);
      //Resultados
      $r = array("data" => $result, "success" => true);
    }
    else
      $r = array("success" => false);

    echo json_encode($r);
  }
  public function logged()
  {
    $usuario = $this->session->session_user;
    if (!empty($usuario))
      $result = $this->login_model->fLogged($usuario);
    else
      $result = array("success"=>false);
    echo json_encode($result);

  }
  public function logout()
  {
    $usr = $this->session->session_user;
    if (!empty($usr))
    {
      //Borra todas las variables de sesión
      $user_data = $this->session->all_userdata();
      foreach ($user_data as $key => $value)
      {
        $this->session->unset_userdata($key);
      }
      //Destruye la sesión actual
      $this->session->sess_destroy();

      $result = array('success' => TRUE,
        'message' => "Proyecto Exit.");
    }
    else
      $result = array('success' => TRUE,
        'message' => "Proyecto Exit.");

    echo json_encode($result);
  }
  public function registrarse()
  {
    $data = json_decode($this->input->post('data'), TRUE);
    $result = $this->login_model->fRegistrarse($data);
    echo json_encode($result);
  }
}
