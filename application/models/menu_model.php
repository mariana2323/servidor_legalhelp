<?php

class menu_model extends CI_Model
{
  public function fGetMenuWin004()
  {
    $res = array(array("id"=>1,"nombre"=>"Asesoría", "imagen"=>"../servidor_legalhelp/img/asesoria.svg"),
                 array("id"=>2, "nombre"=>"Preguntas frecuentes", "imagen"=>"../servidor_legalhelp/img/preguntas_frecuentes.svg"));
    return $res;
  }
  public function fGetMenuWin006()
  {
    $res = array(array("id"=>1,"nombre"=>"1. Direccionar", "imagen"=>"../servidor_legalhelp/img/paso1.svg", "descripcion"=>"Identificar el caso"),
                 array("id"=>2, "nombre"=>"2. Pagar", "imagen"=>"../servidor_legalhelp/img/paso2.svg", "descripcion"=>"Pagar la consultoría"),
                 array("id"=>3, "nombre"=>"3. Asesoría", "imagen"=>"../servidor_legalhelp/img/paso3.svg", "descripcion"=>"Asesoría"),
                 array("id"=>4, "nombre"=>"4. Pagar", "imagen"=>"../servidor_legalhelp/img/paso4.svg", "descripcion"=>"Pagar la acción legal"),
                 array("id"=>5, "nombre"=>"5. Acción legal", "imagen"=>"../servidor_legalhelp/img/paso5.svg", "descripcion"=>"Se lleva a cabo la acción legal"));
    return $res;
  }
  public function fGetMenuWin012()
  {
    $res = array(array("id"=>1,"nombre"=>"Tipo de identificación", "imagen"=>"../servidor_legalhelp/img/tipo_identificacion.svg"),
                array("id"=>2, "nombre"=>"Tipo de tarjeta", "imagen"=>"../servidor_legalhelp/img/tipo_tarjeta.svg"),
                array("id"=>3, "nombre"=>"Tipo de especialidad", "imagen"=>"../servidor_legalhelp/img/tipo_especialidad.svg"),
                array("id"=>4, "nombre"=>"Preguntas frecuentes", "imagen"=>"../servidor_legalhelp/img/preguntas_frecuentes.svg"),
                array("id"=>5, "nombre"=>"Especialidad", "imagen"=>"../servidor_legalhelp/img/especialidad.svg"),
                array("id"=>6, "nombre"=>"Roles", "imagen"=>"../servidor_legalhelp/img/roles.svg"),
                array("id"=>7, "nombre"=>"Abogados", "imagen"=>"../servidor_legalhelp/img/abogados.svg"),
                array("id"=>8, "nombre"=>"Caso", "imagen"=>"../servidor_legalhelp/img/caso.svg"),
                array("id"=>9, "nombre"=>"Biblioteca", "imagen"=>"../servidor_legalhelp/img/biblioteca.svg"));
    return $res;
  }
  public function fGetMenuWin028()
  {
    $res = array(array("id"=>1,"nombre"=>"1. Direccionar", "imagen"=>"../servidor_legalhelp/img/paso1.svg"),
                  array("id"=>2, "nombre"=>"2. Asesoría", "imagen"=>"../servidor_legalhelp/img/paso3.svg"),
                  array("id"=>3, "nombre"=>"3. Acción legal", "imagen"=>"../servidor_legalhelp/img/paso5.svg"),
                  array("id"=>4, "nombre"=>"4. Casos", "imagen"=>"../servidor_legalhelp/img/caso.svg"),
                  array("id"=>5, "nombre"=>"5. Fuentes", "imagen"=>"../servidor_legalhelp/img/biblioteca.svg"));
    return $res;
  }
}