<?php
require_once 'BaseController.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../config/database.php';

use PHPMailer\PHPMailer\PHPMailer;

class AuthController extends BaseController{

    public function successVerified(){
        $this->views('auth/verified');
    }

    public function showLoginForm(){
        if($this->Authenticated()){
            $this->redirect('/');
        }
        $this->views('auth/login');
    }
    public function showRegisterForm(){
        $this->views('auth/register');
    }

    public function showForgotPasswordPage(){
        $this->views('auth/forgotPassword');
    }

    public function showResetPasswordPage(){
        {
            $token = $_GET['token'] ?? '';

            if (!$token) {
                echo "Invalid or missing token.";
                return;
            }

            $userModel = new User();
            $resetEntry = $userModel->getResetEntry();

            if (!$resetEntry || !password_verify($token, $resetEntry['token'])) {
                echo "Invalid or expired token.";
                return;
            }

            if (strtotime($resetEntry['expires_at']) < time()) {
                echo "Token has expired.";
                return;
            }


            $this->views('auth/resetPassword', ['token' => $token]);
        }
    }

    public function register()
    {
        $response = ['success' => false, 'message' => ''];

        $firstname = $_POST['firstname'] ?? '';
        $lastname = $_POST['lastname'] ?? '';
        $email = $_POST['email'] ?? '';
        $phone = $_POST['phone'] ?? '';
        $address = $_POST['address'] ?? '';
        $password = $_POST['password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';

        if ($password !== $confirm_password) {
            $response['message'] = 'Passwords do not match';
            $this->jsonResponse($response);
            return;
        }

        $userModel = new User();


        if ($userModel->findByEmail($email)) {
            $response['message'] = 'Email already exists';
            $this->jsonResponse($response);
            return;
        }

        if ($userModel->findByPhone($phone)) {
            $response['message'] = 'Phone number already exists';
            $this->jsonResponse($response);
            return;
        }

        $passHashed = password_hash($password, PASSWORD_DEFAULT);

        try {

            $userModel->create($firstname, $lastname, $email, $phone, $address, $passHashed);


            $token = bin2hex(random_bytes(32));
            $userModel->saveVerificationToken($email, $token);


            $verificationLink = "http://localhost:8000/verify?email=$email&token=$token";
            $this->sendVerificationEmail($email, $firstname, $verificationLink);

            $response['success'] = true;
            $response['message'] = 'We sent verification email to your email. Please check your inbox and spam folder.';
            $this->jsonResponse($response);

        } catch (PDOException $e) {

            if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
                if (strpos($e->getMessage(), 'users.email') !== false) {
                    $response['message'] = 'This email address is already registered. Please use a different email or try logging in.';
                } elseif (strpos($e->getMessage(), 'users.phone_num') !== false) {
                    $response['message'] = 'This phone number is already associated with an account.';
                } else {
                    $response['message'] = 'This account already exists.';
                }
                $this->jsonResponse($response, 409);
            } else {
                $response['message'] = 'A system error occurred. Please try again later.';
                $this->jsonResponse($response, 500);
            }
        }
    }



    public function login() {
        $email = $_POST['floatingInput'] ?? '';
        $password = $_POST['lpassword'] ?? '';

        $userModel = new User();
        $user = $userModel->findByEmail($email);

        $isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';


        if (!$user) {
            if ($isAjax) {
                echo json_encode(['success' => false, 'error' => 'user_not_found']);
            } else {
                echo 'User not found.';
            }
            return;
        }

        if (!$user['is_verified']) {
            if ($isAjax) {
                echo json_encode(['success' => false, 'error' => 'not_verified']);
            } else {
                echo 'Please verify your email first.';
            }
            return;
        }

        if (!password_verify($password, $user['password'])) {
            if ($isAjax) {
                echo json_encode(['success' => false, 'error' => 'wrong_password']);
            }
            return;
        }

        $role = $userModel->checkRole($email);

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_role'] = $role;

        if ($isAjax) {
            echo json_encode([
                'success' => true,
                'role' => $role,
            ]);
        } else {
            if ($role === 'admin') {
                $this->redirect('/dashboard');
            } elseif ($role === 'customer') {
                $this->redirect('/home');
            } else {
                $this->redirect('/home');
            }
        }
    }


