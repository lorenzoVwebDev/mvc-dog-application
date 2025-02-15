<?php
class Admin extends Controller {
  public function dashboard($name) {
    $this->view($name);
  } 
}