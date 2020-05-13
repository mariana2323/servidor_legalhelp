<?php

class Mensaje extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model("mensaje_model");
    $this->load->model("general_model");
  }

  public function getListaMensajes()
  {
    $filtro = $this->input->get('filtro');
    $result = $this->mensaje_model->fGetListaMensajes($filtro);
    echo json_encode($result);
  }
  public function getMensajes()
  {
    $caso = $this->input->post('caso');
    $ubicacion = $this->input->post('ubicacion');
    $tipo_usuario = $this->input->post('tipo_usuario');
    //$datos = array();
    // Datos del reporte
    $d = $this->mensaje_model->fGetMensajes($caso, $tipo_usuario, $ubicacion);
    $datos['data'] = $d;
    if (!empty($d))
      $caso = $d[0]["cas_id"];
    else
      $caso = '0';
    /*$datos['cabecera'] = h_cabecera_reporte($this->session->session_nick);
    $datos['tiporeporte'] = $tipo;
    $datos['idioma'] = $this->general->fObtenerIdioma($this->session->userdata('session_lang'));*/
    //Imprime reporte
    $result = $this->load->view('mensajes_view', $datos, TRUE);
    $r = array('data' => $result, 'caso'=>$caso,
      'success' => TRUE);
    echo json_encode($r);
  }
  public function sendMensaje()
  {
    $caso = $this->input->post('caso');
    $ubicacion = $this->input->post('ubicacion');
    $tipo = $this->input->post('tipo');
    $mensaje = $this->input->post('mensaje');
    $cliid = $this->input->post('cliente');
    $res = $this->mensaje_model->fSendMensaje($caso, $tipo, $mensaje, $ubicacion, $cliid);
    $r = array('success' => $res);
    echo json_encode($r);
  }
}