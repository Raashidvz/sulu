<?php
session_start();
$dbcon = mysqli_connect("localhost", "root", "", "fashion");
if (!$dbcon) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $confirm_password = $_POST['pw'];

    // Check if password and confirm password match
    if ($password !== $confirm_password) {
        echo "<script>alert('Passwords do not match. Please try again.');</script>";
    } else {
        if (strlen($password) < 6) {
            $errors[] = 'Password must be at least 6 characters long.';
            exit();
        }
        // Validate the user details
        $sql = "SELECT * FROM users WHERE USERNAME='$username' AND EMAIL='$email' AND PHONE='$phone'";
        $data = mysqli_query($dbcon, $sql);

        if ($data && mysqli_num_rows($data) > 0) {
            // Update the password in the database without hashing
             if (strlen($password) < 6) {
            $errors[] = 'Password must be at least 6 characters long.';
        }
        if ($password !== $confirmpw) {
            $errors[] = 'Passwords do not match.';
        }
            $update_sql = "UPDATE users SET PASSWORDD='$password' WHERE USERNAME='$username'";
            if (mysqli_query($dbcon, $update_sql)) {
                echo "<script>alert('Password reset successful! Your new password is: $password'); window.location.href='login.php';</script>";
            } else {
                echo "<script>alert('Error updating password. Please try again later.');</script>";
            }
        } else {
            echo "<script>alert('Invalid details! Please make sure all information is correct.');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - Women's Boutique</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .navbar {
            background-color: #333;
            padding: 15px 0;
            text-align: center;
            position: absolute;
            top: 0;
            width: 100%;
            z-index: 1000;
        }

        .navbar a {
            color: #fff;
            padding: 14px 20px;
            text-decoration: none;
            display: inline-block;
            transition: background-color 0.3s ease;
        }

        .navbar a:hover, .navbar a.customize-button {
            background-color: palevioletred;
            border-radius: 20px;
        }

        .form-container {
            background-color: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }

        .form-container h2 {
            color: #333;
            margin-bottom: 10px;
        }

        .form-container form {
            display: flex;
            flex-direction: column;
        }

        .form-container label {
            margin-bottom: 5px;
            text-align: left;
            color: #666;
        }

        .form-container input[type="text"],
        .form-container input[type="email"],
        .form-container input[type="password"] {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: 1px solid #ddd;
            width: 100%;
            box-sizing: border-box;
        }

        .form-container button {
            background-color: palevioletred;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
            transition: background-color 0.3s ease;
        }

        .form-container button:hover {
            background-color: #d1477a;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="custmrdshbrd.php">Home</a>
        <a href="fabric.php">Fabric</a>
        <a href="abt.php">About</a>
        <a href="contact1.php">Contact</a>
        <a href="login.php">Login</a>
        <a href="customize1.php" class="customize-button">Customize Now</a>
    </div>

    <div class="form-container">
        <h2>Forgot Password</h2>
        <form action="" method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="phone">Phone Number:</label>
            <input type="text" id="phone" name="phone" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <label for="pw">Confirm Password:</label>
            <input type="password" id="pw" name="pw" required>

            <button type="submit" name="submit">Submit</button>
        </form>
    </div>
</body>
</html>
