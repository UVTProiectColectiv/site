<?php
  $name = $_POST['name'];
  $visitor_email = $POST['email'];
  $message = $_POST['message'];
  $success = '';

  $email_from = 'bianca.stefanescu01@e-uvt.ro';
  $email_subject = "New form submission";
  $email_body = "User Name: $name.\n".
                "User Email: $visitor_email.\n".
                "User Message: $message.\n";

  $to = 'bianca.stefanesc55@gmail.com';
  $headers = "From: $email_from \r\n";
  $headers .= "Reaply-To: $visitor_email \r\n";

  if(mail($to,$email_subject,$email_body,$headers)){
    $success = "Message sent, thank you for contacting us!";
    $name = $visitor_email = $message ='';
  }

  header("Location: ../pagini/site.html");

 ?>