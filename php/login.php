<?php 
    session_start();
    include_once "config.php" ;
    $email = mysqli_real_escape_string($connect , $_POST['email']) ;
    $password = mysqli_real_escape_string($connect , $_POST['password']) ;

    if (!empty($email) && !empty($password)) {
        
        $query = mysqli_query($connect,"SELECT * FROM `users` WHERE email = '{$email}' AND password = '{$password}'") ;
       
        if (mysqli_num_rows($query) > 0) {
            
            $row = mysqli_fetch_assoc($query) ;
            $status = "Active now" ;
            $sql2 = mysqli_query($connect , "UPDATE users SET status = '{$status}' WHERE unique_id = {$row['unique_id']}");
            if ($sql2) {
                $_SESSION['unique_id'] = $row['unique_id'];
                echo "success" ;
            }

        } else {
            echo "Email or Password are incorrect" ;
        }

    } 
    
    else {
        echo "All inputs fiels are required!"  ;
    }
?>