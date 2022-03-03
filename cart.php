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
        <title>Services in Cart</title>
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
        <h1><?php echo "Cart"; ?></h1>
        <?php
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
            $sql = "SELECT id, name, price FROM services WHERE id =" . $id;
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<h2>A new service is added to your cart:</h2>";
                    echo "id: " . $row["id"] . "<br>";
                    echo "name: " . $row["name"] . "<br>";
                    echo "price: " . $row["price"];
                }
            } else {
                echo "0 results";
            }

            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = [];
            }
            $cart = $_SESSION['cart'];
            $cart[] = $id;
            $_SESSION['cart'] = $cart;
        }
        ?>
        <?php
        $cart = $_SESSION['cart'];
        if (count($cart) >0) {
            $ids = implode(",", $cart);
            $sql = "SELECT id, name, price FROM services where id in (" . $ids . ")";
            $result = $conn->query($sql);
        }
        ?>
        <h2>Cart</h2>
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
                if (count($cart) >0) {
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $cart = $_SESSION['cart'];
                            $quantity = 0;
                            foreach ($cart as $value) {
                                if ($value == $row["id"]) {
                                    $quantity++;
                                }
                            }

                            echo "<tr>";
                            echo "<td>" . $row["name"] . "</td>";
                            echo "<td>" . $row["price"] . "</td>";
                            echo "<td>" . $quantity . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "0 results";
                    }
                }
                $conn->close();
                ?>

            </tbody>
        </table>

        <br>
        <a href="services.php">BACK TO SERVICE LIST</a> 

        <br>
        <a href="appointment.php">BOOK AN APPOINTMENT FOR THE SERVICES</a> 

    </body>
</html>