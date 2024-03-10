<?php
include_once("config.php") ;
while( $row = mysqli_fetch_assoc($query) ) {
    
    $sql2 = "SELECT * FROM messeges WHERE (incoming_msg_id = {$row['unique_id']} OR outgoing_msg_id = {$row['unique_id']}) 
             AND (outgoing_msg_id = {$outgoing_id} OR  incoming_msg_id = {$outgoing_id}) ORDER BY msg_id DESC" ;

    $query2 = mysqli_query($connect , $sql2) ;
    $row2 = mysqli_fetch_assoc($query2) ;
    $result;

    if (mysqli_num_rows($query2) > 0) {
        $result = $row2['msg']; 
    } else {
        $result = 'No message available';
    }

    $msg ;
    if (strlen($result) > 28) 
        $msg = substr($result,0,28).'...' ;
    else 
        $msg = $result ;

    if (mysqli_num_rows($query2) > 0) 
        ($outgoing_id == $row2['outgoing_msg_id']) ? $You = "You: " : $You = "";

    ($row['status'] == "Offline now") ? $offline = "offline" : $offline = "" ;
    
    $output .= '
                <a href="chat.php?user_id='.$row['unique_id'] .'">
                    <div class="content">
                        <img src="php/images/'. $row['img'].'" alt="">
                        <div class="details">
                            <span>'. $row['fname'] . " " . $row['lname'] .'</span>
                            <p>'. $row['status'] .'</p>
                            <p>'. $You . $result .'</p>
                        </div>
                    </div>

                    <div class="status-dot '.$offline.' "><i class="fas fa-circle"><i-fas></i> </div>
                </a>
  
              ';
 /// incoming , outgoing , msg
}/// id_ahmed , id_mo , msg -> mohammed send
///  id_mo , id_ahmed , msg -> ahmed send

?>

