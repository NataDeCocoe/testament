<?php
require_once 'BaseController.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../../config/database.php';
class AuthController extends BaseController{

    public function showLoginForm(){
        if($this->Authenticated()){
            $this->redirect('/');
        }
        $this->views('auth/login');;
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

    public function register() {
        $response = ['success' => false, 'message' => ''];

        try {

            $firstname = $_POST['firstname'] ?? '';
            $lastname = $_POST['lastname'] ?? '';
            $email = $_POST['email'] ?? '';
            $phone = $_POST['phone'] ?? '';
            $address = $_POST['address'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';


            if ($password != $confirm_password) {
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




            if ($userModel->create($firstname, $lastname, $email, $phone, $address, $passHashed)) {
                $response['success'] = true;
                $response['message'] = 'Registration successful!';
                $this->jsonResponse($response);
            } else {
                throw new Exception('Failed to create user');
            }

        } catch (Exception $e) {
            if (strpos($e->getMessage(), 'Duplicate entry') !== false) {

                if (strpos($e->getMessage(), 'users.email') !== false) {
                    $response['message'] = 'This email address is already registered. Please use a different email or try logging in.';
                }
                elseif (strpos($e->getMessage(), 'users.phone') !== false) {
                    $response['message'] = 'This phone number is already associated with an account. Please use a different number.';
                }
                else {

                    $response['message'] = 'This account already exists in our system.';
                }
            } else {
                $response['message'] = 'A system error occurred. Please try again later.';
            }
            $this->jsonResponse($response, 409);
        } catch (Exception $e) {
            $response['message'] = 'An unexpected error occurred.';
            $this->jsonResponse($response, 500);
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
                echo json_encode(['success' => false, 'error' => 'invalid_email']);
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