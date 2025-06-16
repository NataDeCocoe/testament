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
        $userModel->deleteTokensForEmail($email);

        if (!$user) {
            echo json_encode(['success' => false, 'message' => 'Email not found.']);
            return;
        }

        $plainToken = bin2hex(random_bytes(32));
        $hashedToken = password_hash($plainToken, PASSWORD_DEFAULT);
        $expiresAt = date('Y-m-d H:i:s', strtotime('+1 hour'));


        $userModel->saveResetToken($email, $hashedToken, $expiresAt);


        error_log("Token generated for $email - Expires at: $expiresAt");

        $resetLink = "https://testaments.site/reset-password?token=" . urlencode($plainToken) . "&email=" . urlencode($email);

        $mail = new PHPMailer(true);
        try {
            $mail->SMTPKeepAlive = true;
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'testaments.services@gmail.com';
            $mail->Password = 'rjnvjzrjawrvkuzh';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('testaments.services@gmail.com', 'Testaments');
            $mail->addReplyTo('support@testaments.site', 'Testaments');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = 'Password Reset Request for Your Account';
            $mail->CharSet = 'UTF-8';
            $mail->Encoding = 'base64';

            $mail->addCustomHeader('X-Mailer', 'PHPMailer');
            $mail->addCustomHeader('List-Unsubscribe', '<mailto:support@testaments.site>');


            $mail->addCustomHeader('Precedence', 'bulk');
            $mail->addCustomHeader('X-Priority', '3');
            $mail->addCustomHeader('X-MSMail-Priority', 'Normal');



            $mail->Body = '
            <!DOCTYPE html>
            <html>
            <head>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
                <style>
                    
                    body, h1, h2, h3, p, a {
                        font-family: Poppins, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif !important;
                    }
                    
                    
                    
                    [owa] .text {
                            font-family: Arial, sans-serif !important;
                    }
                    
                    body {
                            background: #f8f9fa; 
                            padding: 20px;
                        line-height: 1.5;
                        color: #333;
                    }
                    .card {
                            background: white;
                            border-radius: 8px; 
                        box-shadow: 0 2px 10px rgba(0,0,0,0.05); 
                        max-width: 500px; 
                        margin: 0 auto;
                        padding: 30px;
                    }
                    .header {
                            text-align: center;
                        margin-bottom: 20px;
                    }
                    .logo {
                            max-width: 150px;
                        height: auto;
                        margin-bottom: 15px;
                    }
                    .alert-badge {
                            background: #ff4d4f; 
                            color: white;
                            padding: 8px 15px; 
                        border-radius: 20px; 
                        font-weight: 600; /* Poppins semi-bold */
                        display: inline-block;
                        margin-bottom: 20px;
                        font-size: 14px;
                    }
                    .action-button {
                            background: #fcd34d;
                            color: white !important;
                        padding: 12px 25px;
                        text-decoration: none;
                        border-radius: 4px;
                        display: inline-block;
                        margin: 20px 0;
                        font-weight: 600; /* Poppins semi-bold */
                        text-align: center;
                        width: 100%;
                        box-sizing: border-box;
                        font-family: Poppins, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif !important;
                    }
                    .token-box {
                            background: #f6f6f6; 
                            padding: 15px; 
                        border-radius: 4px; 
                        margin: 20px 0;
                        font-family: monospace;
                        word-break: break-all;
                    }
                    .footer {
                            margin-top: 30px;
                        padding-top: 20px;
                        border-top: 1px solid #eee;
                        font-size: 12px;
                        color: #999;
                        text-align: center;
                    }
                    .small-text {
                            font-size: 13px;
                        color: #666;
                        font-weight: 400; /* Poppins regular */
                    }
                </style>
            </head>
            <body>
                <div class="card">
                  
                    
                    
                    
                    <p style="font-weight: 400;">Hello,</p>
                    
                    <p style="font-weight: 400;">We received a request to reset the password for your account. If you made this request, please use the button below to reset your password:</p>
                    
                    <a href="'.$resetLink.'" class="action-button">Reset My Password</a>
                    
                    <p class="small-text">This link will expire in 1 hour.</p>
                    
                    <p style="font-weight: 400;">If you didn\'t request a password reset, please ignore this email or contact our support team if you have any concerns.</p>
                    
                    <div class="footer">
                        <p>© '.date('Y').' Testaments. All rights reserved.</p>
                        <p class="small-text">This email was sent to you because you requested a password reset for your account.</p>
                        <p class="small-text">
                            <a href="https://testaments.site/" style="color: #1890ff; text-decoration: none; font-weight: 500;">Our Website</a> | 
                            <a href="https://example.com/privacy" style="color: #1890ff; text-decoration: none; font-weight: 500;">Privacy Policy</a> | 
                            <a href="https://testaments.site/contact" style="color: #1890ff; text-decoration: none; font-weight: 500;">Contact Us</a>
                        </p>
                    </div>
                </div>
            </body>
            </html>';

            $mail->AltBody = "PASSWORD RESET REQUEST\n\n"
                ."Hello,\n\n"
                ."We received a request to reset the password for your account. If you made this request, please use the link below to reset your password:\n\n"
                ."Reset your password:\n"
                .$resetLink."\n\n"
                ."This link will expire in 1 hour.\n\n"
                ."If you didn't request a password reset, please ignore this email or contact our support team if you have any concerns.\n\n"
                ."---\n"
                ."© ".date('Y')." Testaments. All rights reserved.\n"
                ."This email was sent to you because you requested a password reset for your account.\n"
                ."Our Website: https://testaments.site\n"
                ."Privacy Policy: https://example.com/privacy\n"
                ."Contact Us: https://testaments.site/contact";

            $mail->send();

            echo json_encode(['success' => true]);
        } catch (Exception $e) {
            error_log("Mail sending failed: " . $e->getMessage());
            echo json_encode(['success' => false, 'message' => 'Mail error: ' . $mail->ErrorInfo]);
        }
    }

    public function handleReset() {
        $data = json_decode(file_get_contents("php://input"), true);
        $email = $data['email'] ?? '';
        $plainToken = $data['token'] ?? '';
        $newPassword = $data['new_password'] ?? '';
        $confirmPassword = $data['confirm_password'] ?? '';

        if ($newPassword !== $confirmPassword) {
            echo json_encode(['success' => false, 'message' => 'Passwords do not match.']);
            return;
        }

        $userModel = new User();
        $reset = $userModel->getResetTokenByEmail($email);


        if (!$reset || !password_verify($plainToken, $reset['token'])) {
            echo json_encode(['success' => false, 'message' => 'Invalid or expired token.']);
            return;
        }

        if (strtotime($reset['expires_at']) < time()) {
            echo json_encode(['success' => false, 'message' => 'Token has expired.']);
            return;
        }


        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $userModel->updateUserPassword($email, $hashedPassword);

        $userModel->deleteResetToken($email);


        echo json_encode(['success' => true, 'message' => 'Password successfully reset.']);
    }

}
