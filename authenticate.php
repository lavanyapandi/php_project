<?php
session_start();
include_once('config.php');
$user_fun = new Userfunction();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['email']) && isset($_POST['password'])) {
        
        $email = $user_fun->htmlvalidation($_POST['email']);
        $password = $user_fun->htmlvalidation($_POST['password']);
        
        if (!empty($email) && !empty($password)) {
            
            // Fetch user from database
            $user = $user_fun->getUserByEmail($email);


            if ($user && password_verify($password, $user['password'])) {
                // Set session and redirect to dashboard
                // $_SESSION['user'] = $user['email'];
                $_SESSION['user'] = [
                    'id' => $user['id'], // Store the user ID
                    'email' => $user['email'] // Store the email
                ];                header("Location: dashboard.php?login=success");
                exit();
            } else {
                header("Location: login.php?error=invalid_credentials");
                exit();
            }
        }
    }
}
?>