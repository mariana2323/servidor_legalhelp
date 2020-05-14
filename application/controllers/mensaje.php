<?php

class Mensaje extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model("MensajeModel");
    $this->load->model("GeneralModel");
  }

  public function getListaMensajes()
  {
    $filtro = $this->input->get('filtro');
    $result = $this->MensajeModel->fGetListaMensajes($filtro);
    echo json_encode($result);
  }
  public function getMensajes()
  {
    $caso = $this->input->post('caso');
    $ubicacion = $this->input->post('ubicacion');
    $tipo_usuario = $this->input->post('tipo_usuario');
    // Datos del reporte
    $d = $this->MensajeModel->fGetMensajes($caso, $tipo_usuario, $ubicacion);
    $datos['data'] = $d;
    if (!empty($d))
    {
      $caso = $d[0]["cas_id"];
    }
    else
    {
      $caso = '0';
    }
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
    $res = $this->MensajeModel->fSendMensaje($caso, $tipo, $mensaje, $ubicacion, $cliid);
    $r = array('success' => $res);
    echo json_encode($r);
  }
}