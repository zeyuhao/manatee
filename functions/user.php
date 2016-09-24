<?php
# Gets user $data from a specified $id
function data_user($dbc, $id) {
	if(is_numeric($id)) {
		$cond = "WHERE id = '$id'";
	} else {
		$cond = "WHERE email = '$id'";
	}
	$q = "SELECT * FROM users $cond";
	$r = mysqli_query($dbc, $q);
	
	$data = mysqli_fetch_assoc($r);
	$data['fullname'] = $data['first'].' '.$data['last'];
	$data['fullname_reverse'] = $data['last'].', '.$data['first'];
	return $data;
}
?>