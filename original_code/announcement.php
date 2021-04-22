<?php
include "connectdb.php";
session_start();

?>
<h1>
	Welcome

	<?php
	echo $_SESSION['username'];
	?>
</h1>


<?php
if ($_SESSION['role'] == "staff"){
	$username = $_SESSION['username'];
	$sql = "SELECT id, staff_sponser, startdate, enddate, organization, annoucement, daysofweek FROM annoucementdb WHERE staff_sponser = '$username'";
} 
if ($_SESSION['role'] == "admin"){
	$sql = "SELECT id, staff_sponser, startdate, enddate, organization, annoucement, daysofweek FROM annoucementdb"; 
}
if ($_SESSION['role'] == "user"){
	$currentd = date('Y-m-d', time());
	$d = date('N', time()); 
	switch ($d) {
		case '1':
		$dayofweek = 'monday'; 
		break;
		case '2':
		$dayofweek = 'tuesday'; 
		break;
		case '3':
		$dayofweek = 'wednesday'; 
		break;
		case '4':
		$dayofweek = 'thursday'; 
		break;
		case '5':
		$dayofweek = 'friday'; 
		break;
		case '6';
		$dayofweek = 'saturday';
		case '7';
		$dayofweek = 'sunday';
	}

	$sql = "SELECT id, staff_sponser, startdate, enddate, organization, annoucement, daysofweek FROM annoucementdb WHERE startdate <= '$currentd' and enddate >= '$currentd' and daysofweek LIKE '%$dayofweek%'";
}


$result = $conn->query($sql);
if ($result->num_rows > 0){
	echo "<table><tr><th>ID</th><th>Staff Sponser</th><th>Start Date</th><th>End Date</th><th>Club</th><th>Days Available</th><th>Annoucement</th></tr>";
	while($row = $result->fetch_assoc()){
		$id1 = $row['id'];
		$staff_sponser1 = $row['staff_sponser'];
		$startdate1 = $row['startdate'];
		$organization1 = $row['organization'];
		$annoucement1 = $row['annoucement'];
		$daysofweek1 = $row['daysofweek'];
		echo "<tr><td>".$row['id']."</td><td>".$row['staff_sponser']."</td><td>".$row['startdate']."</td><td>".$row['enddate']."</td><td>".$row['organization']."</td><td>".$row['daysofweek']."</td><td>".$row['annoucement']."</td>";

		?>
		<?php
		if ($_SESSION['role'] == "admin" or $_SESSION['role'] == "staff"){
			?> 
			<td><form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
				<input type="submit" name="dannoucement" value="Delete Annoucement <?php echo $id1 ?>"/>
			</form>
			<form method="post" action="edit.php">
				<input type="submit" name="eannoucement" value="Edit Annoucement <?php echo $id1 ?>"/>
			</form></td></tr>
			<?php
		} 
		?>


		<?php




	}
	echo "</table>";
} else {
	echo "0 results";
}
?> 


<?php
if (isset($_POST['dannoucement'])){
	$dannoucement = $_POST['dannoucement'];
	$delete_id = preg_replace('/[^0-9]+/', '', $dannoucement);
	$sql = "DELETE FROM annoucementdb WHERE id = '$delete_id'";
	if ($conn->query($sql) === TRUE) {
		echo "Deleted successfully";
		header('Location: announcement.php');

	} else {
		echo "Error: " . $sql . "<br>" . $conn->error;
	}
}
?> 


<style>
th, td {
	padding-top: 6px;
	padding-bottom: 6px;
	padding-right: 6px;
	padding-left: 6px;
	text-align: left;
	border-bottom: 3px solid #ddd;
	transition: 0.5s ease;
}
tr:hover {
	background-color: #ff8080;
	transition: 0.5s ease;
}

</style>


<?php
if ($_SESSION['role'] == "admin" or $_SESSION['role'] == "staff"){
?>

	<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		<input type="submit" name="nannoucement" value="New annoucement"/>
	</form>

<?php
	if ($_SESSION['role'] == "admin"){
?>

<!-- <form method="post" action="">
	<input type ="submit" name="cuser" value="New User/Change User"/>
</form> -->

<form method="post" action="clubs.php">
	<input type ="submit" name="aclub" value="Add Club"/>
</form>


<?php
}
?>


<?php
}
// or isset($_POST['eannoucement'])
?>

