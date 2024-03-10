<?php 
    include_once "header.php";
    include_once "php/config.php";
    session_start() ;
    if (!isset( $_SESSION['unique_id'] )) {
        header("location:login.php");
    }
?>
<?php
    
    $id = $_SESSION['unique_id'] ;
    $query = mysqli_query($connect , "SELECT * FROM `users` WHERE unique_id = {$id}") ;
    $row = mysqli_fetch_assoc($query) ;

    $query2 = mysqli_query($connect , "SELECT * FROM `users`") ;

?>

<body>

    <div class="wrapper">
        <section class="users">
            <header>
                <div class="content">
                    <img src="php/images/<?= $row['img']?> " alt="">
                    <div class="details">
                        <span><?= $row['fname'] . ' ' . $row['lname'] ?></span>
                        <p><?= $row['status']?></p>
                    </div>
                </div>
                <a href="./php/logout.php?logout_id=<?= $row['unique_id'] ?>" class="logout">Logout</a>
            </header>
            <div class="search">
                <span class="text">Select a user to start chat</span>
                <input type="text" placeholder="Search users...">
                <button><i class="fa fa-search"></i></button>
            </div>

        </section>
        <div class="users-list">
            
        </div>
    </div>
    
    <script src="javascript/users.js"></script>

</body>
</html>
