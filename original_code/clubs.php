<?php
include "connectdb.php";
if (isset($_POST['aclub'])){

	?>	
	<html>
	<body>
		<h1>Adminstrator</h1>
		<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
			<p>Input your information and choose option</p>
			Staff Organizer <input type="text" name="staff"/><br>
			Club: <input type="text" name="club"/><br>
			<input type="submit" name="insert" value="insert" />
		</form>
	</body>
	</html>


<?php 
}
if (isset($_POST['insert'])){
	$staff_sponser = $_POST['staff'];
	$club = $_POST['club']; 
	$insert = $_POST['insert'];
	if ($insert == 'insert' and ($staff_sponser !="" and $club !="")){
		$sql = "INSERT INTO clubs (staff_sponser, club)
		VALUES ('$staff_sponser', '$club')";
		if ($conn->query($sql) === TRUE) {
			echo "New record created successfully";
			header('Location: announcement.php');
		} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
		}


	}
}
$conn->close();		

?>

<!-- //  if ($result->num_rows > 0){
//            	foreach($result->fetch_assoc() as $x){
//             ?>
//             <select>
//   				<option value="$x"><?php //echo "$x" ?></option>
// 			</select>
// 			<?php
// 			}
// 			}
// $menu .="<option value=".$row['club'].">". $row['club']."</option>"; -->