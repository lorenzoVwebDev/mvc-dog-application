<?php
class Dog {

  function insertNewDog() {
    try {
      
      if((isset($_POST['dog_app']))) {
        if (isset($_POST['dog_name'])&&isset($_POST['dog_weight'])&&isset($_POST['dog_breed'])&&isset($_POST['dog_color'])) {
          $container=new Dog_container(filter_var($_POST['dog_app'], FILTER_SANITIZE_FULL_SPECIAL_CHARS));
          if (isset($container)) {
            $dog_name=filter_var($_POST['dog_name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $dog_color=filter_var($_POST['dog_color'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $dog_weight=filter_var($_POST['dog_weight'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $dog_breed=filter_var($_POST['dog_breed'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
            $properties=array(
              $dog_name,
              $dog_breed,
              $dog_color,
              $dog_weight
            );
            //dog properties
            $lab = $container->create_object($properties);
          } else {
            throw new Exception('"dog_interface.php" Dog_container instance not created');
          }
      
          if ($lab != false) {
            error_check_dog_app($lab);
            get_properties($lab);
          } else {
            throw new Exception('"dog_interface.php" dog not created');
          }
        } else {
          print "<p>Missing or invalid parameters. Please go back to the dog home page to enter valid information. <br/>";
          print "<a href='dog.html'>Dog Creation Page<a/>";
        }
      } else {
        throw new Exception('request not valid');
        
      } 
      } catch (Exception $e) {
        require_once(__DIR__ ."//..//models//logs.model.php");
        $exception = new Logs_model($e->getMessage(), 'exception');
        $last_log_message = $exception->logException();
        unset($exception);
        $exceptionCode = $e->getCode();
        if ($exceptionCode === 500) {
          http_response_code(500);
          header("Content-Type: text/plain");
          echo "Error 500: We are sorry, we are going to resolve the issue as soon as possible";
        }
      } 
  }

  function getBreeds() {
    try {
      if (isset($_GET['type'])) {
        $selectBox_request=$_GET['type'];
        $container=new Dog_container($selectBox_request);
        $breeds=$container->create_object($selectBox_request);
    
        if ($breeds!=false) {
          $properties=__DIR__."..//config//breeds.xml";
          $selectBox=$breeds->get_select($properties);
          if ($selectBox != strip_tags($selectBox)) {
            http_response_code(200);
            header('Content-Type: text/html');
            echo $selectBox;
          } else {
            throw new Exception('breeds html not created', 500)
          }
        } else {
          throw new Exception('breeds file not found', 500);  
        }
      } else {
        throw new Exception('bad request', 401);
      }
    } catch (Exception $e) {
      require_once(__DIR__ ."//..//models//logs.model.php");
      $exception = new Logs_model($e->getMessage(), 'exception');
      $last_log_message = $exception->logException();
      unset($exception);
      $exceptionCode = $e->getCode();
      if ($exceptionCode >= 500) {
        http_response_code(500);
        header("Content-Type: text/plain");
        echo "Error 500: We are sorry, we are going to resolve the issue as soon as possible";
      } else if ($exceptionCode >= 400 && $exceptionCode < 500) {
        http_response_code(401);
        header("Content-Type: text/plain");
        echo "Requested file must be specified";
      }
    }
  }

}

