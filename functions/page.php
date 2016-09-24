<?php

# This function loads page content
function load_page($dbc, $pagename) {
    $q = "SELECT * FROM pages WHERE slug='$pagename'";
    $r = mysqli_query($dbc, $q);
    $data = mysqli_fetch_assoc($r);
    if ($data['body']) {
        $data = format_body($data);
    }
    return $data;
}

# This function ensures $data has an html formatted body
function format_body($data) {
	# Below, checks and formats the page body to have html
	$data['body_nohtml'] = strip_tags($data['body']);
	# If the nohtml version is the same as the original
	if ($data['body_nohtml'] == $data['body']) {
		# Then add <p> tags </p> to the body
		$data['body_formatted'] = '<p>'.$data['body'].'</p>';
	}	else {
		# Else the formatted page will remain the same
		$data['body_formatted'] = $data['body'];
	}
	return $data;
}
?>