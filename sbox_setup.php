<?php
/*******************************************************************************
	This is a simplified script to add settings into SMF.

	ATTENTION: If you are trying to INSTALL this package, please access
	it directly, with a URL like the following:
		http://www.yourdomain.tld/forum/add_settings.php (or similar.)

================================================================================

	This script can be used to add new settings into the database for use
	with SMF's $modSettings array.  It is meant to be run either from the
	package manager or directly by URL.

*******************************************************************************/

// Set the below to true to overwrite already existing settings with the defaults. (not recommended.)
$overwrite_old_settings = false;

// List settings here in the format: setting_key => default_value.  Escape any "s. (" => \")
$mod_settings = array(
	'sbox_Visible' => '1',
	'sbox_GuestAllowed' => '0',
	'sbox_GuestVisible' => '0',
	'sbox_SmiliesVisible' => '1',
	'sbox_UserLinksVisible' => '1',
	'sbox_AllowBBC' => '1',
	'sbox_DoHistory' => '1',
	'sbox_MaxLines' => '50',
	'sbox_Height' => '180',
	'sbox_RefreshTime' => '20',
	'sbox_BlockRefresh' => '1',
	'sbox_FontFamily1' => 'Verdana, sans-serif',
	'sbox_FontFamily2' => 'Verdana, sans-serif',
	'sbox_TextSize1' => 'xx-small',
	'sbox_TextColor1' => '#000000',
	'sbox_TextSize2' => 'xx-small',
	'sbox_TextColor2' => '#476c8e',
	'sbox_BackgroundColor' => '#e5e5e8',
	'sbox_EnableSounds' => '0',
);

/******************************************************************************/

// If SSI.php is in the same place as this file, and SMF isn't defined, this is being run standalone.
if (file_exists(dirname(__FILE__) . '/SSI.php') && !defined('SMF'))
	require_once(dirname(__FILE__) . '/SSI.php');
// Hmm... no SSI.php and no SMF?
elseif (!defined('SMF'))
	die('<b>Error:</b> Cannot install - please verify you put this in the same place as SMF\'s index.php.');

// Turn the array defined above into a string of MySQL data.
$string = '';
foreach ($mod_settings as $k => $v)
	$string .= '
			(\'' . $k . '\', \'' . $v . '\'),';

// Sorted out the array defined above - now insert the data!
if ($string != '')
	$result = db_query("
		" . ($overwrite_old_settings ? 'REPLACE' : 'INSERT IGNORE') . " INTO {$db_prefix}settings
			(variable, value)
		VALUES" . substr($string, 0, -1));

// Uh-oh spaghetti-oh!
if ($result === false)
	echo '<b>Error:</b> Settings insertion failed!<br />';

$result = db_query("
  			CREATE TABLE `{$db_prefix}sbox_content` (
  			`id` int(11) unsigned NOT NULL auto_increment, 
  			`time` int(10) unsigned NOT NULL,
  			`ID_MEMBER` mediumint(8) unsigned NOT NULL,
    			`content` text NOT NULL,
    			PRIMARY KEY (`id`))");

// Uh-oh spaghetti-oh!
if ($result === false)
	echo '<b>Error:</b> Table setup failed!<br />';

if (file_exists($sourcedir . '/sboxDB.php')) {
  $result = chmod($sourcedir . '/sboxDB.php', 0644);
  if ($result === false)
    echo '<b>Error:</b> CHMOD for sboxDB.php failed!<br />';
}

?>
