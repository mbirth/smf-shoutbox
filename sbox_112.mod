<id>
SMF Shoutbox
</id>

<version>
1.12
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
Version 1.12
* made compatible with SMF 1.1rc3
* moved basic strings from Modifications.<lang>.php to sbox.<lang>.php so that there now is language fallback to English (and 1 file less to change)
+ check for lock before removing History file
x JavaScript clear() was reserved, renamed to clearHist()
x active refresh on new shout
+ included language pack into main setup package so that distribution should be easier

Version 1.11
+ added German language-pack
+ added switch to disable linking to profile pages
+ added switch to disable Refresh after there have been no posts in lastActive time
* shortened some CSS classnames

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
loadLanguage('sbox');

function ModifySboxSettings()
{
	global $txt, $scripturl, $context, $settings, $sc;

	$config_vars = array
	(
		array('check', 'sbox_Visible'),
		array('check', 'sbox_GuestVisible'),
		array('check', 'sbox_GuestAllowed'),
		array('check', 'sbox_SmiliesVisible'),
		array('check', 'sbox_UserLinksVisible'),
		array('check', 'sbox_AllowBBC'),
		array('check', 'sbox_DoHistory'),
		array('int', 'sbox_MaxLines'),
		array('int', 'sbox_Height'),
		array('int', 'sbox_RefreshTime'),
		array('check', 'sbox_BlockRefresh'),
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
		                    '6pt' => '6pt',
		                    '7pt' => '7pt',
												'8pt' => '8pt',
												'9pt' => '9pt',
												'10pt' => '10pt',
												'11pt' => '11pt',
												'12pt' => '12pt',
												'13pt' => '13pt',
												'14pt' => '14pt',
												'15pt' => '15pt',
												'16pt' => '16pt',
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
		                    '6pt' => '6pt',
		                    '7pt' => '7pt',
												'8pt' => '8pt',
												'9pt' => '9pt',
												'10pt' => '10pt',
												'11pt' => '11pt',
												'12pt' => '12pt',
												'13pt' => '13pt',
												'14pt' => '14pt',
												'15pt' => '15pt',
												'16pt' => '16pt',
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
		array('text', 'sbox_BackgroundColor'),
		array('check', 'sbox_EnableSounds'),
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
$languagedir/Help.english.php
</edit file>

<search for>
?>
</search for>

<add before>

//SMF Shoutbox
$helptxt['sbox_Visible'] = 'Here you can decide wether the shoutbox is visible at all or not.';
$helptxt['sbox_GuestAllowed'] = 'Here you can decide whether guests are allowed to post new shouts.';
$helptxt['sbox_GuestVisible'] = 'Defines whether the Shoutbox is visible to guests at all.';
$helptxt['sbox_MaxLines'] = 'Here you can enter the maximal count of lines displayed in the shoutbox.';
$helptxt['sbox_Height'] = 'Here you can enter the height (pixels) of the shoutbox.';
$helptxt['sbox_SmiliesVisible'] = 'Here you can decide whether smileys are visible or not. They work independently of this setting, though.';
$helptxt['sbox_UserLinksVisible'] = 'Defines whether the names of shouters are linked to their profile page or not.';
$helptxt['sbox_RefreshTime'] = 'Here you can adjust the refresh time';
$helptxt['sbox_BlockRefresh'] = 'Defines whether the Shoutbox should stop refreshing after there have been no new shouts for a while. Users can still manually refresh the Shoutbox. The time treshold used is the <i>User online time treshold</i> found in the <i>Basic Features</i>-settings. (currently ' . $modSettings['lastActive'] . ' minutes)';
$helptxt['sbox_DoHistory'] = 'Defines whether all shouts should be written to a file so that an Administrator can check what was going on.';
$helptxt['sbox_AllowBBC'] = 'Defines whether users are allowed to use BBCode in shouts. If disabled, only plain text is displayed - no smileys, no formatting.';
$helptxt['sbox_EnableSounds'] = 'Enables the notification sound, when your nickname was mentioned since the last refresh.';
</add before>
