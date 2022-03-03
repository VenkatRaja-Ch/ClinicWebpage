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
        <title>APPOINTMENT</title>
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
        <h1><?php echo "Order"; ?></h1>
        <h2>Cart</h2>
        <?php
            $cart = $_SESSION['cart'];
            $ids = implode(",", $cart);
            $sql = "SELECT id, name, price FROM services WHERE id in (".$ids.")";
            $result = $conn->query($sql);
        ?>
         <table>
            <thead>
                <tr>
                    <td>Name</td>
                    <td>Price</td>
                    <td>Quantity</td>
                </tr>
            </thead>
            <tbody>
                <?php
                 if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                      $cart = $_SESSION['cart'];
                      $quantity = 0;
                      foreach ($cart as $value) {
                          if ($value == $row["id"]){
                              $quantity++;
                          }
                      }

                      echo "<tr>";  
                      echo "<td>".$row["name"]."</td>";
                      echo "<td>".$row["price"]."</td>";
                      echo "<td>".$quantity."</td>";
                      echo "</tr>";
                       }
                  } else {
                    echo "0 results";
                  }
                  $conn->close();

                ?>

            </tbody>
        </table>
        
        <h2>Appointment Booking</h2>
        <form action="saveAppointment.php" method="post">
            Name: <input name="customer" type="text" > <br>
            Phone:<input name="phone" type="text" > <br>
            Date:<input name="date" type="date" > <br>
            <input type="submit" value="Book Appointment">
        </form>

        <br>
        <a href="cart.php">BACK TO CART</a> 

    </body>
</html>
