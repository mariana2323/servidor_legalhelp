<?php

class Detalle_pago extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model("detalle_pago_model");
    $this->load->helper('file');
  }

  public function getDetallePago()
  {
    $result = $this->detalle_pago_model->fGetDetallePago();
    if (!empty($result))
    {
      //$result1 = (array) $result;
      /*$i = 0;
      foreach ($result as $t)
      {
        $result[$i]["xxx_detalle"] = mb_convert_encoding($t["xxx_detalle"], 'UTF-8', 'UTF-8');
        $result[$i]["dpa_id"] = mb_convert_encoding($t["dpa_id"], 'UTF-8', 'UTF-8');
        $result[$i]["pag_id"] = mb_convert_encoding($t["pag_id"], 'UTF-8', 'UTF-8');
        $result[$i]["tipo_detalle"] = mb_convert_encoding($t["tipo_detalle"], 'UTF-8', 'UTF-8');
        $result[$i]["valor"] = mb_convert_encoding($t["valor"], 'UTF-8', 'UTF-8');
        $result[$i]["porcentaje"] = mb_convert_encoding($t["porcentaje"], 'UTF-8', 'UTF-8');
        $result[$i]["orden"] = mb_convert_encoding($t["orden"], 'UTF-8', 'UTF-8');
        $i++;
      }*/
      $r = array("success" => true, "data" => $result);
    }
    else
      $r = array("success" => false);


    echo json_encode($r);
    //echo json_last_error();
  }
}