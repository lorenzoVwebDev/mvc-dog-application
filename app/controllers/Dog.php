<?php
class Dog {
  use Jasonwebtoken;

  function dogcrud($type) {
    $this->requireAuth();
    try {
      $crudArray = array (
        'insert',
        'select',
        'update',
        'delete'
      );

      $needle = in_array(filter_var($type, FILTER_SANITIZE_FULL_SPECIAL_CHARS), $crudArray);

      if((isset($_POST['dog_app']))&&$needle&&$type==='insert') {
        if (isset($_POST['dog_name'])&&isset($_POST['dog_weight'])&&isset($_POST['dog_breed'])&&isset($_POST['dog_color'])) {

            $dog_name=filter_var($_POST['dog_name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $dog_color=filter_var($_POST['dog_color'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $dog_weight=filter_var($_POST['dog_weight'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $dog_breed=filter_var($_POST['dog_breed'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            if ($dog_breed != -1) {
              $properties=array(
                'dogname' => $dog_name,
                'dogbreed' => $dog_breed,
                'dogcolor' => $dog_color,
                'dogweight' => $dog_weight
              );

              $model = new Model();
              $inserted = $model->dogCrud($properties, $type);
              if (is_array($inserted)) {
                http_response_code(200);
                header('Content-Type: application/json');
                $json = json_encode($inserted);
                echo $json; 
              } 
            } else {
              throw new Exception('breed-not-selected', 400);
            }
        } else {
          throw new Exception('missing-parameters', 401);
        }
      } else if ($type === 'select'&&$needle&&$_GET['id']) {
        $id['id'] = $_GET['id'];
        $dogCrud = new Model();
        $dogsArray = $dogCrud->dogCrud($id, $type);
        if (is_array($dogsArray)) {
          http_response_code(200);
          header('Content-Type: application/json');
          $json = json_encode($dogsArray);
          echo $json; 
        } 

      } else if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && $type==='delete'&&$needle) {
        $urlArray = explode('/',$_GET['url']);
        $id = $urlArray[count($urlArray)-1];
        if (preg_match('/^\d*$/', $id) === 1) {
          $idNum = (int)$id;
          $dogCrud = new Model();
          $deleted = $dogCrud->dogCrud($idNum, $type);
          if ($deleted === $idNum) {
            http_response_code(200);
            header('Content-Type: text/plain');
            echo $idNum;
          } 
        }

      } else if ($_SERVER['REQUEST_METHOD'] === 'PUT' && $type==='update'&&$needle) {
        $updatedDog = file_get_contents('php://input', true);
        if ($updatedDog === null) {
          throw new Exception('invalid data', 400);
        }
        $updatedDogArray = json_decode($updatedDog, true);
        
        $newDog['dogname']=filter_var($updatedDogArray['dog_name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $newDog['dogcolor']=filter_var($updatedDogArray['dog_color'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $newDog['dogbreed']=filter_var($updatedDogArray['dog_breed'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $newDog['dogweight']=filter_var($updatedDogArray['dog_weight'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if ($updatedDogArray['dog_breed'] == -1) {
          throw new Exception('breed-not-selected', 400);
        }

        $id = filter_var($updatedDogArray['id'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $updatedArray = array(
          $id => $newDog
        );

        $dogCrud = new Model();
        $updated = $dogCrud->dogCrud($updatedArray, $type);

        if ($updated === 'updated') {
          http_response_code(200);
          $response['message'] = 'ALL';
          header('Content-Type: text/plain');
          echo json_encode($response);
        }

      } else {
        throw new Exception('request not valid', 401);
      } 
      } catch (Exception $e) {
        if ($e->getCode() >= 400 && $e->getCode() < 500) {
          http_response_code((int) $e->getCode());
          header('Content-Type: application/json');
          $response['result'] = $e->getMessage();
          $response['status'] = $e->getCode();
          require_once(__DIR__ ."//..//models//logs.model.php");
          $exception = new Logs_model($e->getMessage()." ".(string) $e->getFile(), 'exception');
          $last_log_message = $exception->logException();
          unset($exception);
          echo json_encode($response);
        } else {
          http_response_code(500);
          header('Content-Type: application/json');
          $response['result'] = 'Error 500, we are sorry! We are goin to fix that as soon as possible';
          $response['status'] = 500;
  
          require_once(__DIR__ ."//..//models//logs.model.php");
          $exception = new Logs_model($e->getMessage()." ".(string)$e->getFile(), 'exception');
          $last_log_message = $exception->logException();
          unset($exception);
          echo json_encode($response);
        }
      } 
  }

  function getbreeds() {
    $this->requireAuth();
    try {
      if (isset($_GET['type'])) {
        $selectBox_request=$_GET['type'];
        $container=new Dog_container($selectBox_request);
        $breeds=$container->create_object($selectBox_request);
    
        if ($breeds!=false) {
          $properties=__DIR__."//..//config//breeds.xml";
          $selectBox=$breeds->get_select($properties);
          if ($selectBox != strip_tags($selectBox)) {
            http_response_code(200);
            header('Content-Type: text/html');
            echo $selectBox;
          } else {
            throw new Exception('breeds html not created', 500);
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

