<?php 
require __DIR__."//..//..//vendor//autoload.php";

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

trait Jasonwebtoken {
  use Database;
  private string $accessKey = JWT_ACCESS_KEY;
  private string $refreshKey = JWT_REFRESH_KEY;
  private string $algorithm = 'HS256';
  private int $accessTokenExpire = 3600;
  private int $refreshTokenExpire = 86000;

  public function generateTokens(string $username): array {
    $issuedAt = time();

    $accessToken = JWT::encode([
      'iss' => ROOT,
      'iat' => $issuedAt,
      'exp' => $issuedAt + $this->accessTokenExpire,
      'sub' => $username
    ], $this->accessKey, $this->algorithm);

    $refreshToken = JWT::encode([
      'iss' => ROOT,
      'iat' => $issuedAt,
      'exp' => $issuedAt + $this->refreshTokenExpire,
      'sub' => $username
    ], $this->refreshKey, $this->algorithm);

    return ['access_token' => $accessToken, 'refresh_token' =>$refreshToken];
  }

  private function verifyAccessToken(string $token): ?object {
    try {
      return JWT::decode($token, new Key($this->accessKey, $this->algorithm));
    } catch (Exception $e) {
      return null;
    }
  }

  private function verifyRefreshToken(string $token): ?object {
    try {
      return JWT::decode($token, new Key($this->refreshKey, $this->algorithm));
    } catch (Exception $e) {
      return null;
    }
  }

  public function requireAuth() {
    if (isset($headers['Authorization'])||isset($_SESSION['access_token'])||isset($_COOKIE['jwtRefresh'])) {
      if (isset($headers['Authorization'])) {
        $token = str_replace("Bearer ", '', $headers['Authorization']);
        $decoded = $this->verifyAccessToken($token);
      } else if (isset($_SESSION['access_token'])) {
        $token = $_SESSION['access_token'];
        $decoded = $this->verifyAccessToken($token);
      }
    }
    
    if (!isset($decoded)) {
      $refreshToken = $_COOKIE['jwtRefresh'] ?? null;

      if (!$refreshToken) {
        http_response_code(401);
        header('Location: '.ROOT."public/admin/view/signin");
        $URL = filter_var($_GET['url'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $_SESSION['URL'] = $URL;
        exit;
    }

      libxml_use_internal_errors(true);
      $xmlDoc = new DOMDocument();
    if (file_exists(__DIR__."//..//config//dog_applications.xml")) {
      
      $query_string = "SELECT * FROM users";
      $array = $this->query($query_string);
      $users_array = $array;
      $refreshTokenBool = false;

      foreach ($users_array as $user) {
        if ($user['refresh_token'] === $refreshToken) {
          $username = $user['username'];
          $refreshTokenBool = true;
          break;
        }
      }

      if (!$refreshTokenBool) {
        http_response_code(401);
        header('Location: '.ROOT."public/admin/view/signin");
        $URL = filter_var($_GET['url'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $_SESSION['URL'] = $URL;
        exit;
      }

      $refreshDecoded = $this->verifyRefreshToken($refreshToken);
      
      if (!$refreshDecoded) {
        http_response_code(401);
        header('Location: '.ROOT."public/admin/view/signin");
        exit;
      }

      $issuedAt = time();

      $accessToken = JWT::encode([
        'iss' => ROOT,
        'iat' => $issuedAt,
        'exp' => $issuedAt + $this->accessTokenExpire,
        'sub' => $username
      ], $this->accessKey, $this->algorithm);

      $URL = filter_var($_GET['url'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $_SESSION['URL'] = $URL;
      $_SESSION['username'] = $username;
      $_SESSION['access_token'] = $accessToken;
      return true;
    }
  } else {
    return true;
  }
 }
}


