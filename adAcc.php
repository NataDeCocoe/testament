<?php
// Connect to your database
$pdo = new PDO('mysql:host=localhost;dbname=testamentdb', 'root', '');

// Define credentials
$firstname = 'Nathaniel';
$lastname = 'Brown';
$email = 'admin@test.com';
$phone = '09120702561';
$address = 'Canocotan, Philippines';
$plainPassword = 'admin123';
$hashedPassword = password_hash($plainPassword, PASSWORD_DEFAULT);
$role = 'admin';


$stmt = $pdo->prepare("INSERT INTO users (firstname, lastname, email, phone_num, home_address, password, role) VALUES (:firstname, :lastname, :email, :phone, :address, :password, :role)");
$stmt->execute([
    'firstname' => $firstname,
    'lastname' => $lastname,
    'email' => $email,
    'phone' => $phone,
    'address' => $address,
    'password' => $hashedPassword,
    'role' => $role
]);

echo "Admin account created successfully!";
