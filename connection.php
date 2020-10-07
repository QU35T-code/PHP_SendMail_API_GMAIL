<?php
  class Connection {
    public function __construct() {
        $this->credentials = "credentials.json";
        $this->client = $this->create_client();
    }

    public function get_client() {
      return $this->client;
    }

    public function get_credentials() {
      return $this->credentials;
    }

    public function is_connected() {
      return $this->is_connected;
    }

    public function get_unauthenticated_data() {
      $authUrl = $this->client->createAuthUrl();
      return "<a href='$authUrl'>Click here to link your account</a>";
    }

    public function credentials_in_browser() {
      if ($_GET['code']) {
        return true;
      }
      return false;
    }

    public function create_client() {
      $client = new Google_Client();
      $client->setApplicationName('Gmail API PHP');
      $client->addScope('https://mail.google.com/');
      $client->setAuthConfig('credentials.json');
      $client->setAccessType('offline');
      $client->setPrompt('select_account consent');
      $tokenPath = 'token.json';
      if (file_exists($tokenPath)) {
          $accessToken = json_decode(file_get_contents($tokenPath), true);
          $client->setAccessToken($accessToken);
      }

      if ($client->isAccessTokenExpired()) {
          if ($client->getRefreshToken()) {
              $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
          } elseif($this->credentials_in_browser()) {
            $authCode = $_GET['code'];
            $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
            $client->setAccessToken($accessToken);

            if (array_key_exists('error', $accessToken)) {
                throw new Exception(join(', ', $accessToken));
            }
          } else {
            $this->is_connected = false;
            return $client;
          }
          if (!file_exists(dirname($tokenPath))) {
              mkdir(dirname($tokenPath), 0700, true);
          }
          file_put_contents($tokenPath, json_encode($client->getAccessToken()));
      }
      else {}

      $this->is_connected = true;
      return $client;
  }
}
?>
