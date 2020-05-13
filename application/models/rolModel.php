<?php

class RolModel extends CI_Model
{
  public function fGetRoles($filtro)
  {
    $this->db->select("usu_id, rol, IF(rol = 'CLI', 'Cliente', 
                                        IF(rol = 'ADM', 'Administrador', 
                                          IF(rol = 'ABG', 'Abogado', ''))) AS xxx_rol, fNombrePersona(usu_id) AS xxx_nombre_usuario");
    if (!empty($filtro))
    {
      $this->db->like("fNombrePersona(usu_id)", $filtro, 'both');
    }
    $query = $this->db->get("usuario");
    return $query->result_array();
  }
  public function fGetRolesCombo()
  {
    return array(array("id" => 1, "rol" => "CLI", "xxx_rol" => "Cliente"),
      array("id" => 2, "rol" => "ADM", "xxx_rol" => "Administrador"), array("id" => 3, "rol" => "ABG", "xxx_rol" => "Abogado"));
  }
}