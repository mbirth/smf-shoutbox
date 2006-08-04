<id>
SMF Shoutbox
</id>

<version>
1.04
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
The SMF shoutbox was written by Deep, some code ist "stolen" from Matthew Wolf (a.k.a Grudge).
Thanks a lot, Grudge!

Please direct any questions regarding this version to Deep, either by email (diem4@gmx.net) or by posting
in the appropriate place at www.simplemachines.org (the preferred option!)

History:
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
Deep
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
$txt['sbox_SmiliesVisible'] = 'Smilie window is visible';
$txt['sbox_smilie01_text'] = 'blblbl!';
$txt['sbox_smilie02_text'] = 'grinning';
$txt['sbox_smilie03_text'] = 'laughing';
$txt['sbox_smilie04_text'] = 'kissing';
$txt['sbox_smilie05_text'] = 'smiling';
$txt['sbox_smilie06_text'] = 'that´s okay!';
$txt['sbox_smilie07_text'] = 'smoking';
$txt['sbox_smilie08_text'] = 'greeting';
$txt['sbox_smilie09_text'] = 'cheerio!';
$txt['sbox_smilie10_text'] = 'oops';
$txt['sbox_smilie11_text'] = 'praying';
$txt['sbox_smilie12_text'] = 'crying';
$txt['sbox_smilie13_text'] = 'angry';
$txt['sbox_smilie14_text'] = 'baaaaaad';
$txt['sbox_smilie15_text'] = 'headbanging';
$txt['sbox_smilie01_code'] = ':frech:';
$txt['sbox_smilie02_code'] = ';-)';
$txt['sbox_smilie03_code'] = ':-]';
$txt['sbox_smilie04_code'] = ':-s';
$txt['sbox_smilie05_code'] = ':-)';
$txt['sbox_smilie06_code'] = ':-!';
$txt['sbox_smilie07_code'] = ':smoking:';
$txt['sbox_smilie08_code'] = ':greeting:';
$txt['sbox_smilie09_code'] = ':cheerio:';
$txt['sbox_smilie10_code'] = ':-O';
$txt['sbox_smilie11_code'] = ':praying:';
$txt['sbox_smilie12_code'] = ':crying:';
$txt['sbox_smilie13_code'] = ':-(';
$txt['sbox_smilie14_code'] = ':bad:';
$txt['sbox_smilie15_code'] = ':bang:';
$txt['sbox_smilie01_file'] = 'sbox_funny.gif';
$txt['sbox_smilie02_file'] = 'sbox_grin.gif';
$txt['sbox_smilie03_file'] = 'sbox_laugh.gif';
$txt['sbox_smilie04_file'] = 'sbox_kiss.gif';
$txt['sbox_smilie05_file'] = 'sbox_smile.gif';
$txt['sbox_smilie06_file'] = 'sbox_yeah.gif';
$txt['sbox_smilie07_file'] = 'sbox_smoke.gif';
$txt['sbox_smilie08_file'] = 'sbox_hand.gif';
$txt['sbox_smilie09_file'] = 'sbox_cheerio.gif';
$txt['sbox_smilie10_file'] = 'sbox_oops.gif';
$txt['sbox_smilie11_file'] = 'sbox_church.gif';
$txt['sbox_smilie12_file'] = 'sbox_cry.gif';
$txt['sbox_smilie13_file'] = 'sbox_angry.gif';
$txt['sbox_smilie14_file'] = 'sbox_bad.gif';
$txt['sbox_smilie15_file'] = 'sbox_bang.gif';
$txt['sbox_Monday'] = 'Monday';
$txt['sbox_Tuesday'] = 'Tuesday';
$txt['sbox_Wednesday'] = 'Wednesday';
$txt['sbox_Thurday'] = 'Thurday';
$txt['sbox_Friday'] = 'Friday';
$txt['sbox_Saturday'] = 'Saturday';
$txt['sbox_Sunday'] = 'Sunday';
$txt['sbox_KillShout'] = 'Dou you want to kill this shout?';
$txt['sbox_TextSize1'] = '1. Font size';
$txt['sbox_TextColor1'] = '1. Font color';
$txt['sbox_TextSize2'] = '2. Font size';
$txt['sbox_TextColor2'] = '2. Font color';
$txt['sbox_RefreshTime'] = 'Refresh time';
$txt['sbox_BackgroundColor'] = 'Background color';
$txt['sbox_FontFamily1'] = '1. Font family';
$txt['sbox_FontFamily2'] = '2. Font family';
</add before>


<edit file>
$languagedir/Help.english.php
</edit file>

<search for>
?>
</search for>

<add before>
//SMF Shoutbox
$helptxt['sbox_Visible'] = 'Here you can decide wether the shoutbox is visible or not,';
$helptxt['sbox_GuestAllowed'] = 'Here you can decide wether the shoutbox smilies are visible or not';
$helptxt['sbox_MaxLines'] = 'Here you can enter the maximal count of lines display by shoutbox.';
$helptxt['sbox_Height'] = 'Here you can enter the height (pixels) of the shoutbox.';
$helptxt['sbox_SmiliesVisible'] = 'Here you can decide wether smilies are visible or not.';
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

<edit file>
$themedir/script.js
</edit file>

<search for>
	doForm.admin_hash_pass.value = hex_sha1(hex_sha1(username.toLowerCase() + doForm.admin_pass.value) + cur_session_id);
	doForm.admin_pass.value = doForm.admin_pass.value.replace(/./g, "*");
}
</search for>

<add after>

function clearSbox()
{
	// Delete shoutbox message text after shout has been submitted
	if (document.sbox)
		document.sbox.sboxText.value="";
}

function insertSmilie(smilieCode)
{
	// insert smilie code into shoutbox text
	if (document.sbox)
	{
		var smilie = " " + smilieCode;
		var sboxText = document.sbox.sboxText;

	  	if (sboxText.textLength) 
		  	if (sboxText.textLength >= 0) 
		  	{
				sboxText.focus();
				var startSelection = sboxText.selectionStart;
				var endSelection = sboxText.textLength;
				sboxText.value = sboxText.value.substring(0,startSelection) + smilie + sboxText.value.substring(sboxText.selectionEnd,endSelection);
				sboxText.selectionStart = startSelection;
				sboxText.selectionEnd = startSelection;
				sboxText.selectionStart = sboxText.selectionStart + smilie.length;
				return;
			}
		var browser = navigator.userAgent.toLowerCase();
		var browserInternetExplorer = ((browser.indexOf("msie") != -1)  && (browser.indexOf("opera") == -1));
		var platformWindows = ((browser.indexOf("win")!=-1) || (browser.indexOf("16bit")!=-1));
		if (browserInternetExplorer && platformWindows && (parseInt(navigator.appVersion) >= 4)) 
		{
			if(sboxText.isTextEdit)
			{
				sboxText.focus();
				var selection = document.selection;
				var range = selection.createRange();
				range.colapse;
				if (range != null && (selection.type == "Text" || selection.type == "None"))
					range.text = smilie;
				return;
			}
		}
   		sboxText.value += smilie;	
		sboxText.focus();	
	}
}

</add after>
