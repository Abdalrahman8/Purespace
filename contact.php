<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dotenv\Dotenv; // Import the Dotenv class

require 'vendor/autoload.php';

// Load environment variables from the .env file
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize form data
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $service = htmlspecialchars($_POST['service']);
    $message = htmlspecialchars($_POST['message']);

    // Email details
    $to = "service.purespace@gmail.com"; // Replace with the recipient's email
    $subject = "Neue Anfrage: $service";

    // Create a new PHPMailer instance
    $mail = new PHPMailer(true);

    try {
        // SMTP configuration
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Gmail SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = $_ENV['SMTP_USERNAME']; // Load from environment variable
        $mail->Password = $_ENV['SMTP_PASSWORD']; // Load from environment variable
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Email headers
        $mail->setFrom($email, $name); // Set the sender's email and name
        $mail->addAddress($to); // Add the recipient's email
        $mail->Subject = $subject;

        // Email body
        $mail->Body = "Name: $name\nE-Mail: $email\nService: $service\n\nNachricht:\n$message";

        // Send the email
        $mail->send();
        echo "Vielen Dank! Ihre Nachricht wurde gesendet.";
    } catch (Exception $e) {
        // Output detailed error information
        echo "Entschuldigung, es gab ein Problem beim Senden Ihrer Nachricht. Fehler: {$mail->ErrorInfo}";
    }
} else {
    echo "Ungültige Anfrage.";
}
?>