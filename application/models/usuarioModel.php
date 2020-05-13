<?php

class UsuarioModel extends CI_Model
{
  public function fCambiarContrasena($data)
  {
    $verfclave = $this->db->select("IF(clave = MD5('".$data["clave"]."'), 'si', 'no') AS verfclave")
      ->where("usu_id", $this->session->session_user)->get("usuario")->row_array();
    if (!empty($verfclave))
    {
      if ($verfclave["verfclave"] == 'si')
      {
        $clavenueva = $data["xxx_clave_nueva"];
        $this->db->set("clave", md5($clavenueva))->where("usu_id", $this->session->session_user)->update("usuario");
        $correcto = $this->db->trans_status();
      }
      else
      {
        $correcto = false;
      }
    }
    else
    {
      $correcto = false;
    }
    return $correcto;
  }
}