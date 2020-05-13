<?php

class LoginModel extends CI_Model
{
  public function fLogin($pcUsr, $pcPwd)
  {
    $this->db->select("usu_id");
    $this->db->where("email", $pcUsr);
    $this->db->where("clave", md5($pcPwd));
    $query = $this->db->get("usuario");

    return $query->row_array();
  }
  public function fLogged($usr)
  {
    $this->db->select("fNombrePersona(usu_id) AS nombre, rol, imagen");
    $this->db->where("usu_id", $usr);
    $query = $this->db->get("usuario")->row_array();
    if (!empty($query))
    {
      return array("success"=>true, "nomusr"=>$query["nombre"], "usuario"=>$usr, "rol"=>$query["rol"], "imagen"=>$query["imagen"]);
    }
    else
    {
      return array("success" => false);
    }
  }
  public function fLogOut()
  {
    $bdd = $this->session->session_bdd;
    $this->db->where("sesion_logeo", session_id());
    $this->db->where("id_usuario_logeo", $this->session->session_user);
    $this->db->set("fecha_fin_logeo", date('Y-m-d H:i:s'));
    return $this->db->update("$bdd.seg_logeo_usuario");
  }
  public function fRegistrarse($data)
  {
    $data["usu_id"] = 0;
    unset($data["xxx_clave"]);
    //se verifica que el correo no este registrado
    $verifica = $this->db->where("email", $data["email"])->get("usuario")->row_array();
    if (!empty($verifica))//si es que hay un registro con ese correo
    {
      return array("success" => false);
    }
    else//si es que no hay otra registro con el mismo correo
    {
      $this->db->insert("usuario", $data);
      if ($this->db->trans_status())
      {
        $id = $this->db->insert_id();
        return array("success" => true, "newId" => $id);
      }
      else
      {
        return array("success" => false);
      }
    }
  }
}
