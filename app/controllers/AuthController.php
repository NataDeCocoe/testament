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


            $secretkey = 'PFaEXcN4KvQgrLD6lA4abvdu0gBCkzQyA/49tyq+hXI=';
            $passHashed = password_hash($password, PASSWORD_DEFAULT);
            $phoneHashed = hash_hmac('sha256', $phone, $secretkey);
            $emailHashed = hash_hmac('sha224', $email, $secretkey);


            if ($userModel->create($firstname, $lastname, $emailHashed, $phoneHashed, $address, $passHashed)) {
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

    private function jsonResponse(array $response, int $statusCode = 200) {
        header('Content-Type: application/json');
        http_response_code($statusCode);
        echo json_encode($response);
        exit;
    }
}
?>