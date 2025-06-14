<?php 
session_start();
include('includes/dbcon.php');
	
	$id = $_SESSION['id'];
	$venue = $_POST['venue'];
	$date = $_POST['date'];
	$time = $_POST['time'];
	$motif = $_POST['motif'];
	$pax = $_POST['pax'];
	$type = $_POST['type'];
	$ocassion = $_POST['ocassion'];
	$cid = $_POST['combo_id'];
	$date=date("Y-m-d",strtotime($date));

	$query1= mysqli_query($con,"SELECT * FROM `combo_details` natural join menu where combo_id='$cid'")or die(mysqli_error($con));

	while ($row1=mysqli_fetch_array($query1)){
		$menu_stock=$row1['menu_stock'];
		if ($pax > $menu_stock=$row1['menu_stock']) {
			echo "<script>alert ('Check Stock For All Products');
					var url = window.location.hostname
					window.location.replace(`$url/BrewPod/details.php`);; </script>";
		}
	}

	$query = mysqli_query($con, "SELECT * FROM `reservation` WHERE r_date='".$date."' AND r_status = 'Approved'");

			if(mysqli_num_rows($query) > 0)
			{
					echo "<script>alert ('Date is already reserved');
					window.history.back(); </script>";
			}
			else{
		$c = mysqli_query($con, "SELECT * FROM combo WHERE combo_id='$cid'");
			$row=mysqli_fetch_array($c);
				$price=$row['combo_price'];
				$payable=$pax*$price;

		mysqli_query($con,"UPDATE reservation SET payable='$payable',balance='$payable',r_venue='$venue',r_date='$date',r_time='$time',r_motif='$motif'
		,r_ocassion='$ocassion',r_type='$type',pax='$pax',combo_id='$cid',price='$price' where rid='$id'")or die(mysqli_error($con)); 

			$_SESSION['id']=$id;

			
			echo "<script>document.location='payment.php'</script>";   
	}
	
?>