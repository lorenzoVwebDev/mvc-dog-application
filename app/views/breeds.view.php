<?php

class Breedsview {
  //set $result public
  private $result;
  function __construct($properties_array) {
    if (!method_exists('dog_container', 'create_object')) {
      exit;
    }
  }
  
  public function get_select($dog_app) {
    if($dog_app!=false&&file_exists($dog_app)) {
      $breeds=simplexml_load_file($dog_app);
      $json=json_encode($breeds);
      $breeds_array=json_decode($json, true);
      $selectBox="<select name='dog_breed' id='dog_breed'>";
      $selectBox.="<option value='-1' selected>Select a dog breed</option>";
      foreach($breeds_array['breed']as$index=>$value) {
        $selectBox.="<option value='$value'>$value</option>";
      }
      $selectBox.="</select>";
      $this->result=$selectBox;
      return $this->result;
    } else {
      print 'hello';
      throw new Exception('"get_breeds.php" breeds.xml not found');
    }
  }
}

?>