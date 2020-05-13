<?php

class AbogadoModel extends CI_Model
{
  public function fGetAbogados()
  {
    $query = $this->db->select("a.*, CONCAT('../servidor_legalhelp/img/', u.imagen) AS xxx_imagen, 
    fNombrePersona(a.usu_id) AS xxx_nombre_usuario")->join("usuario u", "u.usu_id = a.usu_id", "inner")->get("abogado a");
    return $query->result_array();
  }

  public function fGetEstadosAbogado()
  {
    return array(array("id" => 'ACT', "nombre" => 'Activo'), array("id" => 'INA', "nombre" => 'Inactivo'));
  }
}