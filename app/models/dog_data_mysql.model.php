<?php

class Dog_data {
  use Database;
  public $dogs_array = array();
  public $username = '';

  function __construct() {
      $this->username = $_SESSION['username'];
      $query_string = 'SELECT * FROM '.$this->username;
      $array = $this->query($query_string);
      $this->dogs_array = $array;
  } 

  function __destruct() {
/*     show($this->dogs_array); */
    $mysqli = new mysqli(DBHOST, DBUSER, DBPASSWORD, DBNAME);

    if ($mysqli->connect_errno) {
      throw new Exception("MYSQL connection error: ".$mysqli->connect_error, 500);
    }

    if (
      !$mysqli->query("DROP TABLE IF EXISTS ".$_SESSION['username']."_dogs") ||
      !$mysqli->query("CREATE TABLE IF NOT EXISTS ".$_SESSION['username']."_dogs (
        dogname varchar(20), 
        dogbreed varchar(100), 
        dogcolor enum('Brown', 'Black', 'Yellow', 'White', 'Mixed'), 
        dogweight integer NOT NULL CHECK (dogweight > 0 AND dogweight <= 120 )
      )") 
    ) {
      throw new Exception("Table can't be created or deleted".$mysqli->error, 500);
    }

    foreach ($this->dogs_array as $array_key=>$array_value) {
        $dogname = $array_value['dogname'];
        $dogbreed = $array_value['dogbreed'];
        $dogcolor = $array_value['dogcolor'];
        $dogweight = $array_value['dogweight'];

        $query_string = "
          INSERT INTO ".$_SESSION['username']."_dogs (dogname, dogbreed, dogcolor, dogweight) VALUES (
            '$dogname',
            '$dogbreed',
            '$dogcolor',
            $dogweight
            )
          ";
        if (!$mysqli->query($query_string)) {
          throw new Exception("Can't add new records: ". $mysql->error, 500);
        }  
    }

    $mysqli->close(); 
  }

  function createRecord($records_array) {
    $dogs_array_size = count($this->dogs_array);

    for ($J=0;$J<count($records_array);$J++) {
      $this->dogs_array[$dogs_array_size+$J] = $records_array[$J];
    }
    return $newTaskIndex = count($this->dogs_array)-1;
  }

  function readRecord($recordNumber) {
    if ($recordNumber === 'ALL') {
      return $this->dogs_array;
    } else {
      return $this->dogs_array[$recordNumber];
    }
  }

  function updateRecords($records_array) {

    foreach ($records_array as $records => $record_value) {

      $this->dogs_array[$records] = $records_array[$records];
    }
  }

  function deleteRecord($recordNumber) {
    $oldArray = $this->dogs_array;
    foreach ($this->dogs_array as $index=>&$dog_value) {
      $this->dogs_array[$recordNumber] = $this->dogs_array[$recordNumber+1];
    }
    unset($this->dogs_array[count($this->dogs_array)-1]);
    $newArray = $this->dogs_array;

    if (!($oldArray[$recordNumber+1] == $newArray[$recordNumber])) {
      throw new Exception('deleteRecord is not working properly', 500);
    } 
  }

  function processRecords(string $crud_type, array|int|string $records_value) {

    switch ($crud_type) {
      case "insert":
        return $this->createRecord($records_value);
        break;
      case "select":
        return $this->readRecord($records_value);
        break;
      case "update":
        $this->updateRecords($records_value);
        break;
      case "delete":
        return $this->deleteRecord($records_value);
        break;
      default:
        throw new Exception("Invalid CRUD operation type: $crud_type", 401);
    }
  }
}