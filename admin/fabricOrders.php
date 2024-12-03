<?php
// Database connection
$conn = mysqli_connect("localhost", "root", "", "fashion");
error_reporting(0);
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Query to fetch all fabric orders
$fabrics = "SELECT * FROM orders 
WHERE CATEGORY='FABRIC_PURCHASE' 
AND STATUSES!='COMPLETED' 
AND STATUSES!='CART'";
$fabric_order = mysqli_query($conn, $fabrics);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fabric Orders</title>
    <link rel="stylesheet" href="admin1.css">
    <style>
        .message-tile {
            border: 1px solid #ccc;
            padding: 20px;
            margin: 10px auto;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            width: 80%;
            background-color: #f9f9f9;
        }
        .message-tile p {
            margin: 10px 0;
        }
    </style>
</head>
<body>
<div class="admin-dashboard">
    <aside class="sidebar">
        <h3>Menu</h3>
        <a href="customers.php">Customer Management</a>
        <a href="staff.php">Staff Management</a>
        <a href="communications.php">Communication</a>
        <a href="manageDesign.php">Manage Designs</a>
        <a href="manageFabric.php">Manage Fabric</a>
        <a href="OrderManage.php">Order Management</a>
        <a href="logout.php">Logout</a>
    </aside>
    
    <main class="content">
        <h3>Fabric Orders</h3>

        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>User ID</th>
                    <th>Fabric ID</th>
                    <th>Fabric Name</th>
                    <th>Status</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                    <th>Ordered Date</th>
                    <th>Estimated Delivery Date</th>
                    <th>Actual Delivery Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
    <?php if ($fabric_order && $fabric_order->num_rows > 0): ?>
        <?php while ($row = $fabric_order->fetch_assoc()): ?>
            <?php 
                $sql="SELECT * FROM fabrics WHERE FABRIC_ID='$row[FABRIC_ID]'";
                $fabric=mysqli_query($conn,$sql);
                $fabric_data=mysqli_fetch_array($fabric);
            ?>
            <tr>
                <td><?php echo $row['ORDER_ID']; ?></td>
                <td><?php echo $row['USER_ID']; ?></td>
                <td><?php echo $row['FABRIC_ID']; ?></td>
                <td><?php echo $fabric_data['NAME']; ?></td>
                <td><?php echo $row['STATUSES']; ?></td>
                <td><?php echo $row['QUANTITY']; ?></td>
                <td><?php echo $row['TOTAL_PRICE']; ?></td>
                <td><?php echo $row['CREATED_AT']; ?></td>
                <td><?php echo $row['ESTIMATED_DELIVERY_DATE']; ?></td>
                <td><?php echo $row['ACTUAL_DELIVERY_DATE']; ?></td>
                <td>
                    <?php if ($row['STATUSES'] !== 'CANCELLED'): ?>
                        <a href="view_fabric_order.php?id=<?php echo $row['ORDER_ID']; ?>"><button>View</button></a>
                        
                        <?php if ($row['STATUSES'] == 'SHIPPED'): ?>
                            <a href="#"><button>Shipped</button></a>
                        <?php else: ?>
                            <!-- Corrected onclick syntax with escaped quotes -->
                            <a href="javascript:void(0);" onclick="confirmAction('ship_fabric.php?id=<?php echo $row['ORDER_ID']; ?>')"><button>Ship</button></a>
                        <?php endif; ?>
                    <?php else: ?>
                        <span>N/A</span>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr>
            <td colspan="12">No fabric order records found.</td>
        </tr>
    <?php endif; ?>
</tbody>

        </table>
    </main>
</div>
</body>
<script>
       function confirmAction(url) {
        // Show a confirmation dialog
        let confirmation = confirm("Are you sure you want to ship this order?");
        
        // Redirect if confirmed
        if (confirmation) {
            window.location.href = url;
        }
    }
</script>
</html>

<?php
$conn->close();
?>
