<?php

  class Gmail {
    public function __construct($client) {
      $this->client = $client;
    }

    public function sendMail() {
      $service = new Google_Service_Gmail($this->client);

      try {
          // Configure mail
          $from = "alexis.martin3190@gmail.com";
          $to = "alexis.martin3190@gmail.com";
          $copy = "alexis.martin@so-it.fr";
          $strSubject = "I'm a subject";
          $content_message = "Hello World !";

          // Process data
          $strRawMessage = "From: LabelFrom<" . $from . ">\r\n";
          $strRawMessage .= "To: LabelTo<" . $to . ">\r\n";
          $strRawMessage .= "CC: LabelCopy<" . $copy . ">\r\n";
          $strRawMessage .= "Subject: =?utf-8?B?" . base64_encode($strSubject) . "?=\r\n";
          $strRawMessage .= "MIME-Version: 1.0\r\n";
          $strRawMessage .= "Content-Type: text/plain; charset='utf-8'\r\n";
          $strRawMessage .= "Content-Transfer-Encoding: base64" . "\r\n\r\n";
          $strRawMessage .= "" . base64_encode($content_message) . "\r\n";

          $mime = base64_encode($strRawMessage);
          $msg = new Google_Service_Gmail_Message();
          $msg->setRaw($mime);
          $message = $service->users_messages->send("me", $msg);
      } catch (Exception $e) {
          print "An error occurred: " . $e->getMessage();
      }
    }
  }
?>
