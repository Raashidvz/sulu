<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'fashion');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = ""; // Variable to store the success or error message

// Check if ORDER_ID and STAFF_ID are set for the POST request (when form is submitted)
// if (isset($_GET['id']) && isset($_POST['staff_id'])) {
//     $orderId = $_GET['id']; // Get ORDER_ID from the URL
//     $staffId = $_POST['staff_id']; // Get STAFF_ID from the form

//     // Insert the assignment into the order_assignments table
//     $sql = "INSERT INTO order_assignments (ORDER_ID, STAFF_ID) VALUES (?, ?)";
//     $stmt = $conn->prepare($sql);
//     $stmt->bind_param("ii", $orderId, $staffId);

//     // Execute and check if the assignment was successful
//     if ($stmt->execute()) {
//         $message = "Staff assigned successfully.";
//     } else {
//         $message = "Error assigning staff: " . $stmt->error;
//     }

//     $stmt->close();
// }

if (isset($_GET['id']) ) {
    $orderId = $_GET['id']; // Get ORDER_ID from the URL
    
}


if(isset($_POST['submit']) && isset($_POST['staff_id'])){
    $staffId = $_POST['staff_id']; // Get STAFF_ID from the form

    // Insert the assignment into the order_assignments table
    $sql = "INSERT INTO order_assignments (ORDER_ID, STAFF_ID) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $orderId, $staffId);

    // Execute and check if the assignment was successful
    if ($stmt->execute()) {
        // $message = "Staff assigned successfully.";
        echo "<script>alert('Staff assigned successfully!'); window.location.href='OrderManage.php';</script>";
    } else {
        // $message = "Error assigning staff: " . $stmt->error;
        echo "<script>alert('Error assigning staff!'); window.location.href='OrderManage.php';</script>";
    }

    $stmt->close();

}

// Fetch staff members for the dropdown (to assign to orders)
$staffResult = $conn->query("SELECT USER_ID, USERNAME FROM users WHERE USER_TYPE = 'STAFF'");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign Staff</title>
    <link rel="stylesheet" href="admin1.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #fefefe;
            margin: 0;
            padding: 0;
        }

        .header {
            background-color: #ffb3b3;
            color: #5c4f4f;
            padding: 20px;
            text-align: center;
            font-size: 1.5em;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 80vh; /* Height adjusted to center the form */
        }

        .card {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        select {
            padding: 8px;
            width: 100%;
            margin-bottom: 20px;
        }

        button {
            padding: 10px 20px;
            border: none;
            background-color: #ff7f7f;
            color: white;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #ff4d4d;
        }
    </style>
</head>
<body>

<div class="header">
    <h1>Order ID: <?php echo $_GET['id']; ?></h1> <!-- Display ORDER_ID at the top -->
</div>

<div class="container">
    <div class="card">
        <h2>Assign Staff</h2>

        <form action="allot_staff.php?id=<?php echo $_GET['id']; ?>" method="POST">
            <label for="staff_id">Assign Staff:</label>
            <select name="staff_id" id="staff_id" required>
                <option value="">Select a Staff Member</option>
                <?php while($row = $staffResult->fetch_assoc()): ?>
                    <option value="<?php echo $row['USER_ID']; ?>"><?php echo $row['USERNAME']; ?></option>
                <?php endwhile; ?>
            </select>
            <button type="submit" name="submit">Assign</button>
        </form>
    </div>
</div>


</body>
</html>

<?php
// Close the database connection
$conn->close();
?>