<?php
    $_SESSION['loggedin']=false;
   if($_SERVER["REQUEST_METHOD"] == "POST") 
   {
        include '_dbconnect.php';
      $email =  $_POST['loginEmail'];
      $pass =  $_POST['loginPass'];    
    //   $pass1 = md5($pass);
      $sql = "SELECT * from `users` where `user_email`='$email'AND user_pass ='$pass'";
      //echo $sql;
      $result = mysqli_query($conn,$sql);
      $numRows = mysqli_num_rows($result);
      if($numRows ==1)
        {
            //echo $numRows;
            while($row = mysqli_fetch_assoc($result))
            {
                session_start();
            $_SESSION['loggedin']=true;
            $_SESSION['user_email'] = $email;
            //echo "$pass";
            // $a = $row['user_pass'];
            // echo "$a ...";
            //echo 'loggedin'."...". $email;
            header("Location: /forum/index.php");  
            }
               
        }
        else
            {
                // echo "kas kay he error....Unable to login";
                header("Location: /forum/index.php");

            } 
     }


?>