<?php

class preguntas_frecuentes_model extends CI_Model
{
  public function fGetPreguntasFrecuentes()
  {
    $this->db->select("pre_id, pregunta, respuesta, tes_id");
    $query = $this->db->get("preguntas_frecuentes")->result_array();
    return $query;
  }
}