<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize input
    $name    = htmlspecialchars(trim($_POST['name'] ?? ''));
    $email   = htmlspecialchars(trim($_POST['email'] ?? ''));
    $phone   = htmlspecialchars(trim($_POST['phone'] ?? ''));
    $message = htmlspecialchars(trim($_POST['message'] ?? ''));

    // Validate input
    if (empty($name) || empty($email) || empty($phone) || empty($message)) {
        die("All fields are required.");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format.");
    }

    // Email details
    $to      = "info@elitewebpro.com";
    $subject = "New Quote Request from EliteWebPro Website";

    $body = "
    <html>
    <head>
      <title>New Quote Request</title>
      <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        td { padding: 8px; border: 1px solid #ccc; }
      </style>
    </head>
    <body>
      <h2>Quote Request Details</h2>
      <table>
        <tr>
          <td><strong>Name</strong></td>
          <td>{$name}</td>
        </tr>
        <tr>
          <td><strong>Email</strong></td>
          <td>{$email}</td>
        </tr>
        <tr>
          <td><strong>Phone</strong></td>
          <td>{$phone}</td>
        </tr>
        <tr>
          <td><strong>Message</strong></td>
          <td>{$message}</td>
        </tr>
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
        echo "Your quote request has been sent successfully.";
    } else {
        echo "Failed to send your request. Please try again later.";
    }
} else {
    // Redirect if accessed directly
    header("Location: /");
    exit;
}
?>
