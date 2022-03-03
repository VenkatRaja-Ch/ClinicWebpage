<?php
session_start();

if(isset($_SESSION['id']) && $_SESSION['id'] != null){
    echo $_SESSION['id'];
} else {
    echo '<h1> Access Fobidden.</h1>';
    echo '<a href="login.php"> Login </a>';
    exit;
}

$servername = "localhost";
$username = "clinicAdmin";
$password = "1234567890";
$dbname = "Clinic";


//creating connection
$conn = new mysqli($servername, $username, $password, $dbname);

//check connection
if($conn->connect_error){
    die("Connection Failed: ".$conn->connect_error);
}


$delete_message = false;
if(isset($_GET['action']) && $_GET['action'] == 'delete'){
    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $deleteSQL = "DELETE FROM services WHERE id=".$id;     
        $deleteResult = $conn->query($deleteSQL);
        $delete_message = true;
    }
}

if(isset($_GET['action']) && $_GET['action'] == 'edit'){
    if(isset($_GET['id'])){
        $result = $conn->query($sql);
    }
}

$sql = "SELECT id, name, descripiton, price FROM services"; 
$result = $conn->query($sql);
?>


<!DOCTYPE html>
<html>
    <head>
        <title>List of products</title>
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
    
    <form method="POST" action="addServices.php">       
        <input type="submit" name="add" value="Add a new Product">
    </form>
    
    <body>
        <h1><?php echo "List of products"; ?></h1>
        <?php
        if(isset($_GET['message']) && $_GET['message'] == 'add_product')
            echo '<h2>Serive has been added successfully.</h2>';
        if(isset($_GET['message']) && $_GET['message'] == 'edit_product')
            echo '<h2>Service has been updated successfully.</h2>';
        if ($delete_message) 
             echo '<h2>Service has been deleted successfully.</h2>';      
        ?>
        
        <table>
            <thead>
                <tr>
                    <td>Name</td>
                    <td>Description</td>
                    <td>Price</td>
                </tr>
            </thead>
                
            <tbody>
                <?php
                
                 if ($result->num_rows > 0) {
                    // output data of each row
                     
                    while($row = $result->fetch_assoc()) {
                        
                      echo "<tr>";  
                      echo "<td>".$row["name"]."</td>";
                      echo "<td>".$row["description"]."</td>";
                      echo "<td>".$row["price"]."</td>";
                      echo '<td>'
                      . '<a href="addServices.php?id='.$row["id"].'&action=edit" >Edit</a> &nbsp; '     
                      . '<a href="manageServices.php?id='.$row["id"].'&action=delete" >Delete</a> '; 
                      echo "</tr>";
                       }
                  } else {
                    echo "0 results";
                  }
                  $conn->close();

                ?>

            </tbody>
        </table>
        
        
    </body>
    
    <br>
    <a href="cart.php">Go to cart</a>
</html>
