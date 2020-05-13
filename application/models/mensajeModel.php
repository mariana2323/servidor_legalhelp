<?php

class MensajeModel extends CI_Model
{
  public $success = 'success';
  public function fGetListaMensajes($filtro)
  {
    if (!empty($filtro))
    {
      switch ($filtro)
      {
        case 1://Direccionamiento
          $estado = 'DIR';
          break;
        case 2://Asesoría
          $estado = 'ASE';
          break;
        case 3://Acción legal
          $estado = 'ACC';
          break;
        default:
          break;
      }
      $this->db->select("m.*, l.cli_id, fNombrePersona(l.usu_id) AS xxx_nombre_usuario, CONCAT('../servidor_legalhelp/img/', u.imagen) AS xxx_imagen")
        ->join("caso c", "c.cas_id = m.cas_id", 'inner')
        ->join("cliente l", "l.cli_id = c.cli_id", 'inner')
        ->join("usuario u", "u.usu_id = l.usu_id", 'inner')
        ->where("c.estado", $estado)
        ->group_by("c.cas_id");
      $query = $this->db->get("mensaje m")->result_array();
      if (!empty($query))
      {
        return array($this->success => true, "data" => $query);
      }
      else
      {
        return array($this->success => false, "data" => null);
      }
    }
    else
    {
      return array($this->success => true, "data" => null);
    }
  }
  public function fGetMensajes($caso, $tipo_usuario, $ubicacion)
  {
    $estado = '';
    $ususesion = $this->session->session_user;
    if (!empty($ubicacion))
    {
      switch ($ubicacion)
      {
        case 1://Direccionamiento
          $estado = 'DIR';
          break;
        case 2://Asesoría
          $estado = 'ASE';
          break;
        case 3://Acción legal
          $estado = 'ACC';
          break;
        default:
          break;
      }
    }
    $datacaso = $this->db->where("cas_id", $caso)->get("caso")->row_array();
    if (!empty($datacaso))
    {
      if (empty($ubicacion))
      {
        $estado = $datacaso["estado"];
      }
      //se obtiene el nombre de la imagen del abogado:
      $imagenabg = $this->db->select("u.imagen")->where("a.abo_id", $datacaso["abo_id"])
        ->join("usuario u", "u.usu_id = a.usu_id", 'inner')
        ->get("abogado a")->row_array();
      //se obtiene el nombre de la imagen del cliente:
      $imagencli = $this->db->select("u.imagen")->where("c.cli_id", $datacaso["cli_id"])
        ->join("usuario u", "u.usu_id = c.usu_id", 'inner')
        ->get("cliente c")->row_array();
      if (!empty($imagenabg))
      {
        if (empty($imagenabg["imagen"]))
        {
          $imgabg = 'abogado_imagen.svg';
        }
        else
        {
          $imgabg = $imagenabg["imagen"];
        }
      }
      else
      {
        $imgabg = 'abogado_imagen.svg';
      }
      if (!empty($imagencli))
      {
        if (empty($imagencli["imagen"]))
        {
          $imgcli = 'usuario_imagen.svg';
        }
        else
        {
          $imgcli = $imagencli["imagen"];
        }
      }
      else
      {
        $imgcli = 'usuario_imagen.svg';
      }
    }
    else
    {
      $imgabg = 'abogado_imagen.svg';
      $imgcli = 'usuario_imagen.svg';
    }
    if ($tipo_usuario == 'abogado')
    {
      $mensajes = $this->db->where("cas_id", $caso)->where("estado", $estado)->order_by("fecha")
        ->get("mensaje")->result_array();
    }
    else if ($tipo_usuario == 'cliente')
    {
      $verfcaso = $this->db->where("u.usu_id", $ususesion)->where("estado", $estado)
        ->join("cliente c", "c.cli_id = s.cli_id", 'inner')
        ->join("usuario u", "u.usu_id = c.usu_id", 'inner')
        ->get("caso s")->row_array();
      if (!empty($verfcaso))
      {
        $mensajes = $this->db->where("estado", $estado)->order_by("fecha")->get("mensaje")->result_array();
      }
      else
      {
        $mensajes = array();
      }
    }
    if (!empty($mensajes))
    {
      $i = 0;
      foreach ($mensajes as $m)
      {
        if (!empty($m["mensaje_abogado"]))//si hay un mensaje del abogado
        {
          if ($tipo_usuario == 'abogado')
          {
            $mensajes[$i]["class"] = "chat self";
          }
          else
          {
            $mensajes[$i]["class"] = "chat friend";
          }
          $mensajes[$i]["mensaje"] = $m["mensaje_abogado"];
          $mensajes[$i]["imagen"] = $imgabg;
        }
        if (!empty($m["mensaje_cliente"]))//si hay un mensaje del abogado
        {
          if ($tipo_usuario == 'cliente')
          {
            $mensajes[$i]["class"] = "chat self";
          }
          else
          {
            $mensajes[$i]["class"] = "chat friend";
          }
          $mensajes[$i]["mensaje"] = $m["mensaje_cliente"];
          $mensajes[$i]["imagen"] = $imgcli;
        }
        $i++;
      }
    }
    else
    {
      $mensajes = array();
    }
    return $mensajes;
  }
  public function fSendMensaje($caso, $tipo, $mensaje, $ubicacion, $cliid)
  {
    $hoy = date('Y-m-d H:i:s');
    $estado = '';
    $data = array();
    if (!empty($ubicacion))
    {
      switch ($ubicacion)
      {
        case 1://Direccionamiento
          $estado = 'DIR';
          break;
        case 2://Asesoría
          $estado = 'ASE';
          break;
        case 3://Acción legal
          $estado = 'ACC';
          break;
        default:
          break;
      }
    }
    if ($caso !== '0' && $caso !== 0 && $caso !== '')
    {
      if (empty($ubicacion))
      {
        $est = $this->db->where("cas_id", $caso)->get("caso")->row_array();
        $estado = $est["estado"];
      }
      $data = array("men_id" => 0, "cas_id" => $caso, "mensaje_$tipo" => $mensaje, "fecha" => $hoy, "estado" => $estado);
    }
    else
    {
      $idusuario = $this->session->session_user;
      if ($tipo == "cliente")
      {
        $cliente = $this->db->where("usu_id", $idusuario)->get("cliente")->row_array();
        $datacaso = array("cas_id" => 0, "cli_id" => $cliente["cli_id"], "fecha_inicio" => $hoy, "estado" => $estado);
        $this->db->insert("caso", $datacaso);

        if ($this->db->trans_status())
        {
          $caso = $this->db->insert_id();
          $data = array("men_id" => 0, "cas_id" => $caso, "mensaje_$tipo" => $mensaje, "fecha" => $hoy, "estado" => $estado);
        }
      }
      else
      {
        //se busca un caso que se encuentre en la ubicación del proceso indicado y que no haya sido asignado un abogado todavía
        $abogado = $this->db->where("usu_id", $idusuario)->get("abogado")->row_array();
        $datacaso = $this->db->where("estado", $estado)->where("abo_id IS NULL")->where("cli_id", $cliid)->get("caso")->row_array();
        if (!empty($datacaso))
        {
          $this->db->where("cas_id", $datacaso["cas_id"])->set("abo_id", $abogado["abo_id"])->update("caso");
          $data = array("men_id" => 0, "cas_id" => $datacaso["cas_id"], "mensaje_$tipo" => $mensaje, "fecha" => $hoy, "estado" => $estado);
        }
        else
        {
          $data = array();
        }
      }
    }
    if (!empty($data))
    {
      $this->db->insert("mensaje", $data);
      return $this->db->trans_status();
    }
    else
    {
      return false;
    }
  }
}