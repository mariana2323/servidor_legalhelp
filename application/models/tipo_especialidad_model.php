<?php

class tipo_especialidad_model extends CI_Model
{
  public function fGetTipoEspecialidades()
  {
    $this->db->select("tes_id, nombre, descripcion, CONCAT('../servidor_legalhelp/img/', imagen) AS imagen");
    $query = $this->db->get("tipo_especialidad");

    return $query->result_array();
  }
}