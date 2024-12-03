<?php
$conn = new mysqli("localhost", "root", "", "fashion");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$order_id = $_GET['id'];


    $sql_update = "UPDATE orders SET STATUSES='SHIPPED' WHERE ORDER_ID='$order_id'";
    if ($conn->query($sql_update) === TRUE) {
        $message = "<p>Order updated successfully!</p>";
        echo "<script>alert('Fabric order $order_id has shipped'); window.location.href='fabricOrders.php';</script>";
    } else {
        echo "<script>alert('Error updating Fabric order $order_id'); window.location.href='fabricOrders.php';</script>";
    }


$conn->close();
?>