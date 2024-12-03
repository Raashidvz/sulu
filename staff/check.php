<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fashion";

$conn = new mysqli($servername, $username, $password, $dbname);

if(isset($_POST['submit'])){
    $customer = $_POST['customerr'];
 echo $customer;
    if($customer == 'new'){
        echo "Hello";
    }
    //     $customer_name = htmlspecialchars($_POST['customer_name']);
    //     $phoneNo = htmlspecialchars($_POST['phoneNo']);
    //     $address = htmlspecialchars($_POST['address']);
    
    //     // Use prepared statements to avoid SQL injection
    //     $sql = "INSERT INTO users (USERNAME, PASSWORDD, PHONE, ADDRESSS) VALUES (?, ?, ?, ?)";
    //     $stmt = $conn->prepare($sql);
    //     $stmt->bind_param("ssss", $customer_name, $phoneNo, $phoneNo, $address);
    //     $stmt->execute();
    
    //     if($stmt->affected_rows > 0){
    //         // Retrieve the user_id for the newly created customer
    //         $stmt = $conn->prepare("SELECT USER_ID FROM users WHERE USERNAME=? AND PHONE=?");
    //         $stmt->bind_param("ss", $customer_name, $phoneNo);
    //         $stmt->execute();
    //         $result = $stmt->get_result();
    //         $user_row = $result->fetch_assoc();
    //         $user_id = $user_row['USER_ID'];
    //     } else {
    //         echo "<script>alert('Error creating customer.');</script>";
    //         exit();
    //     }
    // } else {
    //     $user_id = $customer;
    // }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="" method="post">
    <?php

$sql="SELECT * FROM users WHERE USER_TYPE='OFF_CUSTOMER'";
$customer=mysqli_query($conn,$sql);
if($customer){
    $count=mysqli_num_rows($customer);

    
    echo " <select id='customerr' name='customerr' onchange='updatePrice()'>
        <option value='new'>Select existing customer</option>";

    for($i=0;$i<$count;$i++){
        $row=mysqli_fetch_array($customer);
        echo"   <option value='".$row['USER_ID']."' >".$row['USERNAME']." - ".$row['PHONE']."</option>";
    }
    echo "</select>";
}


?>
<input type="submit" name="submit" value="submit">
    </form>
</body>
</html>