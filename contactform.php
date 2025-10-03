<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize inputs
    $fname   = htmlspecialchars(trim($_POST['fname'] ?? ''));
    $lname   = htmlspecialchars(trim($_POST['lname'] ?? ''));
    $email   = htmlspecialchars(trim($_POST['email'] ?? ''));
    $phone   = htmlspecialchars(trim($_POST['phone'] ?? ''));
    $message = htmlspecialchars(trim($_POST['message'] ?? ''));

    // Validate inputs
    if (empty($fname) || empty($lname) || empty($email) || empty($phone) || empty($message)) {
        die("All fields are required.");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email address.");
    }

    // Email content
    $to      = "info@elitewebpro.com";
    $subject = "New Contact Form Submission from EliteWebPro";

    $body = "
    <html>
    <head>
      <title>New Contact Form Submission</title>
      <style>
        body { font-family: Arial, sans-serif; }
        table { border-collapse: collapse; width: 100%; }
        td { padding: 8px; border: 1px solid #ccc; }
      </style>
    </head>
    <body>
      <h2>Contact Details</h2>
      <table>
        <tr><td><strong>First Name:</strong></td><td>{$fname}</td></tr>
        <tr><td><strong>Last Name:</strong></td><td>{$lname}</td></tr>
        <tr><td><strong>Email:</strong></td><td>{$email}</td></tr>
        <tr><td><strong>Phone:</strong></td><td>{$phone}</td></tr>
        <tr><td><strong>Message:</strong></td><td>{$message}</td></tr>
      </table>
    </body>
    </html>
    ";

    // Email headers
    $headers  = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type: text/html; charset=UTF-8" . "\r\n";
    $headers .= "From: EliteWebPro <no-reply@elitewebpro.com>" . "\r\n";
    $headers .= "Reply-To: {$email}" . "\r\n";

    // Send email
    if (mail($to, $subject, $body, $headers)) {
        echo "Thank you! Your message has been sent successfully.";
    } else {
        echo "Sorry, something went wrong. Please try again later.";
    }
} else {
    // If accessed directly, redirect to homepage
    header("Location: /");
    exit;
}
?>