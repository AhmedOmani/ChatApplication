<?php 
    session_start();
    include_once "config.php" ;
    $fname = mysqli_real_escape_string($connect , $_POST['fname']) ;
    $lname = mysqli_real_escape_string($connect , $_POST['lname']) ;
    $email = mysqli_real_escape_string($connect , $_POST['email']) ;
    $password = mysqli_real_escape_string($connect , $_POST['password']) ;

    if (!empty($fname) && !empty($lname) && !empty($email) && !empty($password)) {
        
        if (filter_var($email , FILTER_VALIDATE_EMAIL)) {
            
            $query =  mysqli_query($connect , "SELECT email FROM `users` WHERE email = '{$email}' ") ;
         
            if (mysqli_num_rows($query) > 0) {

                echo "$email - HAS ALREADY TAKEN" ;
            
            } else {
                
                if (isset($_FILES['image'])) {
                    
                    $img_name = $_FILES['image']['name'] ;
                    $img_type = $_FILES['image']['type'] ;
                    $tmp_name = $_FILES['image']['tmp_name'] ;

                    $img_expload = explode('.' , $img_name) ;
                    $img_ext = end($img_expload) ;

                    $extensions = ['pnj' , 'jpeg' , 'jpg'] ;

                    if (in_array($img_ext , $extensions) === true) {
                        
                        $time = time() ;
                        
                        $new_img_name = $time.$img_name ;
                        
                        if (move_uploaded_file($tmp_name , "images/".$new_img_name)) {
                            $status = "Active Now" ;
                            $random_id = rand(time() , 10000000) ;

                            $query2 = mysqli_query($connect , "INSERT INTO `users` (unique_id , fname , lname , email , password , img , status)
                            VALUES({$random_id} , '{$fname}' , '{$lname}' , '{$email}' , '{$password}' , '{$new_img_name}' , '{$status}')");

                            if ($query2) {
                                $query3 = mysqli_query($connect , "SELECT * FROM `users` WHERE email = '{$email}'") ;
                                if (mysqli_num_rows($query3) > 0) {
                                    $row = mysqli_fetch_assoc($query3);
                                    $_SESSION['unique_id'] = $row['unique_id'];
                                    echo "success" ;
                                }
                            } 
                            else {
                                echo "Something went wrong!" ;
                            }

                        }

                    } 
                    
                    else {
                        echo "Please Select img with ext {'pnj' , 'jpeg' , 'jpg'}";
                    }

                } 
                else {
                    echo 'Please Select an Image File' ;
                }

            }

        } 
        
        else {
            echo "$email - This is not a valid email" ;
        }
    } 
    else {
        echo "All fields are needed" ;
    }
?>