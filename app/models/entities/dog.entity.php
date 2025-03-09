<?php 
class Dog_entity {
  //Properties IMPORTANT (set the properties private after the development process)
  private $dog_name = "no name";
  private $dog_breed = "no breed";
  private $dog_color = "no color";
  private $dog_weight = 0;
  private $error_message = "??";
  private $allowed_colors = array (
    'Brown',
    'Black',
    'Yellow',
    'White',
    'Mixed'
  );
  //Constructor
  function __construct($properties_array) {
    $error_name = $this->set_dog_name($properties_array['dogname']) == true ? 'true,' : 'false,';
    $error_breed = $this->set_dog_breed($properties_array['dogbreed']) == true ? 'true,' : 'false,';
    $error_color = $this->set_dog_color($properties_array['dogcolor']) == true ? 'true,' : 'false,';
    $error_weight = $this->set_dog_weight($properties_array['dogweight']) == true ? 'true,' : 'false,';

    $this->error_message = $error_name.$error_breed.$error_color.$error_weight;
  }

  public function insert_data($type) {

    $container = new Dog_container('dog_data_model_mysql');
    $data = $container->create_object();
    $methods_array = get_class_methods($data);
    $last_position = count($methods_array) - 2;
    $method_name = $methods_array[$last_position];
    $records_array = array(array(
      'dogname' => $this->dog_name,
      'dogbreed' => $this->dog_breed,
      'dogcolor' => $this->dog_color,
      'dogweight' => $this->dog_weight
    ));
    $newTaskIndex = $data->$method_name($type, $records_array); 
    unset($data);
    return $newTaskIndex;
}
  //returns the error message
  public function to_string() {
    return $this->error_message;
  }
  //setMethods
  public function set_dog_name(string $value):bool {
    $error_message = true;
    (ctype_alpha($value) && (strlen($value) <= 20)) ? $this->dog_name = $value : $error_message = false;
    return $error_message;
  }

  public function set_dog_weight(int|float $value):bool {
    $error_message = true;
    (is_numeric($value)&&($value>0&&$value<=120)) ? $this->dog_weight=$value:$error_message=false;
    return $error_message;
  }

  public function set_dog_breed(string $value):bool {
    $error_message= true;
    $breedBool = $this->validator_breed($value);
    $ctypeBool = ctype_alpha(str_replace(' ', '', $value));
    ($ctypeBool && $breedBool) ? $this->dog_breed = $value : $error_message=false;
    return $error_message;
  }

  public function set_dog_color($value) {
    $error_message = true;
    $colors_array=$this->allowed_colors;

    foreach($colors_array as $colors) {
      if ((strcasecmp($value, $colors)==0)&&(strlen($value)<=15)&&ctype_alpha($value)) {
        $this->dog_color=$value;
        return $error_message;
      }
    }
    $error_message=false;
    return $error_message;
  }

  //breed validator method

  private function validator_breed($string) {
  
    if (file_exists(__DIR__."//..//..//config//breeds.xml")) {
      $breed_xml=simplexml_load_file(__DIR__."//..//..//config//breeds.xml");
      $xmltext=$breed_xml->asXML();
      if(!stristr($xmltext, $string)) {
        return false;
      } else {
        return true;
      }
    } else {
      throw new Exception('breeds.xml not found', 500);
    }
  }

  function get_dog_name() {
    return $this->dog_name;
  }

  function get_dog_weight() {
    return $this->dog_weight;
  }

  function get_dog_breed() {
    return $this->dog_breed;
  }

  function get_dog_color() {
    return $this->dog_color;
  }

  function get_properties() {
    return "$this->dog_name"." "."$this->dog_weight"." "."$this->dog_breed"." "."$this->dog_color.";
  }
  
}
