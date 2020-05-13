<?php

class biblioteca_model extends CI_Model
{
  public function fGetBiblioteca($filtro)
  {
    if (!empty($filtro))
    {
      $this->db->like("nombre", $filtro, 'both');
      $this->db->or_like("descripcion", $filtro, 'both');
    }
    $query = $this->db->get("biblioteca")->result_array();
    //echo $this->db->last_query();
    return $query;
  }
}