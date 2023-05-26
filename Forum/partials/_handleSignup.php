<?php
$showError = "false";
if($_SERVER["REQUEST_METHOD"] == "POST"){
    include '_dbconnect.php';
    $user_email = $_POST['signupEmail'];
    $pass = $_POST['password'];
    $cpass = $_POST['cpassword'];

    // check whether this email exists
    $existSql = "select * from `users` where user_email = '$email'";
    $result = mysqli_query($conn, $existSql);
    $numRows = mysqli_num_rows($result);
    if($numRows>0)
        {
            $showError = "Email already in use";
        }
    else{
            if($pass == $cpass)
            {
                    
                    $sql = "INSERT INTO `users` ( `user_email`, `user_pass`, `timestamp`) 
                            VALUES ( '$user_email', '$pass', current_timestamp())";
                    $result = mysqli_query($conn, $sql);
                    
                    if($result){
                        $showAlert = true;
                        header("Location:/Forum/index.php?signupsuccess=true");
                        exit();
                        
                    }     
            }
            else
            {
                $showError = "Password do not match";
            
            }
        }
    header("Location:/Forum/index.php?signupsuccess=false&error=$showError");
}


?>