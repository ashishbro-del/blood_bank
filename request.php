<?php
session_start();
include('connection.php'); 
require_once 'PHPMailer/Exception.php';
require_once 'PHPMailer/PHPMailer.php';
require_once 'PHPMailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (isset($_SESSION['user_id']) && isset($_POST['blood_group']) && isset($_POST['province']) && isset($_POST['city']) && isset($_POST['email'])) {
    $user_id = $_SESSION['user_id'];
    $blood_group = $_POST['blood_group'];
    $province = $_POST['province'];
    $city = $_POST['city'];
    $email = $_POST['email'];
    
    $sql = "INSERT INTO requests (user_id, blood_group, province, city, email) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issss", $user_id, $blood_group, $province, $city, $email);
 
    if ($stmt->execute()) {
        $_SESSION['successmsg'] = "Request submitted successfully!";
        
        $mail = new PHPMailer(true);
        try {
            $mail->SMTPDebug = 2; // Enable verbose debug output
            $mail->isSMTP();                                         
            $mail->Host       = 'smtp.example.com';                  
            $mail->SMTPAuth   = true;                             
            $mail->Username   = 'your_email@example.com';           
            $mail->Password   = 'your_password';                     
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; 
            $mail->Port       = 465; 

            $mail->setFrom('your_email@example.com', 'Blood Donation');
            $mail->addAddress($email);
            
            $mail->isHTML(true);                                    
            $mail->Subject = 'Blood Request Received';
            $mail->Body    = 'Dear User,<br><br>Your blood request has been received. Thank you for your submission.<br><br>Best regards,<br>Blood Donation Team';
            $mail->AltBody = 'Dear User,\n\nYour blood request has been received. Thank you for your submission.\n\nBest regards,\nBlood Donation Team';

            $mail->send();
        } catch (Exception $e) {
            $_SESSION['errmsg'] = "Request submitted but failed to send email. Error: " . $mail->ErrorInfo;
        }
    } else {
        $_SESSION['errmsg'] = "Request submission failed!";
    }

    $stmt->close();
    $conn->close();

    header("Location: ../request.html");
    exit();
} else {
    $_SESSION['errmsg'] = "Required fields are missing.";
    header("Location: ../request.html");
    exit();
}
?>
