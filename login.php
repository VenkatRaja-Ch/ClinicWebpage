<?php
session_start();
if(isset($_POST['submit'])){
    $form_username = $_POST['username'];
    $form_password = $_POST['password'];
    
    $hash = md5($form_password);
    
    $id = null;
    
    $servername = 'localhost';
    $username = 'clinicAdmin';
    $password = '1234567890';
    $dbname = 'Clinic';
    
    //creating sql connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    //checking connection
    if($conn -> connect_error){
        die("Connection Failed: ".$conn->connect_error);
    }
    
    //if connected
    $sql = "SELECT * FROM user WHERE username='".$form_username."' AND password='".$hash."'";
    var_dump($sql);
    
    $result = $conn->query($sql);

    if($result->num_rows == 1){
        
        //user is existing in the database
        while($row = $result ->fetch_assoc()){
            $id = $row["id"];
        }
    }
    
    if($id == null){
        $_SESSION["id"] = null;
        $message = "Login Failed";
    }
    else {
        $_SESSION["id"] = $id;
        var_dump($id);
        header('Location: manageServices.php');           
    } 
}
?>

<!--HTML PART-->
<!<!doctype html>
<html>
    <head>
        <title>Admin Login | Clinic</title>
        <meta charset="utf8">
        <style>
            .parent{
                text-align: center;
                position: absolute;
                top:50%;
                left:50%;
                transform: translate(-50%, -50%);
            }
            .container{
                background:linear-gradient(to right, rgb(142,45,226), rgb(74,0,224));
                height: 420px;
                width: 330px;
                border-radius: 5px;
            }
            h2{color: #fff;}
            img{height:100px; 
                width:100px;}
            .floating-label-group{
                position: relative;
                margin: 35px 10px;
                border-radius: 4px;
            }
            .form-control{width: 300px;}
            .floating-label-group .floating-label{
                font-size: 13px;
                color: #071a52;
                position: absolute;
                pointer-events: none;
                top: 9px;
                left: 12px;
                transition: all 0.1s ease;
            }
            .floating-label-group input:focus ~ .floating-label,
            .floating-label-group input:not(:focus):valid ~ .floating-label {
                top: -15px;
                bottom: 0px;
                left: 0px;
                font-size: 14px;
                opacity: 1;
                color: #fff;
            }
            #submit {
                border: none;
                padding: 10px;
                color: #071a52;
                background: #ffffff;
                border-radius: 5px;
                width: 100px;
                font-weight: 600;
            }
        </style>
    </head>
    <body>
        
        <?php
        if(isset($message)){
            echo '<h2>'.$message.'</h2>';
        }
        ?>
        
        <div class="parent">
            <div class="container form">
                <h2> LOGIN FORM </h2>
                <img src="" alt=""><!-- image is needed to be added -->
                <form action="login.php" method="POST">
                    <div class="floating-label-group">
                        <input type="text" id="username" class="form-control" name="username" autocomplete="off" autofocus required/>
                        <label class="floating-label">Username</label>
                    </div>
                    <div class="floating-label-group">
                        <input type="password" id="password" name="password" class="form-control" autocomplete="off" autofocus required/>
                        <label class="floating-label">Password</label>
                    </div>
                    <button id="submit" type="submit" name="submit" value="login">Login</button>
                </form>
            </div>
        </div>
    </body>
</html>

