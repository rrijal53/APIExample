<?php
	$con=mysqli_connect("localhost","root","", "contacts") or die('{"res":"Database Error1"}');

	// $mydb=mysqlii_select_db("contacts") or die('{"res":"Database Error2"}');
	// echo "string";
	$action = (isset($_GET['action'])?($_GET['action']):"list");
	switch($action){
		case "list":
			$sql = "SELECT * FROM `contacts` LIMIT 0, 50"; 
			$myquery = mysqli_query($con,$sql) or die('{"res":"Query error"}');
			$json_array = array();
			while($rows = mysqli_fetch_array($myquery)){//`username`, `c_fname`, `c_lname`, `n_home`, `n_mobile`, `n_office`, `created`
					$row_array['id'] = $rows['id'];
					$row_array['username'] = $rows['username'];
					$row_array['c_fname'] = $rows['c_fname'];
					$row_array['c_lname'] = $rows['c_lname'];
					$row_array['n_home'] = $rows['n_home'];
					$row_array['n_mobile'] = $rows['n_mobile'];
					$row_array['n_office'] = $rows['n_office'];
					$row_array['created'] = $rows['created'];

					array_push($json_array,$row_array);	
			}
			$json_result['res'] = 'success';
			$json_result['data'] = $json_array;
			echo json_encode($json_result);
			break;
		case "view":
			if(!isset($_GET['id'])){
				die('{"res":"id not specified"}');
			}
			$sql = "SELECT * FROM `contacts` WHERE `id` = ".$_GET['id'] ; 
			$myquery = mysqli_query($con,$sql) or die('{"res":"Query error"}');
			$row_array;
			while($rows = mysqli_fetch_array($myquery)){//`username`, `c_fname`, `c_lname`, `n_home`, `n_mobile`, `n_office`, `created`
				$row_array['id'] = $rows['id'];
				$row_array['username'] = $rows['username'];
				$row_array['c_fname'] = $rows['c_fname'];
				$row_array['c_lname'] = $rows['c_lname'];
				$row_array['n_home'] = $rows['n_home'];
				$row_array['n_mobile'] = $rows['n_mobile'];
				$row_array['n_office'] = $rows['n_office'];
				$row_array['created'] = $rows['created'];

			}
			$json_result['res'] = 'success';
			$json_result['data'] = $row_array;
			echo json_encode($json_result);
			break;
		case "add":
			$username = (isset($_GET['username'])?($_GET['username']):"hem");
			$c_fname = (isset($_GET['c_fname'])?($_GET['c_fname']):"");
			$c_lname = (isset($_GET['c_lname'])?($_GET['c_lname']):"");
			$n_home = (isset($_GET['n_home'])?($_GET['n_home']):"");
			$n_mobile = (isset($_GET['n_mobile'])?($_GET['n_mobile']):"");
			$n_office = (isset($_GET['n_office'])?($_GET['n_office']):"");
			
			$sql = "INSERT INTO `contacts` (`username`, `c_fname`, `c_lname`, `n_home`, `n_mobile`, `n_office`, `created`) VALUES ('".$username."', '".$c_fname."', '".$c_lname."', '".$n_home."', '".$n_mobile."', '".$n_office."', '".date('Y-m-d h:i:s a', strtotime('now'))."')";
			//echo $sql;
			$myquery=mysqli_query($con,$sql);
			if($myquery){
				$json_result['res'] = 'success';
				echo json_encode($json_result);
			}
			else{
				$json_result['res'] = 'error';
				echo json_encode($json_result);
			}
			break;
		case "edit":
		if(!isset($_GET['id'])){
				die('{"res":"id not specified"}');
			}
			$id = $_GET['id'];
			$username = (isset($_GET['username'])?($_GET['username']):"hem");
			$c_fname = (isset($_GET['c_fname'])?($_GET['c_fname']):"");
			$c_lname = (isset($_GET['c_lname'])?($_GET['c_lname']):"");
			$n_home = (isset($_GET['n_home'])?($_GET['n_home']):"");
			$n_mobile = (isset($_GET['n_mobile'])?($_GET['n_mobile']):"");
			$n_office = (isset($_GET['n_office'])?($_GET['n_office']):"");
			$sql = "UPDATE `contacts` SET `username`='".$username."', `c_fname`='".$c_fname."', `c_lname`='".$c_lname."', `n_home`='".$n_home."', `n_mobile`='".$n_mobile."', `n_office`='".$n_office."' WHERE `id`=".$id;
			//echo $sql;
			$myquery=mysqli_query($con,$sql);
			if($myquery){
				$json_result['res'] = 'success';
				echo json_encode($json_result);
			}
			else{
				$json_result['res'] = 'error';
				echo json_encode($json_result);
			}
			break;
		case "search":
			$q = (isset($_GET['q']))?($_GET['q']):"";
			$sql = "SELECT * FROM `contacts` WHERE `username` LIKE '%".$q."%' OR `c_fname` LIKE '%".$q."%' OR `c_lname` LIKE '%".$q."%' LIMIT 0, 50";
			//echo $sql;
			$myquery = mysqli_query($con,$sql) or die('{"res":"Query error"}');
			$json_array = array();
			while($rows = mysqli_fetch_array($myquery)){//`username`, `c_fname`, `c_lname`, `n_home`, `n_mobile`, `n_office`, `created`
					$row_array['id'] = $rows['id'];
					$row_array['username'] = $rows['username'];
					$row_array['c_fname'] = $rows['c_fname'];
					$row_array['c_lname'] = $rows['c_lname'];
					$row_array['n_home'] = $rows['n_home'];
					$row_array['n_mobile'] = $rows['n_mobile'];
					$row_array['n_office'] = $rows['n_office'];
					$row_array['created'] = $rows['created'];

					array_push($json_array,$row_array);	
			}
			$json_result['res'] = 'success';
			$json_result['data'] = $json_array;
			echo json_encode($json_result);
			break;
		case "delete":
			if(!isset($_GET['id'])){
				die('{"res":"id not specified"}');
			}
			$sql = "DELETE FROM `contacts` WHERE `id` = ".$_GET['id'] ; 
			$myquery = mysqli_query($con,$sql) or die('{"res":"Query error"}');
			if($myquery){
				$json_result['res'] = 'success';
				echo json_encode($json_result);
			}
			else{
				$json_result['res'] = 'error';
				echo json_encode($json_result);
			}
			break;
		default:
				$json_result['res'] = 'invalid action';
				echo json_encode($json_result);
			break;
	}
?>

