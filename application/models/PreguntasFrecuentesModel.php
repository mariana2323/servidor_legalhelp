<?php

class PreguntasFrecuentesModel extends CI_Model
{
  public function fGetPreguntasFrecuentes()
  {
    $this->db->select("pre_id, pregunta, respuesta, tes_id");
    return $this->db->get("preguntas_frecuentes")->result_array();
  }
}