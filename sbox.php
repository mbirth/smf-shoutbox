<?php
/******************************************************************************
* shout.php	                                                                  *
*******************************************************************************
* SMF: Simple Machines Forum - SMF Shoutbox MOD                               *
* Open-Source Project Inspired by Zef Hemel (zef@zefhemel.com)                *
* =========================================================================== *
* Software Version:           1.00  	                                      *
* Software originally by:     ? 				      						  *
* Ported to SMF by:	      Deep    		      								  *
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

if (!defined('SMF'))
	die('Hacking attempt...');

function sbox_display()
{
	global $user_info, $db_prefix, $modSettings, $settings, $sourcedir, $scripturl, $txt, $context;

	if ($modSettings['sbox_Visible'] != '0')
	{
		// Load the template!
		loadTemplate('sbox');
		template_shout_box();
	}
}
?>
