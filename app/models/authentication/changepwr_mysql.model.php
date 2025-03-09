<?php

class Changepwr_mysql {
  use Database;
  private array $users_array = array ();
  private string $user_changepwr = '';
  private string $old_password_changepwr = '';
  private string $new_password_changepwr = '';

  function __construct(array $credentials) { 
    $this->user_changepwr = $credentials['username'];
    $this->old_password_changepwr = $credentials['old-password'];
    $this->new_password_changepwr = $credentials['new-password'];

    $query_string = 'SELECT * FROM users';
    $array = $this->query($query_string);
    $this->users_array = $array;
  }

  function __destruct() {
    $mysqli = new mysqli(DBHOST, DBUSER, DBPASSWORD, DBNAME);
    if (!$mysqli->query("DROP TABLE IF EXISTS users") || !$mysqli->query("CREATE TABLE IF NOT EXISTS users (
      username varchar(50),
      email varchar(255),
      password varchar(255),
      refresh_token varchar(255),
      datestamp integer,
      attempts integer not null CHECK (attempts >= 0 and attempts < 5),
      lastattempt integer,
      validattempt integer
    )")) {
      throw new Exception("Table can't be created or deleted".$mysqli->error, 500);
    }

    foreach ($this->users_array as $user) {
      $username = $user['username'];
      $email = $user['email'];
      $password = $user['password'];
      $refresh_token = $user['refresh_token'];
      $datestamp = $user['datestamp'];
      $attempts = $user['attempts'];
      $lastattempt = $user['lastattempt'];
      $validattempt = $user['validattempt'];

      $query_string = "
      INSERT INTO users (username, email, password, refresh_token, datestamp, attempts, lastattempt, validattempt) VALUES (
        '$username',
        '$email',
        '$password',
        '$refresh_token',
        $datestamp,
        $attempts,
        $lastattempt,
        $validattempt
      )";

      if (!$mysqli->query($query_string)) {
        throw new Exception("Can't add new records: ". $mysql->error, 500);
      }
    }
  }

  function changePassword() {
    foreach ($this->users_array as &$user) {
      if (in_array($this->user_changepwr, $user)) {
        $hash = $user['password'];
        if (password_verify($this->old_password_changepwr, $hash)) {
          $user['password'] = password_hash($this->new_password_changepwr, PASSWORD_DEFAULT);
          $user['datestamp'] = strtotime("now + 30 days");
          $user['attempts'] = 0;
          $_SESSION['message'] = 'pwr-changed';
          return true;
        } else {
          $_SESSION['message'] = 'invalid-password';
          return false;
        }
      }
    }
    $_SESSION['message'] = 'user-not-found';
    return false;
  }
}