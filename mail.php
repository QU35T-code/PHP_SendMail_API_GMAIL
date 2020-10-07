<?php
  class Test {
    public function __construct() {
      $this->include();
    }


    private function include() {
      require __DIR__ . '\vendor\autoload.php';
      include "connection.php";
    }

    public function go() {
      $conn = new Connection();

      if ($conn->is_connected()) {
        require_once("gmail.php");
        $gmail = new Gmail($conn->get_client());
        return $gmail->sendMail();

      } else {
        return $conn->get_unauthenticated_data();
      }
    }
  }

  error_reporting(0);
  $test = new Test();
  echo "<!DOCTYPE html><html>";
  echo $test->go();
  echo "</html>";
?>
