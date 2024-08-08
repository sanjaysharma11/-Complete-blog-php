<?php
ob_start();
include 'header.php';
include 'Config.php';
session_start();

if (isset($_SESSION['user_data'])) {
    header("location:http://localhost/php-blog/admin/index.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 80vh;
        }

        .login-form {
            background-color: #f8f9fa;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            width: 400px;
        }

        .login-form h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #544E48;
        }

        .login-form .form-group {
            margin-bottom: 20px;
        }

        .login-form .form-control {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px 15px;
            font-size: 16px;
        }

        .login-form .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            width: 100%;
            font-size: 16px;
            padding: 10px 20px;
        }

        .login-form .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004a99;
        }

        .login-form .error-message {
            background-color: #f8d7da;
            color: #721c24;
            padding: 10px 15px;
            border-radius: 5px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-form">
            <h2>Blog! Login your account.</h2>
            <form action="" method="POST">
                <div class="form-group">
                    <input type="email" name="email" placeholder="Email" class="form-control" required>
                </div>
                <div class="form-group">
                    <input type="password" name="password" placeholder="Password" class="form-control" required>
                </div>
                <div class="form-group">
                    <input type="submit" name="login_btn" class="btn btn-primary" value="Login">
                </div>
                <?php
                if (isset($_SESSION['error'])) {
                    $error = $_SESSION['error'];
                    echo "<div class='error-message'>" . $error . "</div>";
                    unset($_SESSION['error']);
                }
                ?>
            </form>
        </div>
    </div>
    <?php
    include 'footer.php';

    if (isset($_POST['login_btn'])) {
        $email = mysqli_real_escape_string($config, $_POST['email']);
        $pass = mysqli_real_escape_string($config, sha1($_POST['password']));
        $sql = "SELECT * FROM user WHERE email='{$email}' AND password='{$pass}'";
        $query = mysqli_query($config, $sql);
        $data = mysqli_num_rows($query);
        if ($data) {
            $result = mysqli_fetch_assoc($query);
            $user_data = array($result['user_id'], $result['username'], $result['role']);
            $_SESSION['user_data'] = $user_data;
            header("location:admin/index.php");
        } else {
            $_SESSION['error'] = "Invalid email/password";
            header("location:login.php");
        }
    }
    ob_end_flush();
    ?>
</body>
</html>