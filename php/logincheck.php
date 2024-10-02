<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src ="../js/sweet.js"></script>
    <title>Document</title>
</head>
<body>
    
</body>
</html>

<?php 

include 'config.php' ;
session_start();


if(isset($_POST['save'])){

    $username=mysqli_real_escape_string($conn,$_POST['username']);
    $password = mysqli_real_escape_string($conn,$_POST['password']);

    if($username == "admin" & $password == "admin"){
       
        $_SESSION['username'] = $username ;
        $_SESSION['user_type'] = "admin";
        echo '<script>';
        echo 'ConfirmationAlert("Verified","You are successfully Logined","../php/adminpanel.php")';
        echo '</script>';
        
    }else if($username == "contractor" & $password == "contractor"){
        $_SESSION['username'] = $username ;
        $_SESSION['user_type'] = "contractor";
        echo '<script>';
        echo 'ConfirmationAlert("Verified","You are successfully Logined","../php/cAdminPanel.php")';
        echo '</script>';

    }else{

        $username_search = "SELECT * FROM register WHERE username='$username' " ;
        $query = mysqli_query($conn, $username_search);
        $username_count = mysqli_num_rows($query);

        if($username_count > 0 ){

            $email_pass = mysqli_fetch_assoc($query);
            $db_pass = $email_pass['password'];
            $db_email = $email_pass['email'];
            $pass_decode = password_verify($password, $db_pass);

            if($pass_decode){

                // Checking Whether the user is Allowed or not 
                $sql2 = "SELECT isAllowed FROM register WHERE username = '$username' AND isAllowed = 1";
                $query2 = mysqli_query($conn, $sql2);
                $row2 = mysqli_num_rows($query2);

                if($row2 == 1){

                    if(isset($_POST['rememberme'])){

                        setcookie("usernamecookie",$username,time()+200);
                        setcookie("passwordcookie",$password,time()+200);
                        $_SESSION['username'] = $username ;
                        $_SESSION['password'] = $password;
                        $_SESSION['email']= $email_pass['email'];
                        $_SESSION['user_type'] = "user";
                        echo '<script>';
                        echo 'ConfirmationAlert("Verified","You are successfully Logined","../php/dashboard.php")';
                        echo '</script>';

                    }else{
                        
                        $_SESSION['username'] = $username ;
                        $_SESSION['password'] = $password;
                        $_SESSION['email'] = $email_pass['email'];
                        $_SESSION['user_type'] = "user";
                        echo '<script>';
                        echo 'ConfirmationAlert("Verified","You are successfully Logined","../php/dashboard.php")';
                        echo '</script>';

                    }
           
                } else {
                    echo '<script>';
                    echo 'ErrorAlert("Failed","Permission not granted by admin","../php/login.php")';
                    echo '</script>';
                }

            } else {
                echo '<script>';
                echo 'ErrorAlert("Failed","Invalid username or password","../php/login.php")';
                echo '</script>';
            }
        } else {
            // Username not found
            echo '<script>';
            echo 'ErrorAlert("Failed","Invalid username or password","../php/login.php")';
            echo '</script>';
        }
    }
}




// Temporary for the worker 

if(isset($_POST['worker'])){

    $username=mysqli_real_escape_string($conn,$_POST['username']);
    $password = mysqli_real_escape_string($conn,$_POST['password']);

    
    $username_search = "SELECT * FROM worker WHERE username='$username' " ;
    $query = mysqli_query($conn, $username_search);
    $username_count = mysqli_num_rows($query);

    if($username_count > 0 ){

        $email_pass = mysqli_fetch_assoc($query);
        $db_pass = $email_pass['password'];
        $db_email = $email_pass['email'];

        $pass_decode = password_verify($password, $db_pass);
        

        if($pass_decode){

               

                    if(isset($_POST['rememberme'])){

                        setcookie("usernamecookie",$username,time()+200);
                        setcookie("passwordcookie",$password,time()+200);
                        $_SESSION['username'] = $username ;
                        $_SESSION['password'] = $password;
                        $_SESSION['email']= $email_pass['email'];
                        $_SESSION['user_type'] = "worker";
                        echo '<script>';
                        echo 'ConfirmationAlert("Verified","You are successfully Logined","../php/Wdashboard.php")';
                        echo '</script>';

                    }else{
                        
                        $_SESSION['username'] = $username ;
                        $_SESSION['password'] = $password;
                        $_SESSION['email'] = $email_pass['email'];
                        $_SESSION['user_type'] = "worker";
                        echo '<script>';
                        echo 'ConfirmationAlert("Verified","You are successfully Logined","../php/Wdashboard.php")';
                        echo '</script>';

                    }
           
                

        } else {
                echo '<script>';
                echo 'ErrorAlert("Failed","Invalid username or password","../php/login.php")';
                echo '</script>';
        }
    } else {
            // Username not found
            echo '<script>';
            echo 'ErrorAlert("Failed","Invalid username or password","../php/login.php")';
            echo '</script>';
        }
}

?>