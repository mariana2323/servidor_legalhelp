<?php

class detalle_pago_model extends CI_Model
{
  public function fGetDetallePago()
  {
    $idusuario = $this->session->session_user;
    $result = array();
    //1. se busca el caso
    $caso = $this->db->where("cli_id = fGetClienteOrAbogado($idusuario, 'CLI')")->where("estado = 'PAS' OR estado = 'PAC'")->get("caso")->row_array();
    if (!empty($caso))
    {
      //2. se busca el pago
      $pago = $this->db->where("cas_id", $caso["cas_id"])->where("estado", $caso["estado"])->get("pago")->row_array();
      if (!empty($pago))
      {
        //3. se buscan los detalles
        /*$result = $this->db->select("'Prueba' AS xxx_detalle")->where("pag_id", $pago["pag_id"])->get("detalle_pago")->result_array();*/
        $result = array(array("xxx_detalle"=>'ssd'), array("xxx_detalle"=>'jhhj'));
      }
    }
    return $result;
  }
}