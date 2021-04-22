<html>
    <body>

        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <p>Input your information</p>
            First name: <input type="name" name="f"/><br>
            Last name: <input type="name" name="l"/><br>
            Email: <input type="email" name="e" /><br>
            <input type="submit" name="query" value="query" />
            <input type="submit" name="insert" value="insert" />
            <input type="submit" name="delete" value="delete" />
        </form>

    
    </body>
</html>







<?php            
    include "connectdb.php";
    $fname = $_POST['f'];
    $lname = $_POST['l'];
    $email = $_POST['e'];
    $query = $_POST['query'];
    $insert = $_POST['insert'];
    $modify = $_POST['modify'];
    $delete = $_POST['delete'];

    if ($query == 'query' and ($fname !="" and $lname !="")){
        $sql = "SELECT * FROM MyGuests WHERE firstname='$fname' and lastname='$lname'";
        
        $result = $conn->query($sql);
    
        if ($result->num_rows > 0) {
        echo "<table><tr><th>ID</th><th>Name</th><th>Email</th></tr>";
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $current_id= $row["id"];
            $current_firstname = $row["firstname"];
            $current_lastname = $row["lastname"];
            $current_email = $row["email"];
            echo "<tr><td>".$row["id"]."</td><td>".$row["firstname"]." ".$row["lastname"]."".$row["email"]. "</td></tr>" ;
          }
            echo "</table>";
        } else {
            echo "0 results";
        }

?>
        <html>
        <body>

            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <p>Please Change Your Information</p>
                First name: <input type="name" name="fm" value="<?php echo $current_firstname ?>"/><br>
                Last name: <input type="name" name="lm" value="<?php echo $current_lastname ?>"/><br>
                Email: <input type="email" name="em" value="<?php echo $current_email ?>" /><br>
                <input type="submit" name="modify" value="modify" />
                <input type="submit" name="delete" value="delete" />
            </form>

    
        </body>
        </html>
        <?php
            $f_name = $_POST['fm'];
            $l_name = $_POST['lm'];
            $e_mail = $_POST['em'];
            $modify = $_POST['modify'];
            if ($modify == 'modify' and $f_name !="" and $l_name !="" and $e_mail !=""){
                echo $current_id, "the id";
            $sql = "UPDATE MyGuests SET firstname ='$f_name', lastname='$l_name', email='$e_mail' WHERE id='$current_id'";
            if ($conn->query($sql) === TRUE) {
                    echo "The record is modified successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
            }
        ?>
<?php
        }
     
    if ($insert == 'insert'){
        $sql = "INSERT INTO MyGuests (firstname, lastname, email)
        VALUES ('$fname', '$lname', '$email')";

        if ($conn->query($sql) === TRUE) {
                echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    if ($delete == 'delete' and $fname !="" and $lname !=""){
        $sql = "DELETE FROM MyGuests WHERE firstname='$fname' and lastname='$lname'";

        if ($conn->query($sql) === TRUE) {
                echo "The record deleted successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    
    


    

?>

<?php
    $sql = "SELECT id, firstname, lastname FROM MyGuests";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo "<table><tr><th>ID</th><th>Name</th></tr>";
        // output data of each row
        while($row = $result->fetch_assoc()) {
            echo "<tr><td>".$row["id"]."</td><td>".$row["firstname"]." ".$row["lastname"]."</td></tr>";
        }
        echo "</table>";
    } else {
        echo "0 results";
    }
    
$conn->close();

?>