<?php
if (isset($_POST['nannoucement'])){
	$nannoucement = $_POST['nannoucement']; 
	if ($nannoucement = 'nannoucement'){

?>



		<html>
		<body>
			<h1>Annoucement Table</h1>
			<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
				<p>Input your information and choose option</p>
				Starting Date <input type="date" name="startdate"/>


				Ending Date <input type="date" name="enddate"/><br>
				Name of organization:  

				<select style="width:150px" name="club" value="club">

					<?php
					$sql="SELECT club FROM clubs"; 
					$result = $conn->query($sql);
					$menu = "";
					if ($result->num_rows > 0){
						while($row = $result->fetch_assoc()){
							$menu .='<option value="'.$row['club'].'">'. $row['club'].'</option>';
						}
						echo $menu;
					}
					?>
				</select>

				Staff Sponsor: 
				<select style="width:150px" name="staff_sponser" value="staff_sponser">
					<?php
					$sql="SELECT staff_sponser FROM clubs"; 
					$result = $conn->query($sql);
					$menu = "";
					if ($result->num_rows > 0){
						while($row = $result->fetch_assoc()){
							$menu .='<option value="'.$row['staff_sponser'].'">'.$row['staff_sponser'].'</option>';
						}
						echo $menu;
					}
					?>
				</select><br>
				Annoucement:
				<textarea name="annoucement"  rows="7" cols="40"></textarea><br>
				Monday:<input type="checkbox" name="d1" value="monday"/>
				Tuesday:<input type="checkbox" name="d2" value="tuesday"/>
				Wednesday:<input type="checkbox" name="d3" value="wednesday"/>
				Thursday:<input type="checkbox" name="d4" value="thursday"/>
				Friday:<input type="checkbox" name="d5" value="friday"/><br>
				<input type="submit" name="submit" value="submit" />
			</form>
		</body>
		</html>


<?php
	}
}
if (isset($_POST['submit'])){
	$startdate = $_POST['startdate'];
	$enddate = $_POST['enddate'];
	$club = $_POST['club'];
	$staff_sponser = $_POST['staff_sponser'];
	$annoucement = $_POST['annoucement'];
	$submit = $_POST['submit'];


	$a = array();
	for ($i=1;$i<=5;$i++){
		$day = "d$i";
		if (isset($_POST[$day])){
			$weekday = $_POST[$day];
			array_push($a,$weekday);
		}
	}
	if ($a !=""){
		$daysofweek = implode(",",$a);
	}
	echo $daysofweek;


	if ($submit == 'submit' and($startdate!="" and $club!="" and $staff_sponser!="" and $annoucement!="")){
		if (!$enddate){
			$timestamp = strtotime($startdate);
			$enddate = date('Y-m-d',strtotime("+1 week", $timestamp));
		}
		if ($daysofweek !=""){
			$sql = "INSERT INTO annoucementdb (startdate, enddate, organization, staff_sponser, annoucement, daysofweek)
			VALUES ('$startdate', '$enddate', '$club', '$staff_sponser', '$annoucement', '$daysofweek')";
			echo $sql; 
			if ($conn->query($sql) === TRUE) {
				echo "New record created successfully";
				header('Location: announcement.php');
			} else {
				echo "Error: " . $sql . "<br>" . $conn->error;
			}

		}
// $enddate == ""

	}

}

$conn->close();		

?>
<form method="post" action="login.php">
	<input type="submit" name="logout" value="logout" />
</form>

<!-- <fieldset>
    <legend>Choose trip dates</legend>

    <div>
        <label for="start">Start</label>
        <input type="date" id="start" name="trip"
               value="2018-07-22"
               min="2018-01-01" max="2018-12-31" />
    </div>

    <div>
        <label for="end">End</label>
        <input type="date" id="end" name="trip"
               value="2018-07-29"
               min="2018-01-01" max="2018-12-31"/ >
    </div>

</fieldset>
-->
<!-- // things to do 
New user/change user
Add club - seperate page 
edit annoucement and delete annoucement using 
checkboxes beside 
check if date and week match with the current day of the week   


 // -->