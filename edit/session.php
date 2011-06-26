<?php
session_start();
if (isset($_SESSION['loggedin'])) {
	echo "Session is sets <br />";
} else {
	echo "Session is NOT sets <br />";
}
echo "$_SESSION[ci_sessions]: " . $_SESSION['ci_sessions'] . "<br />";
echo "$_SESSION[group]: " . $_SESSION['group'] . "<br />";
echo $_COOKIE['group'];
?>