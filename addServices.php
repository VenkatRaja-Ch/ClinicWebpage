<!--To be looked at-->

<?php
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

if(isset($_POST['submit'])){
    $id = $_POST['id'];
    $name = $_POST['product'];                    // <----  to be checked
    $description = $_POST['description'];
    $price = $_POST['price'];
    
    if ($id == '') {
          $sql = "INSERT INTO `services` VALUES (NULL, '".$name."', '".$price."')";
          $result = $conn->query($sql);
          header('Location: manageServices.php?message=add_product');
    } else {
         $sql = "UPDATE `products` SET name = '".$name."',price='".$price."'WHERE id = ". $id;
         $result = $conn->query($sql);
         header('Location: manageServices.php?message=edit_product');
    }
    
}

?>


<!-- HTML part-->

<!DOCTYPE html>
<html>
    <head>
        <title>Add product</title>
        <meta charset="utf8">

    </head>
    <body>
        <h1><?php 
            if(isset($_GET['action']) && $_GET['action']== 'edit') {
                 echo "Edit product";
            } else {
                echo "Add product"; 
            }
        ?></h1>
        
        <?php
        
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
        $id = '';
        $name = '';
        $description = '';
        $price = '';
        if(isset($_GET['action']) && $_GET['action']== 'edit') {
               $sql = "SELECT id, name, description, price FROM services WHERE id =". $_GET['id'];
               $result = $conn->query($sql);
               if ($result->num_rows > 0) {
                   while($row = $result->fetch_assoc()) {
                       $id = $row["id"];
                       $name = $row["name"];
                       $description = $row['description'];
                       $price = $row["price"];
                   }
               }
        }
        $conn->close();
        
        ?>
    
        <form method="POST" action="addServices.php">
            <input type="hidden" name="id" value="<?php echo $id; ?>" >
            Name: <input type="text" name="name" value="<?php echo $name; ?>"><br><br>
            Description: <input type="text" name="description" value="<?php echo $description; ?>"><br><br>
            Price:<input type="text" name="price" value="<?php echo $price; ?>"><br><br>
            <input type="submit" name="submit" value="Save">
        </form>

    </body>
</html>
