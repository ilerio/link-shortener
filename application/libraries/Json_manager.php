<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Json_manager {

  private $CI;
  private $file;
  private $links;

  function __construct()
  {
    $this->CI =& get_instance();
    $this->CI->load->helper('path');
    $this->CI->load->helper('url');
    $this->CI->load->library('logger');
    $this->file = set_realpath('assets/json/links.json');
    $this->links = json_decode(file_get_contents($this->file));
  }
  
  /* 
  Returns the url for the code provided code
  */
  public function get_url($code)
  {
    $this->CI->benchmark->mark('start');
    $count = 0;

    foreach ($this->links as $key => $value)
    {
      $count++;
      if ($value->code == $code)
      {
        $this->CI->benchmark->mark('end');
        $this->CI->logger->write_to_log("Json_manager > get_url(): \nRan: ".$count." time(s)\nElapsed time: ".$this->CI->benchmark->elapsed_time('start','end')."s");

        return urldecode($value->url);
      }
    }
    return FALSE;
  }

  /* 
  Save the url into the json file
  */
  public function save($url,$code)
  {
    $new = new stdClass();
    $new->url = urlencode($url);
    $new->code = $code;
    $this->links->{$this->get_links_count()} = $new;
    $bool = file_put_contents($this->file, json_encode($this->links));
    return (bool)$bool;
  }

  /* 
  Checks if url already exists in the json file
  */
  public function url_exists($url)
  {
    $url = urlencode($url);

    $this->CI->benchmark->mark('start');
    $count = 0;

    foreach ($this->links as $key => $value)
    {
      if (strcmp($url,$value->url) == 0)
      {
        $this->CI->benchmark->mark('end');
        $this->CI->logger->write_to_log("Json_manager > url_exists(): \nRan: ".$count." time(s)\nElapsed time: ".$this->CI->benchmark->elapsed_time('start','end')."s");

        return TRUE;
      }
    }
    return FALSE;
  }

  /* 
  Checks if code already exists in the json file
  */
  public function code_exists($code)
  {
    $this->CI->benchmark->mark('start');
    $count = 0;

    foreach ($this->links as $key => $value)
    {
      if (strcmp($code,$value->code) == 0)
      {
        $this->CI->benchmark->mark('end');
        $this->CI->logger->write_to_log("Json_manager > code_exists(): \nRan: ".$count." time(s)\nElapsed time: ".$this->CI->benchmark->elapsed_time('start','end')."s");

        return TRUE;
      }
    }
    return FALSE;
  }

  /* 
  Generate and return a randomly generated code
  */
  public function gen_code()
  {
    $this->CI->benchmark->mark('start');

    $count = 0;
    do {
      $code = bin2hex(openssl_random_pseudo_bytes(4));
      $count++;
    } while ($this->code_exists($code));

    $this->CI->benchmark->mark('end');
    $this->CI->logger->write_to_log("Json_manager > gen_code(): \nRan: ".$count." time(s)\nElapsed time: ".$this->CI->benchmark->elapsed_time('start','end')."s");

    return $code;
  }

  /* 
  Returns the code for the code provided url
  */
  public function get_code($url)
  {
    $url = urlencode($url);

    $this->CI->benchmark->mark('start');
    $count = 0;

    foreach ($this->links as $key => $value)
    {
      $count++;
      if ($value->url == $url)
      {
        $this->CI->benchmark->mark('end');
        $this->CI->logger->write_to_log("Json_manager > get_code(): \nRan: ".$count." time(s)\nElapsed time: ".$this->CI->benchmark->elapsed_time('start','end')."s");

        return $value->code;
      }
    }
    return FALSE;
  }

  /* 
  Checks if url is already a shortend one
  */
  public function is_short($url)
  {
    // e.g. "/kazam\.xyz/i"
    return preg_match("/ileri\.pw/i",$url)?true:false;
  }

  /* 
  Returns all links and codes as a JSON object
  */
  public function get_all()
  {
    return $this->links;
  }

  /* 
  Returns the username
  */
  public function get_username()
  {
    $file = set_realpath('assets/json/user.json');
    $user = json_decode(file_get_contents($file));
    return $user[0]->username;
  }

  /* 
  Returns the password
  */
  public function get_hash()
  {
    $file = set_realpath('assets/json/user.json');
    $user = json_decode(file_get_contents($file));
    return $user[0]->hash;
  }

  /* 
  Deletes the given link and code
  */
  public function delete($num)
  {
    unset($this->links->{$num});
    $bool = file_put_contents($this->file, json_encode($this->links));
    return $bool;
  }

  /* 
  Updates the given link and code
  */
  public function update_2($url, $code, $id)
  {
    $this->links->{$id}->url = urlencode($url);
    $this->links->{$id}->code = $code;
    $bool = file_put_contents($this->file, json_encode($this->links));
    return $bool;
  }

  /* 
  Updates the given link
  */
  public function update_1($url, $id)
  {
    $this->links->{$id}->url = urlencode($url);
    $bool = file_put_contents($this->file, json_encode($this->links));
    return $bool;
  }

  /* 
  Returns the number of links in the $this->links variable
  */
  private function get_links_count()
  {
    $count = 0;
    foreach ($this->links as $key => $value) {
      $count++;
    }
    return $count;
  }
}