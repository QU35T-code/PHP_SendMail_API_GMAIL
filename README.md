# PHP_SendMail_API_GMAIL

- Windows :
  - Download the setup and install it on your machine.
  https://getcomposer.org/download/
  - Clone the repository.
  - Go to the folder with the cmd and execute the following command : <b>composer update</b>
  - Go here: https://console.developers.google.com/?pli=1 and create your application.
  - In the <b>Identifier tab</b> of your application, create an <b>OAuth 2.0 client ID</b>. Choose <b>Web application</b> in application type, give it a <b>name</b> and add a <b>redirection url</b> (Page to which you will be redirected when you will have connected to your application).
  - Once your identification key has been created, <b>download the .json file</b> (Logo on the <b>right</b> of the key).
  - Rename this file <b>credentials.json</b> and move it to the same place as the other files in the repository.
  - Modify the values (Recipient, Email Content, Subject...) in the <b>gmail.php</b> file
  - Start your server (Xampp) or add the folder on your host and launch the <b>index.php</b> page.
  - Once you have clicked on the link that appears on the page and logged in to your google account, <b>reload the index.php page</b>. You should <b>not have an error</b> and the page should be left blank (white). If so, everything is working fine ! The email has been sent !
  - To manually delete the generated token, simply delete the token.json file in your directory !
