<?php
session_start();
error_reporting(E_ALL); // Show all errors for debugging
// Connect to MySQL database
$dbcon = mysqli_connect("localhost", "root", "", "fashion");

// Check connection
if (!$dbcon) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch the current user's details
if (!isset($_SESSION['USER_ID'])) {
    die("User ID not set in session."); // Debugging line
}

$sql = "SELECT * FROM users WHERE USER_ID='$_SESSION[USER_ID]'";
$data = mysqli_query($dbcon, $sql);
$user = mysqli_fetch_array($data);

// Handle address update request
if (isset($_POST['update_address'])) {
    $new_address = $_POST['address'];

    // Update the address in the database
    $update_sql = "UPDATE users SET ADDRESSS='$new_address' WHERE USER_ID='{$_SESSION['USER_ID']}'"; // Ensure ADDRESSS is used

    if (mysqli_query($dbcon, $update_sql)) {
        echo "<script>
                alert('Address updated successfully!');
                window.location.href = 'profile.php'; // Redirect to profile page
              </script>";
        exit();
    } else {
        echo "<script>alert('Error updating address: " . mysqli_error($dbcon) . ". Please try again.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Delivery Address</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .form-container {
            max-width: 600px;
            margin: 50px auto;
            background-color: #fff;
            padding: 30px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            font-weight: 600;
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }
        .btn-update {
            padding: 10px 20px;
            background-color: palevioletred;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }
        .btn-update:hover {
            background-color: #d75a8a;
        }
    </style>
</head>
<body>

    <div class="form-container">
        <h2>Update Delivery Address</h2>
        <form method="POST" action="" id="addressForm">
            <div class="form-group">
                <label for="address">New Address</label>
                <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($user['ADDRESSS']); ?>" required>
            </div>
            <button type="submit" name="update_address" class="btn-update">Update Address</button>
        </form>
    </div>

</body>
</html>
