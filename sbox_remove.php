<?php
/*******************************************************************************
  This is a simplified script to remove settings from SMF.

  ATTENTION: If you are trying to UNINSTALL this package, please access
  it directly, with a URL like the following:
    http://www.yourdomain.tld/forum/sbox_remove.php (or similar.)

================================================================================

  This script can be used to remove settings from the database for use
  with SMF's $modSettings array.  It is meant to be run either from the
  package manager or directly by URL.

*******************************************************************************/

// Type the settings prefix here
$mod_settings_prefix = 'sbox_';

/******************************************************************************/

// If SSI.php is in the same place as this file, and SMF isn't defined, this is being run standalone.
if (file_exists(dirname(__FILE__) . '/SSI.php') && !defined('SMF'))
  require_once(dirname(__FILE__) . '/SSI.php');
// Hmm... no SSI.php and no SMF?
elseif (!defined('SMF'))
  die('<b>Error:</b> Cannot uninstall - please verify you put this in the same place as SMF\'s index.php.');

// drop table if it exists. Should make SMF-update 1.1rc2 -> 1.1rc3 easier.
$result = db_query("DROP TABLE `{$db_prefix}sbox_content`", __FILE__, __LINE__);

// Uh-oh spaghetti-oh!
if ($result === false)
  echo '<b>Error:</b> Table drop failed!<br />';

$result = db_query("DELETE FROM `{$db_prefix}settings` WHERE variable LIKE '{$mod_settings_prefix}%'", __FILE__, __LINE__);

// Uh-oh spaghetti-oh!
if ($result === false)
  echo '<b>Error:</b> Settings removal failed!<br />';

?>
