<?php

class CasoModel extends CI_Model
{
  public function fGetCasos($filtro)
  {
    $this->db->select("s.*, fNombrePersona(a.usu_id) AS xxx_abogado, fNombrePersona(c.usu_id) AS xxx_cliente, 
                                IF(s.estado = 'ING', 'Ingresado', 
                                  IF(s.estado = 'ANU', 'Anulado', 
                                    IF(s.estado = 'DIR', 'Direccionado', 
                                      IF(s.estado = 'ASE', 'Asesoría', 
                                        IF(s.estado = 'ACC', 'Acción', ''))))) AS xxx_estado")
      ->join("cliente c", "c.cli_id = s.cli_id", 'inner')
      ->join("abogado a", "a.abo_id = s.abo_id", 'inner');
    if (!empty($filtro))
    {
      $this->db->like("fNombrePersona(a.usu_id)", $filtro, 'both');
      $this->db->or_like("fNombrePersona(c.usu_id)", $filtro, 'both');
      $this->db->or_where("s.nombre", $filtro);
      $this->db->or_where("s.descripcion", $filtro);
      $this->db->or_where("s.numero_caso", $filtro);
    }
    $query = $this->db->get("caso s");
    return $query->result_array();
  }
}