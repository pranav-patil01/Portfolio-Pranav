<?php
// Database credentials

error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = "localhost"; // or 127.0.0.1 or your hosting MySQL server
$dbname = "resume";  // use the correct DB name
$username = "root";  // change if different
$password = "";      // change if your MySQL has a password

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form fields safely
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $subject = htmlspecialchars(trim($_POST['subject']));
    $message = htmlspecialchars(trim($_POST['message']));

    // Send Email
    $to = "patil.pranav4415@gmail.com";
    $email_subject = "New Message: $subject";
    $email_body = "From: $name <$email>\n\n$message";
    $headers = "From: $email\r\nReply-To: $email";

    mail($to, $email_subject, $email_body, $headers);

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "INSERT INTO contact_messages (name, email, subject, message)
                VALUES (:name, :email, :subject, :message)";
        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            ':name' => $name,
            ':email' => $email,
            ':subject' => $subject,
            ':message' => $message
        ]);

        echo "<script>alert('Your message has been sent and stored.'); window.location.href='thankyou.html';</script>";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
