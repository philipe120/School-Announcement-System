<?php
include "connectdb.php";
if (isset($_POST['eannoucement'])){
	$eannoucement = $_POST['eannoucement'];
	$edit_id = preg_replace('/[^0-9]+/', '', $eannoucement);
	$sql = "SELECT * FROM annoucementdb WHERE id ='$edit_id'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		$row = $result->fetch_assoc();
		$current_id= $row['id'];
		$current_startdate = $row['startdate'];
		$current_enddate = $row['enddate'];
		$current_staff = $row['staff_sponser'];
		$current_organization = $row['organization'];
		$current_annoucement = $row['annoucement'];
		$current_daysofweek = $row['daysofweek'];
	}    
	?>
	<html>
	<body>
		<h1>Annoucement Table</h1>
		<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
			<p>Input your information and choose option</p>
			ID <input type="text" name="idv" value="<?php echo "$current_id"?>" readonly/><br>

			Starting Date <input type="date" name="startdate" value = "<?php echo $current_startdate?>"/>


			Ending Date <input type="date" name="enddate" value = "<?php echo $current_enddate?>"/><br>
			Name of organization:  

			<select style="width:150px" name="club">

				<?php
				$sql="SELECT club FROM clubs"; 
				$result = $conn->query($sql);
				$menu = "";
				$menu .="<option value=".$current_organization.">".$current_organization."</option>";
				if ($result->num_rows > 0){
					while($row = $result->fetch_assoc()){
						$menu .='<option value="'.$row['club'].'">'. $row['club'].'</option>';
					}

					echo $menu;
				}
				?>
			</select>

			Staff Sponsor: 
			<select style="width:150px" name="staff_sponser">
				<?php
				$sql="SELECT staff_sponser FROM clubs"; 
				$result = $conn->query($sql);
				$menu = "";
				$menu .="<option value=".$current_staff.">".$current_staff."</option>";
				if ($result->num_rows > 0){
					while($row = $result->fetch_assoc()){
						$menu .='<option value="'.$row['staff_sponser'].'">'.$row['staff_sponser'].'</option>';
					}
					echo $menu;
				}
				?>
			</select><br>
			Annoucement:
			<textarea name="annoucement" rows="7" cols="40"><?php echo "$current_annoucement"?></textarea><br>

			<?php
			if (strpos($current_daysofweek, "monday") > -1){
				?>
				Monday:<input type="checkbox" name="d1" value="monday" checked/>
				<?php 
			} else {
				?>
				Monday:<input type="checkbox" name="d1" value="monday"/>
				<?php
			}
			?>


			<?php
			if (strpos($current_daysofweek, "tuesday") > -1){
				?>
				Tuesday:<input type="checkbox" name="d2" value="tuesday" checked/>
				<?php
			} else {
				?>	
				Tuesday:<input type="checkbox" name="d2" value="tuesday"/>
				<?php	
			}
			?>



			<?php
			if (strpos($current_daysofweek, "wednesday") > -1){
				?>
				Wednesday:<input type="checkbox" name="d3" value="wednesday" checked/>
				<?php
			} else {
				?>	
				Wednesday:<input type="checkbox" name="d3" value="wednesday"/>
				<?php	
			}
			?>


			<?php
			if (strpos($current_daysofweek, "thursday") > -1){
				?>
				Thursday:<input type="checkbox" name="d4" value="thursday" checked/>
				<?php
			} else {
				?>	
				Thursday:<input type="checkbox" name="d4" value="thursday"/>
				<?php	
			}
			?>

			<?php
			if (strpos($current_daysofweek, "friday") > -1){
				?>
				Friday:<input type="checkbox" name="d5" value="friday" checked/><br>
				<?php
			} else {
				?>	
				Friday:<input type="checkbox" name="d5" value="friday"/><br>
				<?php	
			}
			?>
			<input type="submit" name="modify" value="modify" />
		</form>
	</body>
	</html>

<?php
}
if (isset($_POST['modify'])){
	$id = $_POST['idv'];
	$startdate = $_POST['startdate'];
	$enddate = $_POST['enddate'];
	$club = $_POST['club'];
	$staff_sponser = $_POST['staff_sponser'];
	$annoucement = $_POST['annoucement'];
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
	if (!$enddate){
		$timestamp = strtotime($startdate);
		$enddate = date('Y-m-d',strtotime("+1 week", $timestamp));
	}
	if ($daysofweek !=""){
		$sql = "UPDATE annoucementdb SET startdate='$startdate', enddate='$enddate', organization='$club', staff_sponser='$staff_sponser', annoucement='$annoucement', daysofweek='$daysofweek' WHERE id=$id";
		if ($conn->query($sql) === TRUE) {
			echo "Record updated successfully";
			header('Location: announcement.php');
		} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
		}

	}

}

$conn->close();		

?>

<form method="post" action="announcement.php">
	<input type="submit" name="Back" value="Back" />
</form>