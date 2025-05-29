<?php
require_once 'BaseController.php';
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../models/User.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;



class ForgotPasswordController extends BaseController {
    public function sendLink() {
        $data = json_decode(file_get_contents("php://input"), true);
        $email = $data['email'] ?? '';

        $userModel = new User();
        $user = $userModel->findByEmail($email);

        if (!$user) {
            echo json_encode(['success' => false, 'message' => 'Email not found.']);
            return;
        }

        $plainToken = bin2hex(random_bytes(32)); // 64 characters
        $hashedToken = password_hash($plainToken, PASSWORD_DEFAULT);
        $expiresAt = date('Y-m-d H:i:s', strtotime('+1 hour'));

        // Save hashed token to password_resets table
        $userModel->saveResetToken($email, $hashedToken, $expiresAt);

        // Send plain token in the reset link
        $resetLink = "http://yourdomain.com/reset-password?token=" . urlencode($plainToken) . "&email=" . urlencode($email);

        // Send Email using PHPMailer
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'your-mail@gmail.com';
            $mail->Password = 'your-app-password'; // App Password
            $mail->SMTPSecure = 'tls';
            $mail->Port = 000;

            $mail->setFrom('no-reply@example.com', 'YourApp Support');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = 'Password Reset Link';
            $mail->Body = "Click the link to reset your password: <a href='$resetLink'>$resetLink</a>";

            $mail->send();

            echo json_encode(['success' => true]);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Mail error: ' . $mail->ErrorInfo]);
        }
    }

}
