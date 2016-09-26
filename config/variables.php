<?php
# Global Variables Setup

// Title:
$site_title = 'Manatee';

# fetch pagename values
$pagename = basename($_SERVER['PHP_SELF']);
$pattern = "/(.*)(\.php)/";
$matched = preg_match($pattern, $pagename, $match);
if ($matched) {
    $q = "SELECT * FROM pages WHERE slug='$match[1]'";
    $r = mysqli_query($dbc, $q);
    $data = mysqli_fetch_assoc($r);
    if ($data['slug']) {
        $pagename = $data['slug'];
    } else $pagename = "home";
} else $pagename = "home";

// Load current page
$page = load_page($dbc, $pagename);

// Fetch user data if logged in
if (isset($_SESSION['username'])) {
	$user = data_user($dbc, $_SESSION['username']);
} else {
    $user = guest_user(); 
}
?>