<?php
/**
 * users.php
 */

# setup include path
if (!defined("PATH_SEPARATOR")) {
	if (strpos($_ENV["OS"], "Win") !== false)
	define("PATH_SEPARATOR", ";");
	else define("PATH_SEPARATOR", ":");
}
ini_set("include_path", "." . PATH_SEPARATOR . "../" . PATH_SEPARATOR
. "./include" . PATH_SEPARATOR . "../../include");

# home page is selected from navigation menu
session_register("SESS_NAVITEM");
$_SESSION['SESS_NAVITEM'] = 0;

include_once("header.php");

?>

<div id="toptitle">
	<h2>User Administration</h2>
</div>

<?php

// check if user is an administrator
if (!$session->isAdmin()){
	echo "<p>Sorry, this page is only available for use by administrators.</p>";
} else {

?>

<div class="tableNav">
	<input id="firstButton" type="button" value="&nbsp;&lt;&lt;&nbsp;"/>
	&nbsp;
	<input id="prevButton" type="button" value="&nbsp;&lt;&nbsp;"/>
	&nbsp;
	<input id="nextButton" type="button" value="&nbsp;&gt;&nbsp;"/>
	&nbsp;
	<input id="lastButton" type="button" value="&nbsp;&gt;&gt;&nbsp;"/>
	&nbsp;
	<label id="searchLabel" for="searchString" class="formInputLabel">Filter:</label>
	<select id="filterString" class="formInputText">
		<option id="1">Username</option>
	</select>
	&nbsp; 
	<input id="searchString" class="formInputText" style="width:100px" type="text" 
		name="searchstring" maxlength="40" value=""/>
	&nbsp;
	<span id="waiting" style="visibility: hidden">			
		<img align="top" src="<?php echo SITE_PREFIX; ?>/images/waiter.gif"/>
		&nbsp;
		<div id="waitingText" style="display:none"><strong>Loading...<strong></div>
	</span>	
</div>
<div id="results">
	<input type="hidden" id="curPage" value="1"/>
	<input type="hidden" id="maxPage" value="1"/>
	<input type="hidden" id="items"   value="1"/>
	<table class="admintable">
		<tr><td>&nbsp;</td></tr>
	</table>
</div>
<div class="tableSummary">
	<label id="numUsersLabel" class="formInputLabel"></label>
	&nbsp;|&nbsp;
	<label id="rowsLabel" for="rowsString" class="formInputLabel">Showing </label>
	<input id="rowsString" class="formInputText" style="width:20px" type="text" 
		name="rowsString" maxlength="4" value="<?php echo PAGE_LIMIT; ?>"/>
	<label id="rowsLabel2" class="formInputLabel">per page</label>
	&nbsp;|&nbsp;
	<a id="allRows" href="">Show all</a>	
</div>
		
<?php 
}

include_once("footer.php");

?>
