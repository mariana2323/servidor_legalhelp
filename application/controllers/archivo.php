<?php

class Archivo extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->helper('file');
    $this->load->model("abogado_model");
    $this->load->model("general_model");
  }

  public function saveImage()
  {
    $file_name = 'file_name';
    $upl = 'upload_data';
    $id = $this->input->post('id');
    $tabla = $this->input->post('tabla');
    $correcto = true;
    $textoError = '';
    $data = json_decode($this->input->post('data'), TRUE);
    $config['upload_path'] = '../servidor_legalhelp/img';
    switch ($tabla)
    {
      case "usuario":
        $nombreImagen = $tabla . '_id' . $id;
        $config['allowed_types'] = 'jpg|png';
        break;
      case "biblioteca":
        $nombreImagen = $tabla . '_id' . $id;
        $config['allowed_types'] = 'docx|pdf';
        break;
      default:
        break;
    }

    $config['max_size'] = 2048;
    $config[$file_name] = $nombreImagen;
    $this->load->library('upload', $config);
    $path = $config['upload_path'];
    if (!$this->upload->do_upload('xxx_archivo'))
    {
      $correcto = false;
      $textoError = strip_tags($this->upload->display_errors());
      $uploadData = null;
    }
    else
    {
      $uploadData = array($upl => $this->upload->data());
      $files = get_filenames('../servidor_legalhelp/img/');
      //bucle para sobreescritura de archivo para un registro
      for ($i = 0; $i < count($files); $i++)
      {
        $pos = strpos($files[$i], $nombreImagen);
        if ($pos !== false && $files[$i] != $uploadData[$upl][$file_name])
        {
          unlink('../servidor_legalhelp/img/' . $files[$i]);
        }
      }
      switch ($tabla)
      {
        case "usuario":
          $data["imagen"] = $uploadData[$upl][$file_name];
          $data["usu_id"] = $id;
          $campoid = "usu_id";
          break;
        case "biblioteca":
          $data["archivo"] = $uploadData[$upl][$file_name];
          $data["bib_id"] = $id;
          $campoid = "bib_id";
          break;
        default:
          break;
      }
      if ($correcto)
      {
        $result = $this->general_model->fGrdSave($tabla, $campoid, $data);
        $correcto = $result['success'];
        $textoError = $result['error'];
      }
    }
    echo json_encode(array('success' => $correcto, 'error' => $textoError, "upload_data" => $uploadData, "data" => $data, 'path' => $path));
  }

}