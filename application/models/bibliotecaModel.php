<?php

class BibliotecaModel extends CI_Model
{
  public function fGetBiblioteca($filtro)
  {
    if (!empty($filtro))
    {
      $this->db->like("nombre", $filtro, 'both');
      $this->db->or_like("descripcion", $filtro, 'both');
    }
    return $this->db->get("biblioteca")->result_array();
  }
}