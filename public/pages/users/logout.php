<?php

include_once("common.inc");
include_once("session.php");

$session->logout();
header("Location: " . SITE_BASEDIR);
?>