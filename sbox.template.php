<?php

function template_shout_box() {
	global $context, $settings, $options, $txt, $user_info, $scripturl, $modSettings,
	       $forum_version, $sourcedir, $boarddir, $boardurl;
	
	$themedir = $settings['default_theme_url'];
	$imgdir = $themedir."/images/";
	$sourceurl = str_replace($boarddir, $boardurl, $sourcedir);
	
	if ($context['user']['is_guest'] && $modSettings['sbox_GuestVisible'] != '1') return;

	echo '
	  <script language="JavaScript" type="text/javascript"><!-- // --><![CDATA[
			var current_header_sb = ' . ((empty($options['collapse_header_sb']))?'false':'true') . ';

			function shrinkHeaderSB(mode) {';

	if ($context['user']['is_guest']) {
		echo '
				document.cookie = "upshrinkSB=" + (mode ? 1 : 0);';
	} else {
		echo '
				smf_setThemeOption("collapse_header_sb", mode?1:0, null, "' . $context['session_id'] . '");';
	}

	echo '
				document.getElementById("upshrink_sb").src = smf_images_url + (mode ? "/expand.gif" : "/collapse.gif");
				document.getElementById("upshrinkHeaderSB").style.display = mode ? "none" : "";
				current_header_sb = mode;
			}

    	function clearSbox() {
      	// Delete shoutbox message text after shout has been submitted
      	if (document.sbox)
      		document.sbox.sboxText.value="";
      }
      
      function submitSbox() {
        pretxt = \'' . $txt['sbox_TypeShout'] . '\';
        prelen = pretxt.length;
        xval = document.sbox.sboxText.value;
        if (xval.toLowerCase() == pretxt.toLowerCase()) return false;
        while (xval.toLowerCase().indexOf(pretxt.toLowerCase()) >= 0) {
          xpos = xval.toLowerCase().indexOf(pretxt.toLowerCase());
          xval = xval.substring(0, xpos) + xval.substring(xpos+prelen, xval.length);
        }
        document.sbox.sboxText.value = xval;
        setTimeout(\'clearSbox()\', 500);
        return true;
      }
  	// ]]></script>
	<div class="tborder"', $context['browser']['needs_size_fix'] && !$context['browser']['is_ie6'] ? ' style="width: 100%;"' : '', '>
		<div class="catbg" style="padding: 6px; vertical-align: middle; text-align: center;">		
			<a href="#" onclick="shrinkHeaderSB(!current_header_sb); return false;"><img id="upshrink_sb" src="', $settings['images_url'], '/', empty($options['collapse_header_sp']) ? 'collapse.gif' : 'expand.gif', '" alt="*" title="', $txt['upshrink_description'], '" style="margin-right: 2ex;" align="right" /></a>'.$txt['sbox_ModTitle'].'
		</div>
		<div id="upshrinkHeaderSB"', empty($options['collapse_header_sb']) ? '' : ' style="display: none;"', '>
			<table border="0" width="100%" cellspacing="1" cellpadding="4" class="bordercolor">
				<tr class="windowbg" align="right" style="width:13%">
					<td class="windowbg" style="width:87%">
						<table width="100%" border="0" cellspacing="1" cellpadding="0">
							<tr>
								<td align="center" valign="middle">
     	  					<form name="sbox" action="' . $sourceurl . '/sboxDB.php?action=write" method="post" target="sboxframe" style="margin: 0;" onSubmit="return submitSbox();" enctype="multipart/form-data" accept-charset="' . $context['character_set'] . '">
   									<a href="' . $sourceurl . '/sboxDB.php?" target="sboxframe"><img src="'.$imgdir.'sbox_refresh.gif" border="0" width="16" height="17" align="absmiddle" alt="' . $txt['sbox_Refresh'] . '" /></a>';
	if ((!$context['user']['is_guest']) || ($modSettings['sbox_GuestAllowed'] == "1")) {
	  echo '
			      			  <input type="hidden" name="ts" value="'.forum_time(true).'">
										<input class="windowbg2" type="text" name="sboxText" size="100" maxlength="320" onFocus="if (this.value==\'' . $txt['sbox_TypeShout'] . '\') this.value = \'\';" onBlur="if (this.value==\'\') this.value=\'' . $txt['sbox_TypeShout'] . '\';" />&nbsp;<input type="submit" class="input" value="&nbsp;shout&nbsp;" />';
	} else {
	  // guest is not allowed to shout ~~> show message
	  echo $txt['sbox_Login'];
	}
  echo '
          				</form>
                  <script language="JavaScript" type="text/javascript"><!-- // --><![CDATA[
                    document.sbox.sboxText.value = \'' . $txt['sbox_TypeShout'] . '\';
                  // ]]></script>
								</td>
							</tr>';

	if (($modSettings['sbox_SmiliesVisible'] == "1") && ((!$context['user']['is_guest']) || ($modSettings['sbox_GuestAllowed'] == "1")))	{
    sbox_loadSmileys();
    echo '
              <tr>
                <td align="center">';
    sbox_printSmileys();
    echo '
                </td>
              </tr>';
	}

  echo'
							<tr>
								<td>
	     						<iframe name="sboxframe" src="' . $sourceurl . '/sboxDB.php?" width="100%" height="'.$modSettings['sbox_Height'].'" frameborder="0" style="border: 2px ridge silver;"></iframe>
								</td>
							</tr>
						</table>
  				</td>
  			</tr>
  		</table>
  	</div>
  </div>';
}

// BEGIN: Borrowed from theme_postbox($msg) in Subs-Post.php (1.1rc3)
function sbox_loadSmileys() {
  global $context, $settings, $user_info, $txt, $modSettings, $db_prefix;
  
	// Initialize smiley array...
	$context['smileys'] = array(
		'postform' => array(),
		'popup' => array(),
	);

	// Load smileys - don't bother to run a query if we're not using the database's ones anyhow.
	if (empty($modSettings['smiley_enable']) && $user_info['smiley_set'] != 'none')
		$context['smileys']['postform'][] = array(
			'smileys' => array(
				array('code' => ':)', 'filename' => 'smiley.gif', 'description' => $txt[287]),
				array('code' => ';)', 'filename' => 'wink.gif', 'description' => $txt[292]),
				array('code' => ':D', 'filename' => 'cheesy.gif', 'description' => $txt[289]),
				array('code' => ';D', 'filename' => 'grin.gif', 'description' => $txt[293]),
				array('code' => '>:(', 'filename' => 'angry.gif', 'description' => $txt[288]),
				array('code' => ':(', 'filename' => 'sad.gif', 'description' => $txt[291]),
				array('code' => ':o', 'filename' => 'shocked.gif', 'description' => $txt[294]),
				array('code' => '8)', 'filename' => 'cool.gif', 'description' => $txt[295]),
				array('code' => '???', 'filename' => 'huh.gif', 'description' => $txt[296]),
				array('code' => '::)', 'filename' => 'rolleyes.gif', 'description' => $txt[450]),
				array('code' => ':P', 'filename' => 'tongue.gif', 'description' => $txt[451]),
				array('code' => ':-[', 'filename' => 'embarrassed.gif', 'description' => $txt[526]),
				array('code' => ':-X', 'filename' => 'lipsrsealed.gif', 'description' => $txt[527]),
				array('code' => ':-\\', 'filename' => 'undecided.gif', 'description' => $txt[528]),
				array('code' => ':-*', 'filename' => 'kiss.gif', 'description' => $txt[529]),
				array('code' => ':\'(', 'filename' => 'cry.gif', 'description' => $txt[530])
			),
			'last' => true,
		);
	elseif ($user_info['smiley_set'] != 'none')
	{
		if (($temp = cache_get_data('posting_smileys', 480)) == null)
		{
			$request = db_query("
				SELECT code, filename, description, smileyRow, hidden
				FROM {$db_prefix}smileys
				WHERE hidden IN (0, 2)
				ORDER BY smileyRow, smileyOrder", __FILE__, __LINE__);
			while ($row = mysql_fetch_assoc($request))
			{
				$row['code'] = htmlspecialchars($row['code']);
				$row['filename'] = htmlspecialchars($row['filename']);
				$row['description'] = htmlspecialchars($row['description']);

				$context['smileys'][empty($row['hidden']) ? 'postform' : 'popup'][$row['smileyRow']]['smileys'][] = $row;
			}
			mysql_free_result($request);

			cache_put_data('posting_smileys', $context['smileys'], 480);
		}
		else
			$context['smileys'] = $temp;
	}

	// Clean house... add slashes to the code for javascript.
	foreach (array_keys($context['smileys']) as $location)
	{
		foreach ($context['smileys'][$location] as $j => $row)
		{
			$n = count($context['smileys'][$location][$j]['smileys']);
			for ($i = 0; $i < $n; $i++)
			{
				$context['smileys'][$location][$j]['smileys'][$i]['code'] = addslashes($context['smileys'][$location][$j]['smileys'][$i]['code']);
				$context['smileys'][$location][$j]['smileys'][$i]['js_description'] = addslashes($context['smileys'][$location][$j]['smileys'][$i]['description']);
			}

			$context['smileys'][$location][$j]['smileys'][$n - 1]['last'] = true;
		}
		if (!empty($context['smileys'][$location]))
			$context['smileys'][$location][count($context['smileys'][$location]) - 1]['last'] = true;
	}
	$settings['smileys_url'] = $modSettings['smileys_url'] . '/' . $user_info['smiley_set'];
}
// END: Borrowed from theme_postbox($msg) in Subs-Post.php

// BEGIN: Borrowed from template_postbox(&$message) in Post.template.php (1.1rc3)
function sbox_printSmileys() {
  global $context, $txt, $settings;
  
  loadLanguage('Post');
  
	// Now start printing all of the smileys.
	if (!empty($context['smileys']['postform']))
	{
		// Show each row of smileys ;).
		foreach ($context['smileys']['postform'] as $smiley_row)
		{
			foreach ($smiley_row['smileys'] as $smiley)
				echo '
					<a href="javascript:void(0);" onclick="replaceText(\' ', $smiley['code'], '\', document.forms.sbox.sboxText); return false;"><img src="', $settings['smileys_url'], '/', $smiley['filename'], '" align="bottom" alt="', $smiley['description'], '" title="', $smiley['description'], '" /></a>';

			// If this isn't the last row, show a break.
			if (empty($smiley_row['last']))
				echo '<br />';
		}

		// If the smileys popup is to be shown... show it!
		if (!empty($context['smileys']['popup']))
			echo '
					<a href="javascript:sbox_moreSmileys();">[', $txt['more_smileys'], ']</a>';
	}

	// If there are additional smileys then ensure we provide the javascript for them.
	if (!empty($context['smileys']['popup']))
	{
		echo '
			<script language="JavaScript" type="text/javascript"><!-- // --><![CDATA[
				var smileys = [';

		foreach ($context['smileys']['popup'] as $smiley_row)
		{
			echo '
					[';
			foreach ($smiley_row['smileys'] as $smiley)
			{
				echo '
						["', $smiley['code'], '","', $smiley['filename'], '","', $smiley['js_description'], '"]';
				if (empty($smiley['last']))
					echo ',';
			}

			echo ']';
			if (empty($smiley_row['last']))
				echo ',';
		}

		echo '];
				var smileyPopupWindow;

				function sbox_moreSmileys()
				{
					var row, i;

					if (smileyPopupWindow)
						smileyPopupWindow.close();

					smileyPopupWindow = window.open("", "add_smileys", "toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,width=480,height=220,resizable=yes");
					smileyPopupWindow.document.write(\'<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">\n<html>\');
					smileyPopupWindow.document.write(\'\n\t<head>\n\t\t<title>', $txt['more_smileys_title'], '</title>\n\t\t<link rel="stylesheet" type="text/css" href="', $settings['theme_url'], '/style.css" />\n\t</head>\');
					smileyPopupWindow.document.write(\'\n\t<body style="margin: 1ex;">\n\t\t<table width="100%" cellpadding="5" cellspacing="0" border="0" class="tborder">\n\t\t\t<tr class="titlebg"><td align="left">', $txt['more_smileys_pick'], '</td></tr>\n\t\t\t<tr class="windowbg"><td align="left">\');

					for (row = 0; row < smileys.length; row++)
					{
						for (i = 0; i < smileys[row].length; i++)
						{
							smileys[row][i][2] = smileys[row][i][2].replace(/"/g, \'&quot;\');
							smileyPopupWindow.document.write(\'<a href="javascript:void(0);" onclick="window.opener.replaceText(&quot; \' + smileys[row][i][0] + \'&quot;, window.opener.document.forms.sbox.sboxText); window.focus(); return false;"><img src="', $settings['smileys_url'], '/\' + smileys[row][i][1] + \'" alt="\' + smileys[row][i][2] + \'" title="\' + smileys[row][i][2] + \'" style="padding: 4px;" border="0" /></a> \');
						}
						smileyPopupWindow.document.write("<br />");
					}

					smileyPopupWindow.document.write(\'</td></tr>\n\t\t\t<tr><td align="center" class="windowbg"><a href="javascript:window.close();\\">', $txt['more_smileys_close_window'], '</a></td></tr>\n\t\t</table>\n\t</body>\n</html>\');
					smileyPopupWindow.document.close();
				}
			// ]]></script>';
	}
}
// END: Borrowed from template_postbox(&$message) in Post.template.php

?>
