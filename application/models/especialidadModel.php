<?php

class EspecialidadModel extends CI_Model
{
  public function fGetEspecialidades()
  {
    $this->db->select("esp_id, nombre, descripcion, tes_id");
    $query = $this->db->get("especialidad");

    return $query->result_array();
  }
}