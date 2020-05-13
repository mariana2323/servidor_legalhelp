<?php

class TipoTarjetaModel extends CI_Model
{
  public function fGetTipoTarjeta()
  {
    $query = $this->db->select("tta_id, nombre")->get("tipo_tarjeta");
    return $query->result_array();
  }
}