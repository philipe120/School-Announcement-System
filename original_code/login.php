
<?php
session_start();
session_unset(); 

?>


<html>
    <body>
        <h1>User Login</h1>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <p>Input your information and choose option</p>
            Username: <input type="text" name="user"/><br>
            Password: <input type="password" name="pass"/><br>
            <input type="submit" name="login" value="login" />
        </form>
    </body>
</html>

<?php

if (isset($_POST['login'])){
include "connectdb.php";
$username = $_POST['user'];
$password = $_POST['pass'];
$submit = $_POST['login'];

if ($submit == 'login' and ($username !="" and $password !="")){
    $sql = "SELECT * FROM login WHERE username='$username' and password='$password'"; 
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['username'] = $row['username'];
        $_SESSION['role'] = $row['role']; 
        header('Location: announcement.php');

    } else {
?>
        
        <body>
        <!--  <META HTTP-EQUIV="refresh" CONTENT="1"> -->
        <p>Invalid username and password</p>   
        </body>
<?php
    }
}
$conn->close();
}

?>