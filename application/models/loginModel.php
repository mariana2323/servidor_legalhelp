<?php

class LoginModel extends CI_Model
{
  public $usu_id = 'usu_id';
  public $emailtxt = 'email';
  public $success = 'success';
  public $usuariotxt = 'usuario';
  public function fLogin($pcUsr, $pcPwd)
  {
    $this->db->select($this->usu_id);
    $this->db->where($this->emailtxt, $pcUsr);
    $this->db->where("clave", md5($pcPwd));
    $query = $this->db->get($this->usuariotxt);

    return $query->row_array();
  }
  public function fLogged($usr)
  {
    $this->db->select("fNombrePersona(usu_id) AS nombre, rol, imagen");
    $this->db->where($this->usu_id, $usr);
    $query = $this->db->get($this->usuariotxt)->row_array();
    if (!empty($query))
    {
      return array($this->success=>true, "nomusr"=>$query["nombre"], $this->usuariotxt=>$usr, "rol"=>$query["rol"], "imagen"=>$query["imagen"]);
    }
    else
    {
      return array($this->success => false);
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
    $data[$this->usu_id] = 0;
    unset($data["xxx_clave"]);
    //se verifica que el correo no este registrado
    $verifica = $this->db->where($this->emailtxt, $data[$this->emailtxt])->get($this->usuariotxt)->row_array();
    if (!empty($verifica))//si es que hay un registro con ese correo
    {
      return array($this->success => false);
    }
    else//si es que no hay otra registro con el mismo correo
    {
      $this->db->insert($this->usuariotxt, $data);
      if ($this->db->trans_status())
      {
        $id = $this->db->insert_id();
        return array($this->success => true, "newId" => $id);
      }
      else
      {
        return array($this->success => false);
      }
    }
  }
}
