<?php
session_start();

$servername = 'localhost';
$username = 'clinicAdmin';
$password = '1234567890';
$dbname = 'Clinic';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>


<!DOCTYPE html>
<html>
    <head>
        <title>Cart</title>
        <meta charset="utf8">
        <style>
            table {
                width: 100%;
                border-collapse: collapse;
            }

            table, td {
                border: 1px solid black;
            }
        </style>
    </head>
    <body>
        <?php
        $customer = $_POST['customer'];
        $phone = $_POST['phone'];
        $date = $_POST['date'];
        
        $sql= "INSERT INTO bookings (customer, phone, date) VALUES ('".$customer."','".$phone."',STR_TO_DATE('".$date."','%m-%d-%y'))";
        $result = $conn->query($sql);
        
        if ($result === TRUE) {
            $last_id = $conn->insert_id;
            
            $cart = $_SESSION['cart'];
            
            $new_cart = [];
            foreach($cart as $value) {
                if (!in_array($value, $new_cart)){
                    $new_cart[] = $value;
                }
            }         
            
            foreach ($new_cart as $value) {
                $quantity = 0;
                foreach ($cart as $product) {
                    if ($product == $value){
                        $quantity++;
                    }
                }
                        
                $sql= "INSERT INTO bookedServices (idBooking, idService, quantity) VALUES (".$last_id.",".$value.",".$quantity.")";
                $result = $conn->query($sql);
            }
            
            
            echo "Your appointment was booked SUCCESSFULLY.";
            $_SESSION['cart'] = [];
          } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
          }
        ?>
        <br>
        <a href="services.php">BACK TO SERVICE LIST</a> 
    </body>
</html>