<?php
// Start the session
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fashion";

$conn = new mysqli($servername, $username, $password, $dbname);

//Place order
if (isset($_POST['order_customize'])) {

    $customer = htmlspecialchars($_POST['customer']);

    $dress_id = htmlspecialchars($_POST['dress-style']);
    $fabric_id = htmlspecialchars($_POST['fabric']);
    $color = htmlspecialchars($_POST['color']);
    $embellishments = htmlspecialchars($_POST['embellishments']);
    $sizes = htmlspecialchars($_POST['sizes']);
    $dresslength = htmlspecialchars($_POST['dresslength']);
    $sleevelength = htmlspecialchars($_POST['sleevelength']);
    // $shoulder = htmlspecialchars($_POST['shoulder']);
    // $bust = htmlspecialchars($_POST['bust']);
    // $waist = htmlspecialchars($_POST['waist']);
    // $hips = htmlspecialchars($_POST['hips']);

    $shoulder = $_POST['shoulder'] ? $_POST['shoulder']: 0.0;
    $bust = $_POST['bust'] ? $_POST['bust']: 0.0;
    $waist = $_POST['waist'] ? $_POST['waist']: 0.0;
    $hips = $_POST['hips'] ? $_POST['hips']: 0.0;

    $quantity = $_POST['quantity'] ? $_POST['quantity']: 1;

    $totalcost = htmlspecialchars($_POST['total-price']);
    $current_date = date('Y-m-d');
    $estimate_date = date('Y-m-d', strtotime($current_date . ' + 9 days'));
    $actual_date = date('Y-m-d', strtotime($current_date . ' + 14 days'));

    if ($color == '#fff') {
        $color = "default";
    }



    //insert into user table
    if($customer==0){
        $customer_name = htmlspecialchars($_POST['customerName']);
        $phoneNo = htmlspecialchars($_POST['phoneNo']);
        $address = htmlspecialchars($_POST['address']);

        $sql="INSERT INTO users (USERNAME, PASSWORDD, PHONE, USER_TYPE,  ADDRESSS) VALUES ('$customer_name','$phoneNo','$phoneNo', 'OFF_CUSTOMER','$address')";
        $new_user=mysqli_query($conn,$sql);
        if($new_user){
            $sqx="SELECT * FROM users WHERE USERNAME='$customer_name' AND PASSWORDD='$phoneNo' AND PHONE='$phoneNo'";
            $user_data=mysqli_query($conn,$sqx);
            $user_row=mysqli_fetch_array($user_data);
            $user_id=$user_row['USER_ID'];

        }
    }else{
        $user_id=$customer;
    }
    

    
    //insert into measurement table
    if ( $dress_id!='none' && $fabric_id=='none') {
        echo "1st";
        $sql = "INSERT INTO measurements(USER_ID, DRESS_ID, SHOULDER, BUST, WAIST, HIP) 
                VALUES ('$user_id', '$dress_id', '$shoulder', '$bust', '$waist', '$hips')";

        $sqx="SELECT * FROM measurements WHERE USER_ID='$user_id' AND DRESS_ID='$dress_id' AND SHOULDER='$shoulder' AND BUST='$bust' AND WAIST='$waist' AND HIP='$hips'";
    }else if($dress_id=='none' && $fabric_id!='none'){
        echo "2nd";
        echo $fabric_id;
        $sql = "INSERT INTO measurements(USER_ID, FABRIC_ID, SHOULDER, BUST, WAIST, HIP) 
                VALUES ('$user_id', '$fabric_id', '$shoulder', '$bust', '$waist', '$hips')";

        $sqx="SELECT * FROM measurements WHERE USER_ID='$user_id' AND FABRIC_ID='$fabric_id' AND SHOULDER='$shoulder' AND BUST='$bust' AND WAIST='$waist' AND HIP='$hips'";
    }else if($dress_id!='none' && $fabric_id!='none'){
        echo "3rd";
        echo $customer;
        $sql = "INSERT INTO measurements(USER_ID, DRESS_ID, FABRIC_ID, SHOULDER, BUST, WAIST, HIP) 
                VALUES ('$user_id', '$dress_id', '$fabric_id', '$shoulder', '$bust', '$waist', '$hips')";

        $sqx="SELECT * FROM measurements WHERE USER_ID='$user_id' AND DRESS_ID='$dress_id' AND FABRIC_ID='$fabric_id' AND SHOULDER='$shoulder' AND BUST='$bust' AND WAIST='$waist' AND HIP='$hips'";
    }else{
        $sql = "INSERT INTO measurements(USER_ID, SHOULDER, BUST, WAIST, HIP) 
                VALUES ('$user_id', '$shoulder', '$bust', '$waist', '$hips')";

        $sqx="SELECT * FROM measurements WHERE USER_ID='$user_id' AND DRESS_ID IS NULL AND FABRIC_ID IS NULL AND SHOULDER='$shoulder' AND BUST='$bust' AND WAIST='$waist' AND HIP='$hips'";
    }

    $measurent = mysqli_query($conn, $sql);
    if($measurent){
        //now get the measuremnt_id
        $m_data = mysqli_query($conn, $sqx);
        $m_row=mysqli_fetch_assoc($m_data);
        $m_id=$m_row['MEASUREMENT_ID'];
    }



    //insert into customization table
    if ($dress_id!='none' && $fabric_id=='none') {
        $sql = "INSERT INTO customizations(DRESS_ID, MEASUREMENT_ID, COLOR, EMBELLISHMENTS, DRESS_LENGTH, SLEEVE_LENGTH) 
                VALUES ('$dress_id', '$m_id', '$color', '$embellishments', '$dresslength', '$sleevelength')";

    }else if($dress_id=='none' && $fabric_id!='none'){
        $sql = "INSERT INTO customizations( FABRIC_ID, MEASUREMENT_ID, COLOR, EMBELLISHMENTS, DRESS_LENGTH, SLEEVE_LENGTH) 
                VALUES ( '$fabric_id', '$m_id', '$color', '$embellishments', '$dresslength', '$sleevelength')";

    }else if($dress_id!='none' && $fabric_id!='none'){
        $sql = "INSERT INTO customizations(DRESS_ID, FABRIC_ID, MEASUREMENT_ID, COLOR, EMBELLISHMENTS, DRESS_LENGTH, SLEEVE_LENGTH) 
                VALUES ('$dress_id', '$fabric_id', '$m_id', '$color', '$embellishments', '$dresslength', '$sleevelength')";

    }else{
        $sql = "INSERT INTO customizations( MEASUREMENT_ID, COLOR, EMBELLISHMENTS, DRESS_LENGTH, SLEEVE_LENGTH) 
                VALUES ('$m_id', '$color', '$embellishments', '$dresslength', '$sleevelength')";
    }

    $cdata = mysqli_query($conn, $sql);

    if ($cdata){
        //now get the option_id
        $sqx="SELECT * FROM customizations WHERE MEASUREMENT_ID='$m_id'";
        $c_data = mysqli_query($conn, $sqx);
        $c_row=mysqli_fetch_assoc($c_data);
        $o_id=$c_row['OPTION_ID'];
    }


    //insert into orders table
    if($dress_id=='none' && $fabric_id!='none'){
        $sql = "INSERT INTO orders(USER_ID, FABRIC_ID , OPTION_ID , STATUSES, SSIZE, QUANTITY, TOTAL_PRICE, CATEGORY , ESTIMATED_DELIVERY_DATE, ACTUAL_DELIVERY_DATE) 
                VALUES ('$user_id', '$fabric_id', '$o_id' , 'PENDING', '$sizes', '$quantity' , '$totalcost','OFFLINE_PURCHASE', '$estimate_date', '$actual_date')";
    }else if($dress_id!='none' && $fabric_id=='none'){
        $sql = "INSERT INTO orders(USER_ID, DRESS_ID , OPTION_ID , STATUSES, SSIZE, QUANTITY, TOTAL_PRICE, CATEGORY , ESTIMATED_DELIVERY_DATE, ACTUAL_DELIVERY_DATE) 
                VALUES ('$user_id', '$dress_id', '$o_id' , 'PENDING', '$sizes', '$quantity' , '$totalcost','OFFLINE_PURCHASE', '$estimate_date', '$actual_date')";
    }else if($dress_id!='none' && $fabric_id!='none'){
        $sql = "INSERT INTO orders(USER_ID, DRESS_ID, FABRIC_ID , OPTION_ID , STATUSES, SSIZE, QUANTITY, TOTAL_PRICE, CATEGORY , ESTIMATED_DELIVERY_DATE, ACTUAL_DELIVERY_DATE) 
                VALUES ('$user_id', '$dress_id', '$fabric_id', '$o_id' , 'PENDING', '$sizes', '$quantity' , '$totalcost','OFFLINE_PURCHASE', '$estimate_date', '$actual_date')";
    }else{
        $sql = "INSERT INTO orders(USER_ID, OPTION_ID , STATUSES, SSIZE, QUANTITY, TOTAL_PRICE, CATEGORY , ESTIMATED_DELIVERY_DATE, ACTUAL_DELIVERY_DATE) 
                VALUES ('$user_id', '$o_id' , 'PENDING', '$sizes', '$quantity' , '$totalcost','OFFLINE_PURCHASE', '$estimate_date', '$actual_date')";
    }

    $odata = mysqli_query($conn, $sql);

    if ($odata) {
        echo "<script>alert('Order placed successfully!'); window.location.href='measurement.php';</script>";
    }

}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Measurements</title>
    <link rel="stylesheet" href="staf.css">
    <link rel="stylesheet" href="custStyle2.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <style>
        .navbar {
            background-color: #4a4e69; /* Dark purple */
            padding: 15px 0;
            text-align: center;
        }
        .navbar a {
            color: #fff;
            padding: 14px 20px;
            text-decoration: none;
            display: inline-block;
        }

        .table-container {
            padding: 0 20px; /* Adds padding to both left and right sides of the table */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            color: #333;
        }
        .measurement-form{
            padding:10px;
            padding-left: 23px;
        }
        #customer{
            width:100%;
        }

        /* Optional styling for mobile responsiveness */
        @media screen and (max-width: 768px) {
            .table-container {
                padding: 0 10px; /* Reduce padding on smaller screens */
            }
            table, th, td {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <div class="navbar">
        <a href="staffdshbrd.php">Home</a>
        <a href="ManageOrder.php">Orders</a>
        <a href="measurement.php">Measurement</a>
        <?php
        if (!isset($_SESSION["STAFF"])) {
            echo "<a href='login.php'>Login</a>";
        } else {
            echo "<a href='logout.php'>Logout</a>";
            echo "<a href='staff_profile.php'>Profile</a>";
        }
        ?>
    </div>
    <div class="container">
        <!-- customer details  -->
        <h2>Customer details</h2>
        <form method="POST" action="">
        <div class="form-group">
            <?php

                $sql="SELECT * FROM users WHERE USER_TYPE='OFF_CUSTOMER'";
                $customer=mysqli_query($conn,$sql);
                if($customer){
                    $count=mysqli_num_rows($customer);

                    echo "
                        <select id='customer' name='customer' onchange='updatePrice()'>
                            <option value=0>Select existing customer</option>";

                    for($i=0;$i<$count;$i++){
                        $row=mysqli_fetch_array($customer);
                        echo"   <option value='".$row['USER_ID']."' >".$row['USERNAME']."</option>";
                    }
                }
                echo "</select>";
                
            ?>

        </div>
        <div class="form-group">
                <input type="text" id="customerName" name="customerName" placeholder="Name">
                <input type="text" id="phoneNo" name="phoneNo" placeholder="Phone Number">
                <input type="text" id="address" name="address" placeholder="Address">  
        </div>

        <!-- order details  -->
        <h2>Order details</h2>

            <!-- select dress  -->
            <div class="form-group">
                <?php
                    
                    $sql="SELECT * FROM dress";
                    $dress=mysqli_query($conn,$sql);
                    if($dress){
                        $count=mysqli_num_rows($dress);

                        echo "<label for='dress-style'>Select Dress Style:</label>
                        <select id='dress-style' name='dress-style' onchange='updatePrice()'>
                        <option value='none' data-price='0'>None</option>";
                        for($i=0;$i<$count;$i++){
                            $row=mysqli_fetch_array($dress);
                            echo"   <option value='".$row['DRESS_ID']."' data-price='".$row['BASE_PRICE']."'>".$row['NAME']." - ₹".$row['BASE_PRICE']."</option>";
                        }
                        echo "</select>";
                    }
                    
                    
                ?>
            </div>

            <!-- select fabric -->
            <div class="form-group">
                <?php

                    $sql="SELECT * FROM fabrics";
                    $fabrics=mysqli_query($conn,$sql);
                    if($fabrics){
                        $count=mysqli_num_rows($fabrics);

                        echo "<label for='fabric'>Choose Fabric(Per meter):</label>
                            <select id='fabric' name='fabric' onchange='updatePrice()'>
                            <option value='none' data-price='0'>None</option>";
                          
                        for($i=0;$i<$count;$i++){
                            $row=mysqli_fetch_array($fabrics);
                            echo"   <option value='".$row['FABRIC_ID']."' data-price='".$row['PRICE_PER_UNIT']."'>".$row['NAME']." - ₹".$row['PRICE_PER_UNIT']."</option>";
                        }
                        echo "</select>";
                    }
                    
                    
                ?>

            </div>

            
            <!-- select color  -->
            <div class="form-group">
            <label for="color">Select Color:</label>
            <select id="color" name="color" onchange="updateBackgroundColor()">
                <option value="#fff">Select color</option>
                <option value="#FF0000">Red</option>
                <option value="#E4080A">Dark Red</option>
                <option value="#0000FF">Blue</option>
                <option value="#FFFF00">Yellow</option>
                <option value="#FFA500">Orange</option>
                <option value="#800080">Purple</option>
                <option value="#00FFFF">Aqua</option>
                <option value="#008080">Teal</option>
                <option value="#000080">Navy</option>
                <option value="#808000">Olive</option>
                <option value="#00FF00">Lime</option>
                <option value="#FF00FF">Fuchsia</option>
                <option value="#800000">Maroon</option>
                <option value="#808080">Grey</option>
                <option value="#C0C0C0">Silver</option>
                <option value="#FFFFFF">White</option>
                <option value="#000000">Black</option>
            </select>
            </div>

            <div class="form-group">
                <label for="embellishments">Add Embellishments(Per meter):</label>
                <select id="embellishments" name="embellishments" onchange="updatePrice()">
                    <option value="none" data-price="0">None</option>
                    <option value="BEADS" data-price="50">BEADS - +₹50</option>
                    <option value="SEQUIN" data-price="100">SEQUINS - +₹100</option>
                    <option value="EMBROIDERY" data-price="0">EMBROIDERY - +₹150 </option>
                    <option value="APPLIQUE" data-price="15">APPLIQUÉ - + ₹50</option>
                    <option value="LACE" data-price="20">LACE - +₹100</option>
                    <option value="FRINGE" data-price="0">FRINGE - +₹100</option>
                    <option value="PEARL" data-price="15">PEARL - +₹200 </option>
                    <option value="PIPING" data-price="20">PIPING - +₹50</option>
                    <option value="RHINESTONE" data-price="20">RHINESTONE - +₹150</option>

                </select>
            </div>

            <div class="form-group">
                <label for=""></label>
                <p style="color:#9a7bba">(Price may vary depending on the complexity of the design)</p>
            </div>

            <div class="form-group">
                <label for="sizes">Choose Size:</label>
                <select id="sizes" name="sizes">
                    <option value="xs">XS</option>
                    <option value="s">S</option>
                    <option value="m">M</option>
                    <option value="l">L</option>
                    <option value="xl">XL</option>
                    <option value="xxl">XXL</option>
                </select>
            </div>
                <div class="form-group">
                <label for="dresslength">Dress Length:</label>
                <select id="dresslength" name="dresslength">
                    <option value="MINI">MINI</option>
                    <option value="KNEE-LENGTH">KNEE-LENGTH</option>
                    <option value="TEA-LENGTH">TEA-LENGTH</option>
                    <option value="MIDI">MIDI</option>
                    <option value="MAXI">MAXI</option>
                    <option value="FULL-LENGTH">FULL-LENGTH</option>
                </select>
            </div>

            <div class="form-group">
                <label for="sleevelength">Sleeve Length:</label>
                <select id="sleevelength" name="sleevelength">
                    <option value="sleeveless">SLEEVELESS</option>
                    <option value="short">SHORT</option>
                    <option value="elbow">ELBOW</option>
                    <option value="3/4">3/4</option>
                    <option value="full">FULL-LENGTH</option>
                    </select>
            </div>

            <div class="form-group">
                <label for="measurements">Enter Measurements (in inches):</label>
                <input type="text" id="shoulder" name="shoulder" placeholder="shoulder">
                <input type="text" id="bust" name="bust" placeholder="Bust">
                <input type="text" id="waist" name="waist" placeholder="Waist">
                <input type="text" id="hips" name="hips" placeholder="Hips">
            </div>

            <div class="form-group">
                <label for="quantity">Enter quantity:</label>
                <input type="number" id="quantity" name="quantity" placeholder="Default 1" >
            </div>

            <h3>Total Price: ₹<span id="total-price" name="total-price">0</span></h3>
            <input type="hidden" id="hiddenTotalPrice" name="total-price">
        

            <button type="submit" name="order_customize" onclick="return confirmPurchase();">Place order</button>
        </form>
        <script>
            function confirmPurchase() {
                return confirm("Are you sure you want to buy this order?");
            }
        </script>
        <script>
        function updatePrice() {
            const dressStyle = document.getElementById('dress-style');
            const fabric = document.getElementById('fabric');
            const embellishments = document.getElementById('embellishments');
            
            const dressPrice = parseInt(dressStyle.options[dressStyle.selectedIndex].getAttribute('data-price'));
            const fabricPrice = parseInt(fabric.options[fabric.selectedIndex].getAttribute('data-price'));
            const embellishmentsPrice = parseInt(embellishments.options[embellishments.selectedIndex].getAttribute('data-price'));
            
            const totalPrice = dressPrice + fabricPrice + embellishmentsPrice;
            document.getElementById('total-price').innerText = totalPrice;
            // Set the hidden field value
            document.getElementById('hiddenTotalPrice').value = totalPrice;
        }
        function updateBackgroundColor() {
            var selectElement = document.getElementById("color");
            var selectedColor = selectElement.value;
            selectElement.style.backgroundColor = selectedColor;
        }

        document.addEventListener("DOMContentLoaded", updatePrice);
    </script>

        <?php if (isset($message)): ?>
            <p><?php echo $message; ?></p>
        <?php endif; ?>
    </div>
</body>
</html>
