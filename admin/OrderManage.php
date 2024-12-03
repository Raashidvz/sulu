<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'fashion');
// Enable error reporting for debugging
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
error_reporting(0);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch delivery records excluding those with status 'cart' and order by ORDER_ID descending
// $sql = "SELECT orders.ORDER_ID, orders.USER_ID, orders.DRESS_ID, dress.NAME, orders.SSIZE,
//         orders.STATUSES, orders.QUANTITY, orders.TOTAL_PRICE, orders.CREATED_AT, 
//         orders.ESTIMATED_DELIVERY_DATE, orders.ACTUAL_DELIVERY_DATE 
//         FROM orders 
//         JOIN dress ON orders.DRESS_ID = dress.DRESS_ID
//         WHERE orders.STATUSES != 'CART' 
//         ORDER BY orders.ORDER_ID DESC";  // Order by ORDER_ID descending
$sql="SELECT * FROM orders WHERE STATUSES != 'CART' ORDER BY ORDER_ID DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Management</title>
    <link rel="stylesheet" href="admin1.css">
</head>
<body>
    <div class="header">
        <h1>Order Management</h1>
    </div>

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
            <section id="delivery-section" class="section">
                <h3>Orders</h3>

                <div class="actions">
                    <button type="button" onclick="window.location.href='fabricOrders.php'" class="View fabrics">Fabric Order </button>
                </div>
                <div style="height:20px;"></div>

                <table>
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>User ID</th>
                            <th>Dress ID</th>
                            <th>Dress Name</th>
                            <th>Dress Size</th>
                            <th>Status</th>
                            <th>Quantity</th>
                            <th>Category</th>
                            <th>Total Price</th>
                            <th>Ordered Date</th>
                            <th>Estimated Delivery Date</th>
                            <th>Actual Delivery Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result->num_rows > 0): ?>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo $row['ORDER_ID']; ?></td>
                                    <td><?php echo $row['USER_ID']; ?></td>

                                    <td><?php 
                                    
                                    if($row['DRESS_ID']==null){
                                        echo "N/A";
                                    }else{
                                        echo $row['DRESS_ID']; 
                                    }
                                    ?></td>
                                    

                                    <td><?php 
                                    if($row['DRESS_ID']==null){
                                        echo "N/A";
                                    }else{
                                        $sq2="SELECT * FROM dress WHERE DRESS_ID='$row[DRESS_ID]'";
                                        $dress=mysqli_query($conn,$sq2);
                                        $dress_row=mysqli_fetch_array($dress);
                                        echo $dress_row['NAME']; 
                                    }
                                    ?></td>
                                    <td><?php echo $row['SSIZE']; ?></td>
                                    <td><?php echo $row['STATUSES']; ?></td>
                                    <td><?php echo $row['QUANTITY']; ?></td>
                                    <td><?php echo $row['CATEGORY']; ?></td>
                                    <td><?php echo $row['TOTAL_PRICE']; ?></td>
                                    <td><?php echo $row['CREATED_AT']; ?></td>
                                    <td><?php echo $row['ESTIMATED_DELIVERY_DATE']; ?></td>
                                    <td><?php echo $row['ACTUAL_DELIVERY_DATE']; ?></td>
                                    <td>
                                        <?php if ($row['STATUSES'] !== 'CANCELLED'): ?>
                                            <a href="view_order.php?id=<?php echo $row['ORDER_ID']; ?>"><button>View</button></a>
                                            <a href="edit_order.php?id=<?php echo $row['ORDER_ID']; ?>"><button>Edit</button></a>
                                            <?php
                                                $sqx="SELECT * FROM order_assignments WHERE ORDER_ID='$row[ORDER_ID]'";
                                                $check=mysqli_query($conn,$sqx);
                                                if($check){
                                                    $check_staff=mysqli_fetch_array($check);
                                                    if($check_staff['ORDER_ID']==$row['ORDER_ID']){
                                                        echo "<a href=''><button>Allotted</button></a>";
                                                    }else{
                                                        echo "<a href='allot_staff.php?id=".$row['ORDER_ID']."'><button>Allot staff</button></a>";
                                                    }
                                                }else{
                                                    
                                                }
                                            ?>

                                        <?php else: ?>
                                            <span>N/A</span>
                                        <?php endif; ?>
                                    </td>
                                                                    </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="12">No Order records found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </section>
        </main>
    </div>

    <?php
    // Close the database connection
    $conn->close();
    ?>
</body>
</html>
