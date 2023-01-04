<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Retrieve the form data
  $firstName = $_POST['first-name'];
  $lastName = $_POST['last-name'];
  $email = $_POST['email'];
  $subject = $_POST['subject'];
  $message = $_POST['message'];
  $options = $_POST['options']; // Retrieve the checkbox values

  // Validate the form data
  if (empty($firstName) || empty($lastName) || empty($email) || empty($subject) || empty($message)) {
    // One or more fields is empty, return an error
    http_response_code(400);
    echo 'Please fill out all fields of the form.';
    exit;
  }

  // Set up the email message
  $to = 'muneebzaidi0@gmail.com';
  $headers = "From: $email\r\n";
  $headers .= "Reply-To: $email\r\n";
  $headers .= "MIME-Version: 1.0\r\n";
  $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
  $subject = "[Contact Form] $subject";
  $message = "
    <html>
      <head>
        <title>$subject</title>
      </head>
      <body>
        <h1>$subject</h1>
        <p>First Name: $firstName Last Name: $lastName</p>
        <p>Email: $email</p>
        <p>Message:</p>
        <p>$message</p>
      </body>
    </html>
  ";
  foreach ($options as $option) {
    $message .= "<li>$option</li>\n";
  }
  // Send the email
  if (mail($to, $subject, $message, $headers)) {
    // Email sent successfully
    http_response_code(200);
    echo 'Thank you for contacting us. Your message has been received and we will get back to you as soon as possible.';
  } else {
    // There was an error sending the email
    http_response_code(500);
    echo 'There was an error sending your message. Please try again later.';
  }
} else {
  // Invalid request method
  http_response_code(405);
  echo 'Invalid request method.';
}

