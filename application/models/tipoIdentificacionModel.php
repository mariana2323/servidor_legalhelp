<?php

class TipoIdentificacionModel extends CI_Model
{
  public function fGetTipoIdentificacion()
  {
    $query = $this->db->select("tid_id, nombre")->get("tipo_identificacion");
    return $query->result_array();
  }
}