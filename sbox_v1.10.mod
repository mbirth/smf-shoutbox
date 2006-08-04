<id>
SMF Shoutbox
</id>

<version>
1.10
</version>

<mod info>
This is a shoutbox with seamless integration into SMF.

Any registered user and any guest (if you allow them to use it) can type in a message and click shout.
The shoubox appears above the board index of the default theme. To do that, BoardIndex.template.php
of the default theme will be modified.
If you are using another theme, please modify the BoardIndex.template.php of that theme manually.
Maybe you have to modify sbox.template.php a little bit if u are using an "unusual" theme.

Instructions:
1. Install SMF shoutbox using boardmod (it´s too complex to install manually)
2. Go into the Feature Settings page and choose the appropriate settings
3. Type in a message and click Shout!

If you really want to install this mod manually, please use this file as a "how to".

Author:
The SMF shoutbox was originally written by Deep, some code ist "stolen" from Matthew Wolf (a.k.a Grudge).
The current version was heavily improved by Markus Birth.
Thanks a lot, Grudge!

Please direct any questions regarding this version to Deep, either by email (diem4@gmx.net) or by posting
in the appropriate place at www.simplemachines.org (the preferred option!)

History:
Version 1.10
1. sequential messages from one user have the same color
2. character limit for one shout has been raised to 320 chars (like one long SMS ;-)
3. displayed weekdays are now in the language the user has chosen in SMF and from SMF's language files
4. sBox-time is kept in sync with SMF's time (including all timezone-stuff)
5. there's a bar displayed showing what's new since the last refresh
6. poster's name can be clicked to show his profile
7. no HTML allowed
8. your own nick is made bold and a sound is played on first occurence
9. sbox now uses SMF's smileys and BBCode, option in settings shows the smiley-row known from posting messages in SMF
10. now user's "Display Name"s are shown instead of usernames
!! There's some experimental code commented out - maybe someone will make it work some day. It's
!! for showing who's viewing the shoutbox and for giving each user a specific unique distinguishable color.

version 1.04
1. font family is now adjustable
2. german language pack extracted

version 1.03
1. another refreshing bug fixed
2. help texts (admin interface) added
3. javascript bug (opera and netscape only) fixed
4. smilie window now can be made invisible
5. shouts can be deleted by admin
6. font color, font size and background color can be adjusted

version 1.02
1. javascript/html bugs fixed
2. error when shouting empty string fixed

version 1.01:
1. some debug code removed
2. refreshing bug fixed
3. file path bug fixed

version 1.00:
Original Version
</mod info>

<author>
Deep and Markus Birth
</author>

<homepage>
No homepage available at the moment
</homepage>

<edit file>
$languagedir/Modifications.english.php
</edit file>

<search for>
?>
</search for>

<add before>

//SMF Shoutbox
$txt['sbox_ModTitle'] = 'SMF Shoutbox';
$txt['sbox_Visible'] = 'Shoutbox is visible';
$txt['sbox_GuestAllowed'] = 'Guests are allowed to shout';
$txt['sbox_MaxLines'] = 'Maximum number of displayed lines';
$txt['sbox_Height'] = 'Shoutbox height';
$txt['sbox_SmiliesVisible'] = 'Smiley row is visible';
$txt['sbox_KillShout'] = 'Dou you want to kill this shout?';
$txt['sbox_TextSize1'] = '1. Font size';
$txt['sbox_TextColor1'] = '1. Font color';
$txt['sbox_TextSize2'] = '2. Font size';
$txt['sbox_TextColor2'] = '2. Font color';
$txt['sbox_RefreshTime'] = 'Refresh time';
$txt['sbox_BackgroundColor'] = 'Background color';
$txt['sbox_FontFamily1'] = '1. Font family';
$txt['sbox_FontFamily2'] = '2. Font family';
$txt['sbox_Refresh'] = 'Refresh';
</add before>


<edit file>
$languagedir/Help.english.php
</edit file>

<search for>
?>
</search for>

<add before>

//SMF Shoutbox
$helptxt['sbox_Visible'] = 'Here you can decide wether the shoutbox is visible at all or not.';
$helptxt['sbox_GuestAllowed'] = 'Here you can decide whether guests are allowed to post new shouts.';
$helptxt['sbox_MaxLines'] = 'Here you can enter the maximal count of lines displayed in the shoutbox.';
$helptxt['sbox_Height'] = 'Here you can enter the height (pixels) of the shoutbox.';
$helptxt['sbox_SmiliesVisible'] = 'Here you can decide whether smileys are visible or not. They work independently of this setting.';
$helptxt['sbox_TextSize1'] = 'Here you can adjust the 1. font size';
$helptxt['sbox_TextColor1'] = 'Here you can adjust the 1. font color';
$helptxt['sbox_TextSize2'] = 'Here you can adjust the 2. font size';
$helptxt['sbox_TextColor2'] = 'Here you can adjust the 2. font color';
$helptxt['sbox_RefreshTime'] = 'Here you can adjust the refresh time';
$helptxt['sbox_BackgroundColor'] = 'Here you can adjust the background color';
$helptxt['sbox_FontFamily1'] = 'Here you can adjust the 1. font family.';
$helptxt['sbox_FontFamily2'] = 'Here you can adjust the 2. font family.';
</add before>


<edit file>
$sourcedir/ModSettings.php
</edit file>

<search for>
		'karma' => 'ModifyKarmaSettings',
</search for>

