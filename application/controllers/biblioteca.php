<?php

class Biblioteca extends CI_Controller
{
  public $success = 'success';
  public function __construct()
  {
    parent::__construct();
    $this->load->model("BibliotecaModel");
    $this->load->model("GeneralModel");
  }

  public function getBiblioteca()
  {
    $filtro = $this->input->get('filtro');
    $result = $this->BibliotecaModel->fGetBiblioteca($filtro);
    if (!empty($result))
    {
      $r = array($this->success => true, "data" => $result);
    }
    else
    {
      $r = array($this->success => false);
    }
    echo json_encode($r);
  }
  public function saveBiblioteca()
  {
    $data = json_decode($this->input->post('data'), TRUE);
    $res = $this->GeneralModel->fGrdSave("biblioteca", "bib_id", $data);
    $result = $res[$this->success];
    $newId = $res['newId'];
    $error = $res['error'];
    if ($result)
    {
      $r = array($this->success => true, "newId" => $newId);
    }
    else
    {
      $r = array($this->success => false,"error" => $error);
    }
    echo json_encode($r);
  }
  public function deleteBiblioteca()
  {
    $data = json_decode($this->input->post('data'), TRUE);
    $res = $this->GeneralModel->fGrdDelete("biblioteca", "bib_id", $data);
    echo json_encode(array($this->success => $res[$this->success]));
  }
}