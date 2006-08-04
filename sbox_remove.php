<?php
/******************************************************************************
* sbox_remove.php	                                                          *
*******************************************************************************
* SMF: Simple Machines Forum - SMF Shoutbox MOD                               *
* Open-Source Project Inspired by Zef Hemel (zef@zefhemel.com)                *
* =========================================================================== *
* Software Version:           1.04	                                          *
* Software originally by:     ?				      							  *
* Ported to SMF by:	      Deep, most code stolen from Matthew Wolf (Grudge)   *
* Support, News, Updates at:  http://www.simplemachines.org                   *
*******************************************************************************
* This program is free software; you may redistribute it and/or modify it     *
* under the terms of the provided license as published by Lewis Media.        *
*                                                                             *
* This program is distributed in the hope that it is and will be useful,      *
* but WITHOUT ANY WARRANTIES; without even any implied warranty of            *
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.                        *
*                                                                             *
* See the "license.txt" file for details of the Simple Machines license.      *
* The latest version can always be found at http://www.simplemachines.org.    *
******************************************************************************/

echo'
	<html>
	<head>
		<title>SMF DataBase Editor - Ultimate Shoutbox</title>
	</head>
	<body bgcolor="#FFFFFF">
	<center>
	<table border="0" cellspacing="1" cellpadding="4" bgcolor="#000000" width="90%">
	<tr>
		<th bgcolor="#34699E"><font color="#FFFFFF">SMF DB Editor - SMF-Shoutbox MOD - SQL UNINSTALL</font></th>
	</tr>';

if (!isset($_REQUEST['sa']))
{
	echo'
	<tr>
 	<td bgcolor="#FFFFFF" align="center">
		<font size="2"><a href="sbox_remove.php?sa=doit&man=yes">Click here to start shoutbox uninstallation</font></a><br /</td></tr></table>
	';	
}
else
{
	echo '</table>';

	if ((isset($_REQUEST['man'])) || (!isset($db_name)))
	{
		require_once (dirname(realpath($_SERVER['SCRIPT_FILENAME'])) . "/Settings.php");
		$dbcon = mysql_connect($db_server, $db_user, $db_passwd);
		mysql_select_db($db_name);
	}

	$error=0;
	$shoutChunkSize = 350;
	$timeLimitThreshold = 10;
	$self = &$_SERVER['PHP_SELF'];
	$start_time = time();
	
	// Now time to make the new table	
	$result = mysql_query("DROP TABLE {$db_prefix}sbox_content;");
	if (!$result)
	{
   		echo "<font color=red>Error removing shoutbox table. SQL Error: ".mysql_error()."</font><BR />";
		$error++;
    }
	else
		echo "<font color=green>Shoutbox table deleted!</font><BR />";

	$result = mysql_query("DELETE FROM {$db_prefix}settings	WHERE variable LIKE 'sbox_%';");
	if(!$result)
	{
    	echo "<font color=red>Settings: ".mysql_error().".</font><br />";
		$error++;
	}
	else
		echo "<font color=green>Settings removed correctly!</font><br />";

	$done = 1;

	// Result
	if (isset($done))
	{
		echo "</td></tr></table>";
		if($error==0)
	 		echo "<P>Downgrade of SQL was successfull.";
		elseif ($error==1)
	 		echo "<P>There was <B>one</B> error when downgrading your SQL.";
		elseif ($error>1)
	 		echo "<P>There were <B>$error</B> errors when downgrading your SQL.";
 	}
}
echo '</body></html>';

?>
