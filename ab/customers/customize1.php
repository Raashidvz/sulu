<?php
session_start();
// error_reporting(0);
error_reporting(E_ALL);
ini_set('display_errors', 1);
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fashion";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if($_SERVER["REQUEST_METHOD"] == "GET"){
   
    //check if the user logged in or not
    if($_SESSION["USER_ID"]==null){
         $_SESSION["KEY"]='to-customise-dress';
        // header("Location: login.php"); 
        echo "<script>alert('You need to login to customise dress'); window.location.href='login.php';</script>";
    }
    $_SESSION["image_url_for_db"]=null;
    

}


if (isset($_POST['order_customize'])) {

    // $image_dir = realpath(dirname(__FILE__)) . '/referrals/';
    // // $image_dir = "/opt/lampp/htdocs/ab/customers/referrals";


    // // Check if the directory exists; if not, create it
    // if (!is_dir($image_dir)) {
    //     if (!mkdir($image_dir, 0777, true)) {
    //         die("Failed to create directory. Please check permissions.");
    //     }
    // }

    // // Set the destination path for the uploaded file
    // $image_url = $image_dir . basename($_FILES["filepload"]["name"]);
    // $uploadfile=$_FILES['filepload']['tmp_name']

    // // Attempt to move the uploaded file
    // if (move_uploaded_file($uploadfile, $image_url)) {
    //     $file_upload_message = "File uploaded successfully.";

    //     // Use a relative path for storing in the database
    //     $image_url_for_db = "/referrals/" . basename($_FILES["filepload"]["name"]);
    //     $_SESSION["image_url_for_db"]=$image_url_for_db;

    // } else {
    //     $file_upload_message = "Error: Unable to upload the file. Please check directory permissions.";
    // }

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
    $additionalNotes = htmlspecialchars($_POST['additional-notes']);
    $current_date = date('Y-m-d');
    $estimate_date = date('Y-m-d', strtotime($current_date . ' + 9 days'));
    $actual_date = date('Y-m-d', strtotime($current_date . ' + 14 days'));

    if ($color == '#fff') {
        $color = "default";
    }
    
    //insert into measurement table
    if ($_SESSION["DRESS_ID"] == $dress_id || $dress_id!='none' && $fabric_id=='none') {
        echo "1st";
        $sql = "INSERT INTO measurements(USER_ID, DRESS_ID, SHOULDER, BUST, WAIST, HIP) 
                VALUES ('$_SESSION[USER_ID]', '$dress_id', '$shoulder', '$bust', '$waist', '$hips')";

        $sqx="SELECT * FROM measurements WHERE USER_ID='$_SESSION[USER_ID]' AND DRESS_ID='$dress_id' AND SHOULDER='$shoulder' AND BUST='$bust' AND WAIST='$waist' AND HIP='$hips'";
    }else if($dress_id=='none' && $fabric_id!='none'){
        echo "2nd";
        $sql = "INSERT INTO measurements(USER_ID, FABRIC_ID, SHOULDER, BUST, WAIST, HIP) 
                VALUES ('$_SESSION[USER_ID]', '$fabric_id', '$shoulder', '$bust', '$waist', '$hips')";

        $sqx="SELECT * FROM measurements WHERE USER_ID='$_SESSION[USER_ID]' AND FABRIC_ID='$fabric_id' AND SHOULDER='$shoulder' AND BUST='$bust' AND WAIST='$waist' AND HIP='$hips'";
    }else {
        echo "3rd";
        $sql = "INSERT INTO measurements(USER_ID, DRESS_ID, FABRIC_ID, SHOULDER, BUST, WAIST, HIP) 
                VALUES ('$_SESSION[USER_ID]', '$dress_id', '$fabric_id', '$shoulder', '$bust', '$waist', '$hips')";

        $sqx="SELECT * FROM measurements WHERE USER_ID='$_SESSION[USER_ID]' AND DRESS_ID='$dress_id' AND FABRIC_ID='$fabric_id' AND SHOULDER='$shoulder' AND BUST='$bust' AND WAIST='$waist' AND HIP='$hips'";
    }

    $measurent = mysqli_query($conn, $sql);
    if($measurent){
        //now get the measuremnt_id
        $m_data = mysqli_query($conn, $sqx);
        $m_row=mysqli_fetch_assoc($m_data);
        $m_id=$m_row['MEASUREMENT_ID'];
    }



    //insert into customization table
    if ($_SESSION["DRESS_ID"] == $dress_id || $dress_id!='none' && $fabric_id=='none') {
        $sql = "INSERT INTO customizations(DRESS_ID, MEASUREMENT_ID, COLOR, EMBELLISHMENTS, DRESS_LENGTH, SLEEVE_LENGTH, ADDITIONAL_NOTES ) 
                VALUES ('$dress_id', '$m_id', '$color', '$embellishments', '$dresslength', '$sleevelength', '$additionalNotes')";

    }else if($dress_id=='none' && $fabric_id!='none'){
        $sql = "INSERT INTO customizations( FABRIC_ID, MEASUREMENT_ID, COLOR, EMBELLISHMENTS, DRESS_LENGTH, SLEEVE_LENGTH, ADDITIONAL_NOTES ) 
                VALUES ( '$fabric_id', '$m_id', '$color', '$embellishments', '$dresslength', '$sleevelength', '$additionalNotes')";

    }else {
        $sql = "INSERT INTO customizations(DRESS_ID, FABRIC_ID, MEASUREMENT_ID, COLOR, EMBELLISHMENTS, DRESS_LENGTH, SLEEVE_LENGTH, ADDITIONAL_NOTES ) 
                VALUES ('$dress_id', '$fabric_id', '$m_id', '$color', '$embellishments', '$dresslength', '$sleevelength', '$additionalNotes')";

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
    if ($_SESSION["DRESS_ID"] == $dress_id) {
        $sql = "INSERT INTO orders(USER_ID, DRESS_ID , OPTION_ID , STATUSES, SSIZE, QUANTITY,  TOTAL_PRICE, CATEGORY , ESTIMATED_DELIVERY_DATE, ACTUAL_DELIVERY_DATE) 
                VALUES ('$_SESSION[USER_ID]', '$dress_id', '$o_id' , 'PENDING', '$sizes', '$quantity' , '$totalcost','DRESS_CUSTOMIZATION', '$estimate_date', '$actual_date')";
    }else if($dress_id=='none' && $fabric_id!='none'){
        $sql = "INSERT INTO orders(USER_ID, FABRIC_ID , OPTION_ID , STATUSES, SSIZE, QUANTITY, TOTAL_PRICE, CATEGORY , ESTIMATED_DELIVERY_DATE, ACTUAL_DELIVERY_DATE) 
                VALUES ('$_SESSION[USER_ID]', '$fabric_id', '$o_id' , 'PENDING', '$sizes', '$quantity' , '$totalcost','FULLY_CUSTOMIZATION', '$estimate_date', '$actual_date')";
    }else if($dress_id!='none' && $fabric_id=='none'){
        $sql = "INSERT INTO orders(USER_ID, DRESS_ID , OPTION_ID , STATUSES, SSIZE, QUANTITY, TOTAL_PRICE, CATEGORY , ESTIMATED_DELIVERY_DATE, ACTUAL_DELIVERY_DATE) 
                VALUES ('$_SESSION[USER_ID]', '$dress_id', '$o_id' , 'PENDING', '$sizes', '$quantity' , '$totalcost','FULLY_CUSTOMIZATION', '$estimate_date', '$actual_date')";
    }else {
        $sql = "INSERT INTO orders(USER_ID, DRESS_ID, FABRIC_ID , OPTION_ID , STATUSES, SSIZE, QUANTITY, TOTAL_PRICE, CATEGORY , ESTIMATED_DELIVERY_DATE, ACTUAL_DELIVERY_DATE) 
                VALUES ('$_SESSION[USER_ID]', '$dress_id', '$fabric_id', '$o_id' , 'PENDING', '$sizes', '$quantity' , '$totalcost','FULLY_CUSTOMIZATION', '$estimate_date', '$actual_date')";
    }

    $odata = mysqli_query($conn, $sql);

    if ($odata) {
        echo "<script>alert('Customized dress order placed successfully!'); window.location.href='custmrdshbrd.php';</script>";
        // echo $file_upload_message;
    }

}


//save customization to cart
if (isset($_POST['save_customize'])) {

    // Define the target directory
    $targetDir = "referrals/";

    // Check if the directory exists; if not, create it
    if (!file_exists($targetDir)) {
        mkdir($targetDir, 0777, true); // Create directory with permissions
    }

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
    $additionalNotes = htmlspecialchars($_POST['additional-notes']);
    $current_date = date('Y-m-d');
    $estimate_date = date('Y-m-d', strtotime($current_date . ' + 9 days'));
    $actual_date = date('Y-m-d', strtotime($current_date . ' + 14 days'));

    if ($color == '#fff') {
        $color = "default";
    }
    
    //insert into measurement table
    if ($_SESSION["DRESS_ID"] == $dress_id || $dress_id!='none' && $fabric_id=='none') {
        echo "1st";
        $sql = "INSERT INTO measurements(USER_ID, DRESS_ID, SHOULDER, BUST, WAIST, HIP) 
                VALUES ('$_SESSION[USER_ID]', '$dress_id', '$shoulder', '$bust', '$waist', '$hips')";

        $sqx="SELECT * FROM measurements WHERE USER_ID='$_SESSION[USER_ID]' AND DRESS_ID='$dress_id' AND SHOULDER='$shoulder' AND BUST='$bust' AND WAIST='$waist' AND HIP='$hips'";
    }else if($dress_id=='none' && $fabric_id!='none'){
        echo "2nd";
        $sql = "INSERT INTO measurements(USER_ID, FABRIC_ID, SHOULDER, BUST, WAIST, HIP) 
                VALUES ('$_SESSION[USER_ID]', '$fabric_id', '$shoulder', '$bust', '$waist', '$hips')";

        $sqx="SELECT * FROM measurements WHERE USER_ID='$_SESSION[USER_ID]' AND FABRIC_ID='$fabric_id' AND SHOULDER='$shoulder' AND BUST='$bust' AND WAIST='$waist' AND HIP='$hips'";
    }else {
        echo "3rd";
        $sql = "INSERT INTO measurements(USER_ID, DRESS_ID, FABRIC_ID, SHOULDER, BUST, WAIST, HIP) 
                VALUES ('$_SESSION[USER_ID]', '$dress_id', '$fabric_id', '$shoulder', '$bust', '$waist', '$hips')";

        $sqx="SELECT * FROM measurements WHERE USER_ID='$_SESSION[USER_ID]' AND DRESS_ID='$dress_id' AND FABRIC_ID='$fabric_id' AND SHOULDER='$shoulder' AND BUST='$bust' AND WAIST='$waist' AND HIP='$hips'";
    }

    $measurent = mysqli_query($conn, $sql);
    if($measurent){
        //now get the measuremnt_id
        $m_data = mysqli_query($conn, $sqx);
        $m_row=mysqli_fetch_assoc($m_data);
        $m_id=$m_row['MEASUREMENT_ID'];
    }



    //insert into customization table
    if ($_SESSION["DRESS_ID"] == $dress_id || $dress_id!='none' && $fabric_id=='none') {
        $sql = "INSERT INTO customizations(DRESS_ID, MEASUREMENT_ID, COLOR, EMBELLISHMENTS, DRESS_LENGTH, SLEEVE_LENGTH, ADDITIONAL_NOTES) 
                VALUES ('$dress_id', '$m_id', '$color', '$embellishments', '$dresslength', '$sleevelength', '$additionalNotes')";

    }else if($dress_id=='none' && $fabric_id!='none'){
        $sql = "INSERT INTO customizations( FABRIC_ID, MEASUREMENT_ID, COLOR, EMBELLISHMENTS, DRESS_LENGTH, SLEEVE_LENGTH, ADDITIONAL_NOTES) 
                VALUES ( '$fabric_id', '$m_id', '$color', '$embellishments', '$dresslength', '$sleevelength', '$additionalNotes')";

    }else {
        $sql = "INSERT INTO customizations(DRESS_ID, FABRIC_ID, MEASUREMENT_ID, COLOR, EMBELLISHMENTS, DRESS_LENGTH, SLEEVE_LENGTH, ADDITIONAL_NOTES) 
                VALUES ('$dress_id', '$fabric_id', '$m_id', '$color', '$embellishments', '$dresslength', '$sleevelength', '$additionalNotes')";

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
    if ($_SESSION["DRESS_ID"] == $dress_id) {
        $sql = "INSERT INTO orders(USER_ID, DRESS_ID , OPTION_ID , STATUSES, SSIZE, QUANTITY , TOTAL_PRICE, CATEGORY , ESTIMATED_DELIVERY_DATE, ACTUAL_DELIVERY_DATE) 
                VALUES ('$_SESSION[USER_ID]', '$dress_id', '$o_id' , 'CART', '$sizes','$quantity' , '$totalcost','DRESS_CUSTOMIZATION', '$estimate_date', '$actual_date')";
    }else if($dress_id=='none' && $fabric_id!='none'){
        $sql = "INSERT INTO orders(USER_ID, FABRIC_ID , OPTION_ID , STATUSES, SSIZE, QUANTITY , TOTAL_PRICE, CATEGORY , ESTIMATED_DELIVERY_DATE, ACTUAL_DELIVERY_DATE) 
                VALUES ('$_SESSION[USER_ID]', '$fabric_id', '$o_id' , 'CART', '$sizes','$quantity' , '$totalcost','FULLY_CUSTOMIZATION', '$estimate_date', '$actual_date')";
    }else if($dress_id!='none' && $fabric_id=='none'){
        $sql = "INSERT INTO orders(USER_ID, DRESS_ID , OPTION_ID , STATUSES, SSIZE, QUANTITY , TOTAL_PRICE, CATEGORY , ESTIMATED_DELIVERY_DATE, ACTUAL_DELIVERY_DATE) 
                VALUES ('$_SESSION[USER_ID]', '$dress_id', '$o_id' , 'CART', '$sizes','$quantity' , '$totalcost','FULLY_CUSTOMIZATION', '$estimate_date', '$actual_date')";
    }else {
        $sql = "INSERT INTO orders(USER_ID, DRESS_ID, FABRIC_ID , OPTION_ID , STATUSES, SSIZE, QUANTITY , TOTAL_PRICE, CATEGORY , ESTIMATED_DELIVERY_DATE, ACTUAL_DELIVERY_DATE) 
                VALUES ('$_SESSION[USER_ID]', '$dress_id', '$fabric_id', '$o_id' , 'CART', '$sizes','$quantity' , '$totalcost','FULLY_CUSTOMIZATION', '$estimate_date', '$actual_date')";
    }

    $odata = mysqli_query($conn, $sql);

    if ($odata) {
        echo "<script>alert('Customisation saved to cart!'); window.location.href='custmrdshbrd.php';</script>";
        // echo "ORDER PLACED SUCCESSFULLY";
    }
    
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customize Your Dress</title>
    <link rel="stylesheet" href="custStyle.css">
</head>

<body>
    <div class="navbar">
        <a href="custmrdshbrd.php">Home</a>
        <a href="fabric.php">Fabric</a>
        <a href="abt.php">About</a>
        <a href="contact1.php">Contact</a>
        <?php
            if($_SESSION["USER_ID"]==null){
            echo "<a href='login.php'>Login</a>";
            }else{
                echo "<a href='logout.php'>Logout</a>";
                echo "<a href='profile.php'>Profile</a>";
            }
        ?>
        <a href="customize1.php" class="customize-button">Customize Now</a>
    </div>

    <div class="container">
        <h2>Customize Your Dress</h2>

        <form id="customization-form" method="POST" action="">
            <div class="form-group">
                <?php
                    if($_SESSION["DRESS_ID"]==null){

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
                        }
                        echo "</select>";
                    }else{
                        $sql="SELECT * FROM dress WHERE DRESS_ID=".$_SESSION["DRESS_ID"]."";
                        $data=mysqli_query($conn,$sql);
                        if($data){
                            $dress=mysqli_fetch_array($data);
                            echo "<label for='dress-style'>Your Dress Style:</label>
                                <select id='dress-style' name='dress-style' onchange='updatePrice()'>
                                    <option value='".$dress['DRESS_ID']."' data-price='".$dress['BASE_PRICE']."'>".$dress['NAME']." - ₹".$dress['BASE_PRICE']."</option>
                                </select>";
                        }
                        
                    }
                ?>
            </div>

            <div class="form-group">

            <?php
                    if($_SESSION["DRESS_ID"]==null){

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
                        }
                        echo "</select>";
                    }else{
                        $sql="SELECT * FROM dress WHERE DRESS_ID=".$_SESSION["DRESS_ID"]."";
                        $data=mysqli_query($conn,$sql);
                        if($data){
                            $dress=mysqli_fetch_array($data);
                            echo "<label for='fabric'>Choose Fabric(Per meter):</label>
                                    <select id='fabric' name='fabric' onchange='updatePrice()'>
                                    <option value='none' data-price='0'>".$dress['FABRIC']."</option>
                                </select>";
                        }
                        
                    }
                ?>

            </div>

            <!-- <div class="form-group">
                <label for="color">Select Color:</label>
                <input type="color" id="color" name="color">
            </div> -->

            <div class="form-group">
            <label for="color">Select Color:</label>
            <select id="color" name="color" onchange="updateBackgroundColor()">
                <?php
                    if($_SESSION["DRESS_ID"]==null){
                        echo "<option value='#fff'>Select color</option>";
                    }else{
                        $sql="SELECT COLOR FROM dress WHERE DRESS_ID=".$_SESSION["DRESS_ID"]."";
                        $data=mysqli_query($conn,$sql);
                        if($data){
                            $color=mysqli_fetch_array($data);
                            echo "<option value='#fff'>".$color[0]."</option>";
                        }
                        
                    }
                ?>
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
                <!-- <p style="color:palevioletred">(Price may vary depending on the complexity of the design)</p> -->
            </div>
            <div class="form-group">
                <label for=""></label>
                
                <p style="color:palevioletred">(Price may vary depending on the complexity of the design)</p>
            </div>

            <div class="form-group">
                <label for="sizes">Choose Size:</label>
                <select id="sizes" name="sizes">
                    <?php
                        if($_SESSION["SIZE"]!=null){
                            echo "<option value='".$_SESSION["SIZE"]."'>".strtoupper($_SESSION["SIZE"])."</option>";
                        }
                    ?>
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
                <input type="text" id="shoulder" name="shoulder" placeholder="shoulder" >
                <input type="text" id="bust" name="bust" placeholder="Bust" >
                <input type="text" id="waist" name="waist" placeholder="Waist" >
                <input type="text" id="hips" name="hips" placeholder="Hips" >
            </div>

            <div class="form-group">
                <label for="quantity">Enter quantity:</label>
                <input type="number" id="quantity" name="quantity" placeholder="Default 1" >
            </div>

            <div class="form-group">
                <label for="additional-notes">Additional Notes:</label>
                <textarea id="additional-notes" name="additional-notes" placeholder="Enter any special requests..."></textarea>
            </div>
            <div class="form-group">
                <label for="filepload">Upload file:</label>
                <input type="file" id="filepload" name="filepload">
            </div>

            <h3>Total Price: ₹<span id="total-price" name="total-price">0</span></h3>
            <input type="hidden" id="hiddenTotalPrice" name="total-price">
            <!-- <button type="submit">Preview Customization</button> -->
        
            <button type="submit" name="save_customize">Save customization</button>
            <div style="height: 10px; width: 100%;"></div>
            <button type="submit" name="order_customize" onclick="return confirmPurchase();">Order customization</button>
        </form>
        <script>
            function confirmPurchase() {
                return confirm("Are you sure you want to buy this order?");
            }
        </script>

        <?php if (isset($message)): ?>
            <p><?php echo $message; ?></p>
        <?php endif; ?>
    </div>

    <div class="footer">
        <p>&copy; 2024 Women's Boutique. All Rights Reserved.</p>
    </div>

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
        // function setDefaultValue(input) {
        //     if (input.value.trim() === '') {
        //         input.value = '0.0'; // Set the default value
        //     }
        // }

        document.addEventListener("DOMContentLoaded", updatePrice);
    </script>
</body>
</html>