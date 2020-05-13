<?php

class Menu extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    /*if (!$this->input->is_ajax_request())
    {
      show_404();
    }*/
    $this->load->model("menu_model");
  }
  public function getMenuWin004(){
    $result = $this->menu_model->fGetMenuWin004();
    if (!empty($result))
      $r = array("success"=>true, "data"=>$result);
    else
      $r = array("success"=> false);
    echo json_encode($r);
  }
  public function getMenuWin006(){
    $result = $this->menu_model->fGetMenuWin006();
    if (!empty($result))
      $r = array("success"=>true, "data"=>$result);
    else
      $r = array("success"=> false);
    echo json_encode($r);
  }
  public function getMenuWin012(){
    $result = $this->menu_model->fGetMenuWin012();
    if (!empty($result))
      $r = array("success"=>true, "data"=>$result);
    else
      $r = array("success"=> false);
    echo json_encode($r);
  }
  public function getMenuWin028(){
    $result = $this->menu_model->fGetMenuWin028();
    if (!empty($result))
      $r = array("success"=>true, "data"=>$result);
    else
      $r = array("success"=> false);
    echo json_encode($r);
  }
}