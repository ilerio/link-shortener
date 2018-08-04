<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logger {

  private $CI;
  private $file;

  public function __construct()
  {
    $this->CI =& get_instance();
    $this->CI->load->helper('path');
    $this->file = set_realpath('assets/log/log.txt');
  }
  
  /* 
  Writes the given message to the log file.
  */
  public function write_to_log($msg)
  {
    $msg .= "\n".date('r')."\n\n";
    return (bool) file_put_contents($this->file, $msg, FILE_APPEND);
  }
}