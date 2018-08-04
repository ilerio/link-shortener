<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App extends CI_Controller {
  function __construct()
  {
    parent::__construct();
    $this->load->library('json_manager');
    $this->load->helper('url');
  }
  
  public function url($token = NULL)
	{
    if (!is_null($token) && $token != 'null')
    {
      if ($this->json_manager->code_exists($token)) {
        $url = $this->json_manager->get_url($token);
        redirect($url);
      } else {
        show_404();
      }
    } 

    $post = $this->input->post();
    if (isset($post)) 
    {
      $url = trim($post['url']);
      if (empty($url))
      {
        echo "err_no_url";
      } elseif (filter_var($url, FILTER_VALIDATE_URL) === FALSE) {
        echo "err_not_url";
      } elseif ($this->json_manager->is_short($url)) {
        echo "err_is_short";
      } elseif ($this->json_manager->url_exists($url)) {
        $urlcode = base_url($this->json_manager->get_code($url));
        echo $urlcode;
      } else {
        $code = $this->json_manager->gen_code();
        $this->json_manager->save($url,$code);
        $urlcode = base_url().$code;
        echo $urlcode;
      }
    }
  }

  public function test($token)
  {
    if (!is_null($token))
    {
      if ($this->json_manager->code_exists($token)) {
        $url = $this->json_manager->get_url($token);
        redirect($url);
      } else {
        echo $token;
        show_404();
      }
    }
  }
}
