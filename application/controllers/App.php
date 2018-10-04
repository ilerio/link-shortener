<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App extends CI_Controller {
  function __construct()
  {
    parent::__construct();
    $this->load->library('json_manager');
    $this->load->helper('url');
    $this->load->library('form_validation');
  }
  
  public function url($code)
	{
    if ($this->json_manager->code_exists($code)) {
      $url = $this->json_manager->get_url($code);
      redirect($url);
    } else {
      show_404();
    }
  }

  public function save()
  {
    $post = $this->input->post();
    if (isset($post)) {
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

  public function login()
  {
    $this->form_validation->set_rules('un','Username','required');
    $this->form_validation->set_rules('pw','Password','required');

    if (!$this->form_validation->run()) {
      $this->load->view('login');
    } else {
      $username = $this->input->post('un');
      $password = $this->input->post('pw');

      $db_un = $this->json_manager->get_username();
      $hash = $this->json_manager->get_hash();

      $res_un = ($username === $db_un)?TRUE:FALSE;
      $res_pw = password_verify($password, $hash);
      
      if ($res_un && $res_pw) {
        $_SESSION['logged_in'] = TRUE;
        redirect('dash');
      } else {
        $this->load->view('login', ['error' => 'Incorrect username or password.']);
      }
    }
  }

  public function logout()
  {
    $this->isLoggedIn();
    unset($_SESSION['logged_in']);
    redirect('login');
  }

  public function dash()
  {
    $this->isLoggedIn();
    $links = ["links" => $this->json_manager->get_all()];
    $this->load->view('dash', $links);
  }

  public function update()
  {
    $this->isLoggedIn();
    $post = $this->input->post();
    if(isset($post)) {
      $url = $post['url'];
      $code = $post['code'];
      $id = $post['id'];
      if ($this->json_manager->url_exists($url) && $this->json_manager->code_exists($code)) {
        echo "err_no_change";
      } elseif ($this->json_manager->code_exists($code)) {
        $this->json_manager->update_1($url, $id);
        echo "err_code_exists";
      } else {
        $res = $this->json_manager->update_2($url, $code, $id);
        if ($res == TRUE) {
          echo 'success';
        } else {
          echo 'fail';
        }
      }
    }
  }

  public function delete()
  {
    $this->isLoggedIn();
    $post = $this->input->post();
    if (isset($post)) {
      $num = $post['num'];
      $res = $this->json_manager->delete($num);
      if ($res == TRUE) {
        echo 'success';
      } else {
        echo 'fail';
      }
    }
  }

  public function test()
  {
    $url = "http://url.url";
    $code = $this->json_manager->gen_code();
    $id = 0;
    echo '<pre>';
    if($this->json_manager->update($url,$code,$id))
      echo "true";
    else echo "false";
    echo '</pre>';
  }

  private function isLoggedIn()
  {
    if (!$this->session->userdata('logged_in')) {
      redirect('login');
    }
  }
}