    private function sendVerificationEmail($email, $name, $link) {

        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->SMTPKeepAlive = true;
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'testaments.services@gmail.com';
        $mail->Password = 'rjnvjzrjawrvkuzh';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('testaments.services@gmail.com', 'Testaments');
        $mail->addReplyTo('support@testaments.site', 'Testaments Support');
        $mail->addAddress($email, $name);
        $mail->Subject = 'Verify Your Email Address';
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        $mail->Encoding = 'base64';

        $mail->addCustomHeader('X-Mailer', 'PHPMailer');
        $mail->addCustomHeader('List-Unsubscribe', '<mailto:support@testaments.site>');

        $mail->Body = '
                <!DOCTYPE html>
        <html lang="en">
        <head><meta charset="UTF-8"></head>
        <body style="background:#f8f9fa; padding:20px; font-family:Arial, sans-serif; color:#333;">
          <div style="background:#ffffff; max-width:500px; margin:0 auto; padding:30px; border-radius:8px; box-shadow:0 2px 10px rgba(0,0,0,0.05);">
            
            <h2 style="text-align:center; color:#111; font-weight:600; margin-bottom:20px;">Email Verification</h2>
            
            <p style="font-size:15px; line-height:1.6;">Hi ' . htmlspecialchars($name) . ',</p>
        
            <p style="font-size:15px; line-height:1.6;">Thank you for registering at <strong>Testaments</strong>. To complete your registration, please verify your email by clicking the button below:</p>
        
            <div style="text-align:center; margin:25px 0;">
              <a href="' . $link . '" style="display:inline-block; background-color:#22c55e; color:#ffffff; padding:12px 24px; border-radius:4px; text-decoration:none; font-weight:600;">Verify My Email</a>
            </div>
        
            <p style="font-size:14px; color:#666;">This link will expire in 24 hours.</p>
        
            <p style="font-size:14px; color:#666;">If you didn\'t sign up for Testaments, you can safely ignore this email.</p>
        
            <hr style="margin:30px 0; border:none; border-top:1px solid #eee;">
        
            <div style="text-align:center; font-size:12px; color:#999;">
              <p>© ' . date('Y') . ' Testaments. All rights reserved.</p>
              <p>
                <a href="https://testaments.site/" style="color:#1890ff; text-decoration:none;">Website</a> |
                <a href="https://testaments.site/contact" style="color:#1890ff; text-decoration:none;">Contact</a>
              </p>
            </div>
        
          </div>
        </body>
        </html>
        ';

        $mail->AltBody = "EMAIL VERIFICATION\n\n"
            ."Hi $name,\n\n"
            ."Thank you for registering at Testaments. Click the link below to verify your email address:\n\n"
            .$link."\n\n"
            ."This link will expire in 24 hours.\n\n"
            ."If you didn't register, you can ignore this email.\n\n"
            ."---\n"
            ."© ".date('Y')." Testaments. All rights reserved.\n"
            ."Our Website: https://testaments.site\n"
            ."Privacy Policy: https://example.com/privacy\n"
            ."Contact Us: https://testaments.site/contact";


        $mail->send();
    }

    public function verify() {
        $email = $_GET['email'] ?? '';
        $token = $_GET['token'] ?? '';

        $userModel = new User();
        $user = $userModel->findByEmail($email);

        if ($user && $user['verification_token'] === $token) {
            $userModel->verifyUser($email, $token);
            $this->views('auth/verified');
        } else {
            echo "Invalid or expired verification link.";
        }
    }


    public function logout() {

        session_unset();
        session_destroy();

        if(ini_get('session.use_cookies')) {
            setcookie(session_name(), '', time() - 42000, '/');
        }
        $this->redirect('/login');
        exit;
    }

    private function jsonResponse(array $response, int $statusCode = 200) {
        header('Content-Type: application/json');
        http_response_code($statusCode);
        echo json_encode($response);
        exit;
    }


}
?>