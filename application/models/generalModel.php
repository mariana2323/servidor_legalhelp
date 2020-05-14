<?php

class GeneralModel extends CI_Model
{
  public function fGrdSave($tabla, $idcampo, $data)
  {
    $hoy = date('Y-m-d H:i:s');
    $usu_id = 'usu_id';
    $tar_id = 'tar_id';
    $abogado = 'abogado';
    $estadotxt = 'estado';
    $abo_id = 'abo_id';
    $correcto = true;
    $error = '';
    $this->db->trans_begin();
    if (isset($data[$idcampo]))
    {
      $id = $data[$idcampo];
    }
    else
    {
      $id = '';
    }
    $asso = array_keys($data);
    foreach ($asso as $a)
    {
      //Quita los valores vacíos del array de datos para que no se guarden vacíos y no den errores de FKs
      if (empty($data[$a]) && $a != $idcampo)
      {
        $data[$a] = null;
      }
      $marca2 = substr($a, 0, 4);
      if ($marca2 == "xxx_")
      {
        unset($data[$a]);
      }
    }
    $this->db->where($idcampo, $id);
    $cuantos = $this->db->get($tabla)->num_rows();
    $operacion = ($cuantos > 0) ? 'UPD' : 'INS';

    //AQUI SE REALIZA EL INSERT O EL UPDATE
    if ($operacion == 'INS')
    {
      //Si la tabla tiene auditoria coloca en el vector de datos el usuario y la fecha de creación
      $data["usuario_crea"] = $this->session->userdata('session_user');
      $data["fecha_creacion"] = $hoy;
      $this->db->insert($tabla, $data);
      $correcto = $this->db->trans_status();
      if ($correcto)
      {
        if (empty($id))
        {
          $newId = $this->db->insert_id();
        }
        else
        {
          $newId = $id;
        }
        //CASO ESPECIAL
        if ($tabla == 'tarjeta')
        {
          $this->db->where($usu_id, $this->session->session_user)->set($tar_id, $newId)->update("cliente");
          $correcto = $this->db->trans_status();
        }
      }
    } //Si existe el registro actualiza
    else
    {
      //Si la tabla tiene auditoria coloca en el vector de datos el usuario y la fecha de modificación
      $data["usuario_modifica"] = $this->session->userdata('session_user');
      $data["fecha_modificacion"] = $hoy;
      $this->db->where($idcampo, $id);
      $this->db->update($tabla, $data);
      $correcto = $this->db->trans_status();
      if ($correcto)
      {
        $newId = $id;
      }
    }
    if ($correcto)
    {
      //casos especiales despues de la inserción o actualización
      if ($tabla == 'usuario' && $operacion == 'UPD' && isset($data["rol"]) && $data["rol"] == 'ABG')//Si se guardó a un abogado se debe crear un registro
      {
        //se verifica si ya existe creado el abogado para ese usuario
        $verificaabg = $this->db->where($usu_id, $data[$idcampo])->get($abogado)->row_array();
        if (!empty($verificaabg))//ya existe el abogado, por lo tanto se cambia el estado a 'ACT'
        {
          $this->db->set($estadotxt, 'ACT')->where($abo_id, $verificaabg[$abo_id])->update($abogado);
          $correcto = $this->db->trans_status();
        }
        else
        {
          $dataabg = array($abo_id => 0, $usu_id => $data[$idcampo], $estadotxt => 'ACT', 'imagen' => 'usuario_imagen2.svg');
          $this->db->insert($abogado, $dataabg);
          $correcto = $this->db->trans_status();
        }
      }
      else
      {
        //si existe un registro con estado activado debe desactivarse
        $verificaabg = $this->db->where($usu_id, $data[$idcampo])->get($abogado)->row_array();
        if (!empty($verificaabg))//ya existe el abogado, por lo tanto se cambia el estado a 'INA'
        {
          $this->db->set($estadotxt, 'INA')->where($abo_id, $verificaabg[$abo_id])->update($abogado);
          $correcto = $this->db->trans_status();
        }
      }
    }
    if ($correcto)
    {
      $this->db->trans_commit();
    }
    else
    {
      $error = "Ha ocurrido un error.";
      $this->db->trans_rollback();
    }
    return array('success' => $correcto,
                 'newId'   => $newId,
                 'error'   => $error);
  }

  public function fGrdDelete($tabla, $idcampo, $data)
  {
    $this->db->trans_begin();
    $id = $data[$idcampo];
    $this->db->where($idcampo, $id);
    $this->db->delete($tabla);
    if ($this->db->trans_status())
    {
      $correcto = true;
      $this->db->trans_commit();
    }
    else
    {
      $correcto = false;
      $this->db->trans_rollback();
    }
    return array('success' => $correcto);
  }

  public function fReadForma($id, $tabla, $idcampo)
  {
    $tar_id = 'tar_id';
    switch ($tabla)
    {
      case 'caso':
        $this->db->select("x.*, fNombrePersona(a.usu_id) AS xxx_abogado, fNombrePersona(c.usu_id) AS xxx_cliente, 
                                IF(x.estado = 'ING', 'Ingresado', 
                                  IF(x.estado = 'ANU', 'Anulado', 
                                    IF(x.estado = 'DIR', 'Direccionado', 
                                      IF(x.estado = 'ASE', 'Asesoría', 
                                        IF(x.estado = 'ACC', 'Acción', ''))))) AS xxx_estado")
          ->join("cliente c", "c.cli_id = x.cli_id", 'inner')
          ->join("abogado a", "a.abo_id = x.abo_id", 'left');
        break;
      case 'tarjeta':
        $tarjeta = $this->db->select($tar_id)->where("usu_id", $this->session->session_user)->get("cliente")->row_array();
        if (!empty($tarjeta))
        {
          $id = $tarjeta[$tar_id];
        }
        else
        {
          $id = 0;
        }
        break;
      default:
        break;
    }
    return $this->db->where("x.$idcampo", $id)->get("$tabla x")->row_array();
  }
}