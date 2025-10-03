<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize all inputs
    $fname          = htmlspecialchars(trim($_POST['fname'] ?? ''));
    $lname          = htmlspecialchars(trim($_POST['lname'] ?? ''));
    $email          = htmlspecialchars(trim($_POST['email'] ?? ''));
    $phone          = htmlspecialchars(trim($_POST['phone'] ?? ''));
    $projectdone    = htmlspecialchars(trim($_POST['projectdone'] ?? ''));
    $projectdonebyus = htmlspecialchars(trim($_POST['projectdonebyus'] ?? ''));
    $typeofwebsite  = htmlspecialchars(trim($_POST['typeofwebsite'] ?? ''));
    $message        = htmlspecialchars(trim($_POST['message'] ?? ''));

    // Validate required fields
    if (empty($fname) || empty($lname) || empty($email) || empty($phone) || empty($projectdone) || empty($message)) {
        die("Please fill all required fields.");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email address.");
    }

    // Setup email
    $to      = "info@elitewebpro.com";
    $subject = "Homepage Contact Form Submission";

    $body = "
    <html>
    <head>
      <title>Contact Form Submission</title>
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
        <tr><td><strong>Project Inquiry:</strong></td><td>{$projectdone}</td></tr>";

    // Conditionally include extra fields
    if ($projectdone === "yes i have a project here" && !empty($projectdonebyus)) {
        $body .= "<tr><td><strong>Project Name:</strong></td><td>{$projectdonebyus}</td></tr>";
    }

    if ($projectdone === "no i want to consult a project" && !empty($typeofwebsite)) {
        $body .= "<tr><td><strong>Type of Service:</strong></td><td>{$typeofwebsite}</td></tr>";
    }

    $body .= "
        <tr><td><strong>Message:</strong></td><td>{$message}</td></tr>
      </table>
    </body>
    </html>
    ";

    // Headers
    $headers  = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type: text/html; charset=UTF-8" . "\r\n";
    $headers .= "From: EliteWebPro <no-reply@elitewebpro.com>" . "\r\n";
    $headers .= "Reply-To: {$email}" . "\r\n";

    // Send the email
    if (mail($to, $subject, $body, $headers)) {
        echo "Thank you for contacting us!";
    } else {
        echo "Sorry, your message could not be sent. Try again later.";
    }
} else {
    header("Location: /");
    exit;
}
?>