<add after>
		'sbox' => 'ModifySboxSettings',
</add after>

<search for>
			'layout' => array(
				'title' => $txt['mods_cat_layout'],
				'href' => $scripturl . '?action=featuresettings;sa=layout;sesc=' . $context['session_id'],
			),
</search for>

<add after>
			'sbox' => array(
				'title' => $txt['sbox_ModTitle'],
				'href' => $scripturl . '?action=featuresettings;sa=sbox;sesc=' . $context['session_id'],
			),
</add after>

<search for>
function ModifyKarmaSettings()
</search for>

<add before>
function ModifySboxSettings()
{
	global $txt, $scripturl, $context, $settings, $sc;

	$config_vars = array
	(
		array('check', 'sbox_Visible'),
		array('check', 'sbox_GuestAllowed'),
		array('check', 'sbox_SmiliesVisible'),
		array('int', 'sbox_MaxLines'),
		array('int', 'sbox_Height'),
		array('int', 'sbox_RefreshTime'),
		array('select', 'sbox_FontFamily1', array(
												'Garamond, serif' => 'Garamond, serif',
												'Times, serif' => 'Times, serif',
												'Arial, Helvetica, sans-serif' => 'Arial, Helvetica, sans-serif',
												'Tahoma, Helvetica, sans-sarif' => 'Tahoma, Helvetica, sans-sarif',
												'Verdana, sans-serif' => 'Verdana, sans-serif',
												'cursive' => 'cursive',
												'Palatino, fantasy' => 'Palatino, fantasy',
												'Courier, monospace' => 'Courier, monospace'
												),
			),
		array('select', 'sbox_FontFamily2', array(
												'Garamond, serif' => 'Garamond, serif',
												'Times, serif' => 'Times, serif',
												'Arial, Helvetica, sans-serif' => 'Arial, Helvetica, sans-serif',
												'Tahoma, Helvetica, sans-sarif' => 'Tahoma, Helvetica, sans-sarif',
												'Verdana, sans-serif' => 'Verdana, sans-serif',
												'cursive' => 'cursive',
												'Palatino, fantasy' => 'Palatino, fantasy',
												'Courier, monospace' => 'Courier, monospace'
												),
			),
		array('select', 'sbox_TextSize1', array(
												'8px' => '8xp',
												'9px' => '9xp',
												'10px' => '10xp',
												'11px' => '11xp',
												'12px' => '12xp',
												'13px' => '13xp',
												'14px' => '14xp',
												'15px' => '15xp',
												'16px' => '16xp',
												'xx-small' => 'xx-small',
												'x-small' => 'x-small',
												'small' => 'small',
												'medium' => 'medium',
												'large' => 'large',
												'x-large' => 'x-large',
												'xx-large' => 'xx-large'
												),
			),
		array('text', 'sbox_TextColor1'),
		array('select', 'sbox_TextSize2', array(
												'8px' => '8xp',
												'9px' => '9xp',
												'10px' => '10xp',
												'11px' => '11xp',
												'12px' => '12xp',
												'13px' => '13xp',
												'14px' => '14xp',
												'15px' => '15xp',
												'16px' => '16xp',
												'xx-small' => 'xx-small',
												'x-small' => 'x-small',
												'small' => 'small',
												'medium' => 'medium',
												'large' => 'large',
												'x-large' => 'x-large',
												'xx-large' => 'xx-large'
												),
			),
		array('text', 'sbox_TextColor2'),
		array('text', 'sbox_BackgroundColor')
	);

	// Saving?
	if (isset($_GET['save']))
	{
		saveDBSettings($config_vars);
		redirectexit('action=featuresettings;sa=sbox');
	}

	$context['post_url'] = $scripturl . '?action=featuresettings2;save;sa=sbox';
	$context['settings_title'] = $txt['sbox_ModTitle'];

	prepareDBSettingContext($config_vars);
}

</add before>

<edit file>
$sourcedir/Subs.php
</edit file>

<search for>
		log_error('Copyright removed!!');
	}
}
</search for>

<add after>

function sbox()
{
	global $sourcedir;

	include_once("$sourcedir/sbox.php");
	sbox_display();
}

</add after>

<edit file>
$themedir/BoardIndex.template.php
</edit file>

<search for>
				<script language="JavaScript" type="text/javascript" src="', $settings['default_theme_url'], '/fader.js"></script>
			</td>
		</tr>
	</table>';
	}
</search for>

<add after>

  // display shoutbox
  if (function_exists('sbox')) sbox();
</add after>

<edit file>
$themedir/index.template.php
</edit file>

<search for>
	echo $context['html_headers'], '
</search for>

<add after>
		<script language="JavaScript" type="text/javascript"><!-- // --><![CDATA[
			var current_header_sb = ', empty($options['collapse_header_sb']) ? 'false' : 'true', ';

			function shrinkHeaderSB(mode)
			{';

	if ($context['user']['is_guest'])
		echo '
				document.cookie = "upshrinkSB=" + (mode ? 1 : 0);';
	else
		echo '
				smf_setThemeOption("collapse_header_sb", mode ? 1 : 0, null, "', $context['session_id'], '");';

	echo '
				document.getElementById("upshrink_sb").src = smf_images_url + (mode ? "/expand.gif" : "/collapse.gif");

				document.getElementById("upshrinkHeaderSB").style.display = mode ? "none" : "";

				current_header_sb = mode;
			}
		// ]]></script>

</add after>

