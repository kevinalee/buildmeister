<?php

# setup include path
if (!defined("PATH_SEPARATOR")) {
	if (strpos($_ENV["OS"], "Win") !== false)
	define("PATH_SEPARATOR", ";");
	else define("PATH_SEPARATOR", ":");
}
ini_set("include_path", "." . PATH_SEPARATOR . "../" . PATH_SEPARATOR
. "./include" . PATH_SEPARATOR . "../../include");

include_once("database.php");
include_once("functions.php");
	
	// get the page number to show
	if (!isset($_GET['page']))
		$page = 1;
	else  
		$page = clean_data($_GET["page"]);

	// get the search string to filter users on
	if (!isset($_GET['searchstring']))
		$searchstring = "";
	else
		$searchstring = clean_data($_GET["searchstring"]);
		
	// get the number of rows to show
	if (!isset($_GET['rows']))
		$rows_per_page = PAGE_LIMIT;
	else
		$rows_per_page = clean_data($_GET["rows"]);	
	// TODO: check rows_per_page is a number;	

	// find the number of users
	$q = "SELECT COUNT(*) FROM " . TBL_USERS . " WHERE username LIKE '%" . $searchstring . "%'";
	$result = $database->query($q);
	if (!$result) {
		$num_users = 0;
		$num_pages = 0;
	} else {	
		$num_users = mysql_result($result, 0);
		if ($rows_per_page == 0) {
			$num_pages = 1;		
		} else {
			$num_pages = ceil($num_users / $rows_per_page);
		}
	}
			
	// get the details of the users
	if ($searchstring == "") {
		$num_pages = 1;
		$q = "SELECT * FROM " . TBL_USERS . " ORDER BY userlevel DESC,username";
		if ($rows_per_page > 0) {
			$q .= " LIMIT " . ($page-1) * $rows_per_page . "," . $rows_per_page;
		}
	} else {
		$num_pages = 1;
		$q = "SELECT * FROM " . TBL_USERS
			. " WHERE username LIKE '%" . $searchstring . "%' " 
	    	. " ORDER BY userlevel DESC,username";
		if ($rows_per_page > 0) {
			$q .= " LIMIT " . ($page-1) * $rows_per_page . "," . $rows_per_page;
		}
	}
	$result = $database->query($q);
	$num_rows = mysql_numrows($result);
	
	if (!$result || ($num_rows < 0)) {
		echo "<div align='center'><p class='error'>Error Searching for Users.</p></div>";
	}		

	# create hidden fields for navigation
	echo "<input type='hidden' id='curPage'  value='" . $page . "'/>";
	echo "<input type='hidden' id='maxPage'  value='" . $num_pages . "'/>";
	echo "<input type='hidden' id='numUsers' value='" . $num_users . "'/>";
	echo "<table class='admintable'>\n";
	if ($num_rows != 0) {
		// display table contents
		echo "<tr><th>Username</th><th>Level</th><th>Email</th><th>Active</th><th>Last Active</th></tr>\n";
		for ($i = 0; $i < $num_rows; $i++) {
			if (($i % 2) == 1)
				echo "<tr class='altrow'>\n";
			else
				echo "<tr>\n";
			$uname  = mysql_result($result, $i, "username");
			$ulevel = mysql_result($result, $i, "userlevel");
			$email  = mysql_result($result, $i, "email");
			$time   = date("M d, Y", mysql_result($result, $i, "timestamp"));
			$active = ((mysql_result($result, $i, "active") == 1) ? "Yes" : "No");
			//echo "<td><a href='" . SITE_BASEDIR . "/useredit.php?uname=" . $uname
			//	. "'><img src='" . SITE_BASEDIR . "/images/edit-icon.png'></img></a>";
			//echo "<td><a href='" . SITE_BASEDIR . "/userdelete.php?uname=" . $uname 
			//	. "' onclick=\"return confirm('Are you sure you want to delete this user?')\""
			//	. "'><img src='" . SITE_BASEDIR . "/images/delete-icon.png'></img></a>";
			echo "<td><a href=''>$uname</a></td>\n";
			echo "<td class='centerAlign'>$ulevel</td>\n";
			echo "<td>$email</td>\n";
			echo "<td class='centerAlign'>$active</td>\n";
			echo "<td class='centerAlign'>$time</td>\n";
			echo "</tr>\n";			
		}
	} else {
		// display empty table
		echo "<tr><td>No results found</td></tr>";
	}
	echo "</table>\n";

?>
