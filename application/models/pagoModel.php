<?php

class PagoModel extends CI_Model
{
  public function fHabilitaPago($caso, $data)
  {
    $hoy = date('Y-m-d H:i:s');
    $correcto = null;
    $idusuario = $this->session->session_user;
    //1. comprueba si es que el estado del caso es DIR o ASE
    $datacaso = $this->db->where("cas_id", $caso)->where("estado = 'DIR' OR estado = 'ASE'")->get("caso")->row_array();
    if (!empty($datacaso))//si es que el estado si es DIR o ASE
    {
      //se determina el nuevo estado a usar
      if ($datacaso["estado"] = 'DIR')
      {
        $estado = 'PAS';
      }
      else
      {
        $estado = 'PAC';
      }
      //se actualiza el campo de valor en el caso indicado
      $this->db->where("cas_id", $caso)->set("valor", $data["valor"])->update("caso");
      if ($this->db->trans_status())
      {
        //se crea el pago correspondiente con el cas_id y el valor a pagar
        $estado = $datacaso["estado"];
        if ($estado == 'DIR')
        {
          $descripcion = "Pago por consultoría jurídica";
        }
        else
        {
          $descripcion = 'Pago para llevar a cabo la acción legal';
        }
        if (!empty($data["xxx_iva"]))//si es que si tiene iva seteado
        {
          $iva = ($data["xxx_iva"]) / 100;
        }
        else
        {
          $iva = 0;
        }
        if (!empty($data["xxx_honorario"]))//si es que si tiene honorario seteado
        {
          $honorario = $data["xxx_honorario"];
        }
        else
        {
          $honorario = 0;
        }
        $total = ($data["valor"] + $honorario) * (1 + $iva);
        $datapago = array("pag_id" => 0, "cas_id" => $caso, "estado"=>$estado,"descripcion" => $descripcion, "valor" => $data["valor"],
          "iva" => $iva, "honorario" => $honorario, "total_servicio" => $total, "fecha_creacion" => $hoy, "usuario_crea" => $idusuario);
        $this->db->insert("pago", $datapago);
        if ($this->db->trans_status())
        {
          $idpago = $this->db->insert_id();
          $datadetalleS = array("dpa_id" => 0, "pag_id" => $idpago, "tipo_detalle" => 'S', "valor" => ($data["valor"] + $honorario), "orden" => 1);
          $datadetalleI = array("dpa_id" => 0, "pag_id" => $idpago, "tipo_detalle" => 'I', "valor" => (($data["valor"] + $honorario) * $iva), "porcentaje" => ($iva * 100), "orden" => 2);
          $datadetalleT = array("dpa_id" => 0, "pag_id" => $idpago, "tipo_detalle" => 'T', "valor" => $total, "orden" => 3);
          $this->db->insert("detalle_pago", $datadetalleS);
          if ($this->db->trans_status())
          {
            $this->db->insert("detalle_pago", $datadetalleI);
            if ($this->db->trans_status())
            {
              $this->db->insert("detalle_pago", $datadetalleT);
              if ($this->db->trans_status())
              {
                //actualiza el caso con el estado nuevo
                $this->db->where("cas_id", $caso)->set("estado", $estado)->update("caso");
                if ($this->db->trans_status())
                {
                  $correcto = true;
                }
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