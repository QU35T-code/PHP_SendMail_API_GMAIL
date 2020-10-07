<?php

  class Gmail {

    public function __construct($client) {
      $this->client = $client;
    }

    public function readLabels() {
      $service = new Google_Service_Gmail($this->client);

      // Print the labels in the user's account.
      $user = 'me';
      $results = $service->users_labels->listUsersLabels($user);

      if (count($results->getLabels()) == 0) {
        print "No labels found.\n";
      } else {
        print "Labels:\n";
        foreach ($results->getLabels() as $label) {
          printf("- %s\n", $label->getName());
        }
      }
    }

    public function listMessages() {
        $service = new Google_Service_Gmail($this->client);

        // Print the labels in the user's account.
        $userId = 'me';
        $pageToken = NULL;
        $messages = array();
        $opt_param = array();
        $i = 0;
        do {
          if ($i == 5) break;
          $i++;
            try {
                if ($pageToken) {
                    $opt_param['pageToken'] = $pageToken;
                }
                $messagesResponse = $service->users_messages->listUsersMessages($userId, $opt_param);
                if ($messagesResponse->getMessages()) {
                    $messages = array_merge($messages, $messagesResponse->getMessages());
                    $pageToken = $messagesResponse->getNextPageToken();
                }
            } catch (Exception $e) {
                print 'An error occurred: ' . $e->getMessage();
            }
        } while ($pageToken);

        foreach ($messages as $message) {
            print 'Message with ID: ' . $message->getId() . '<br/>';
            $msg = $service->users_messages->get($userId, $message->getId());
            $my_final = var_export($msg->payload->parts[1]->body->data, true);
            echo "<pre>".base64_decode($my_final)."</pre>";
        }

        return $messages;
    }

    public function sendMail() {
      $service = new Google_Service_Gmail($this->client);
      $content_message = "La réclamation du 22/11 n'as pas été effectué. Merci de la prendre en compte.";
      // Process data
      try {
          $strSubject = "Réclamation";
          $strRawMessage = "From: Me<alexis.martin3190@gmail.com>\r\n";
          $strRawMessage .= "To: Alexis<alexis.martin3190@gmail.com>\r\n";
          $strRawMessage .= "CC: Copie<alexis.martin@so-it.fr>\r\n";
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
