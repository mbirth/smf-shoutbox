<?php

function template_shout_box()
{
	global $context, $settings, $options, $txt, $user_info, $scripturl, $modSettings, $forum_version, $sourcedir;
	
	$themedir = $settings['default_theme_url'];
	$imgdir = $themedir."/images/";

	echo '
	<div class="tborder"', $context['browser']['needs_size_fix'] && !$context['browser']['is_ie6'] ? ' style="width: 100%;"' : '', '>
		<div class="catbg" style="padding: 6px; vertical-align: middle; text-align: center;">		
			<a href="#" onclick="shrinkHeaderSB(!current_header_sb); return false;"><img id="upshrink_sb" src="', $settings['images_url'], '/', empty($options['collapse_header_sp']) ? 'collapse.gif' : 'expand.gif', '" alt="*" title="', $txt['upshrink_description'], '" style="margin-right: 2ex;" align="right" /></a>'.$txt['sbox_ModTitle'].'
		</div>
		<div id="upshrinkHeaderSB"', empty($options['collapse_header_sb']) ? '' : ' style="display: none;"', '>
			<table border="0" width="100%" cellspacing="1" cellpadding="4" class="bordercolor">
				<tr class="windowbg" align="right" style="width:13%">
					<td class="windowbg" style="width:87%">
						<form name="sbox" action="Sources/sboxDB.php?action=write" method="post" target="sboxframe" onsubmit="setTimeout(\'clearSbox()\',100)">
							<table width="100%" border="0" cellspacing="1" cellpadding="0">
								<tr>
									<td align="right">
     									<a href="Sources/sboxDB.php" target="sboxframe"><img src="'.$imgdir.'sbox_refresh.gif" border="0" width="16" height="17" align="middle" alt="Neu laden" /></a>';
	if ((!$context['user']['is_guest']) || ($modSettings['sbox_GuestAllowed'] == "1"))
	echo '
										<input class="windowbg2" type="text" name="sboxText" size="70" maxlength="100" />&nbsp;<input type="submit" class="input" value="&nbsp;shout&nbsp;" />';
	echo '
									</td>
								</tr>
								<tr>
									<td>
			     						<iframe name="sboxframe" src="Sources/sboxDB.php" width="100%" height="'.$modSettings['sbox_Height'].'"></iframe>
									</td>
								</tr>
							</table>
    					</form>
  					</td>';
  	if ($modSettings['sbox_SmiliesVisible'] == "1")		
	echo '
  					<td valign="top" class="windowbg2">
						<table cellpadding="2" cellspacing="0" border="1">
							<tr class="titlebg"><td align="center" colspan="3"><b>Smilies</b></td></tr>
					 		<tr class="headerbodies">
					 			<td align="center"><img src="'.$imgdir.$txt['sbox_smilie01_file'].'" alt="'.$txt['sbox_smilie01_text'].'" title="'.$txt['sbox_smilie01_text'].'" border="0" onclick="insertSmilie(\''.$txt['sbox_smilie01_code'].'\')" onmouseover="this.style.cursor=\'hand\';" /></td>
						 		<td align="center"><img src="'.$imgdir.$txt['sbox_smilie02_file'].'" alt="'.$txt['sbox_smilie02_text'].'" title="'.$txt['sbox_smilie02_text'].'" border="0" onclick="insertSmilie(\''.$txt['sbox_smilie02_code'].'\')" onmouseover="this.style.cursor=\'hand\';" /></td>
					 			<td align="center"><img src="'.$imgdir.$txt['sbox_smilie03_file'].'" alt="'.$txt['sbox_smilie03_text'].'" title="'.$txt['sbox_smilie03_text'].'" border="0" onclick="insertSmilie(\''.$txt['sbox_smilie03_code'].'\')" onmouseover="this.style.cursor=\'hand\';" /></td>
						 	</tr>
							<tr class="headerbodies">
								<td align="center"><img src="'.$imgdir.$txt['sbox_smilie04_file'].'" alt="'.$txt['sbox_smilie04_text'].'" title="'.$txt['sbox_smilie04_text'].'" border="0" onclick="insertSmilie(\''.$txt['sbox_smilie04_code'].'\')" onmouseover="this.style.cursor=\'hand\';" /></td>
								<td align="center"><img src="'.$imgdir.$txt['sbox_smilie05_file'].'" alt="'.$txt['sbox_smilie05_text'].'" title="'.$txt['sbox_smilie05_text'].'" border="0" onclick="insertSmilie(\''.$txt['sbox_smilie05_code'].'\')" onmouseover="this.style.cursor=\'hand\';" /></td>
								<td align="center"><img src="'.$imgdir.$txt['sbox_smilie06_file'].'" alt="'.$txt['sbox_smilie06_text'].'" title="'.$txt['sbox_smilie06_text'].'" border="0" onclick="insertSmilie(\''.$txt['sbox_smilie06_code'].'\')" onmouseover="this.style.cursor=\'hand\';" /></td>
							</tr>
							<tr class="headerbodies">
								<td align="center"><img src="'.$imgdir.$txt['sbox_smilie07_file'].'" alt="'.$txt['sbox_smilie07_text'].'" title="'.$txt['sbox_smilie07_text'].'" border="0" onclick="insertSmilie(\''.$txt['sbox_smilie07_code'].'\')" onmouseover="this.style.cursor=\'hand\';" /></td>
								<td align="center"><img src="'.$imgdir.$txt['sbox_smilie08_file'].'" alt="'.$txt['sbox_smilie08_text'].'" title="'.$txt['sbox_smilie08_text'].'" border="0" onclick="insertSmilie(\''.$txt['sbox_smilie08_code'].'\')" onmouseover="this.style.cursor=\'hand\';" /></td>
								<td align="center"><img src="'.$imgdir.$txt['sbox_smilie09_file'].'" alt="'.$txt['sbox_smilie09_text'].'" title="'.$txt['sbox_smilie09_text'].'" border="0" onclick="insertSmilie(\''.$txt['sbox_smilie09_code'].'\')" onmouseover="this.style.cursor=\'hand\';" /></td>
							</tr>
							<tr class="headerbodies">
								<td align="center"><img src="'.$imgdir.$txt['sbox_smilie10_file'].'" alt="'.$txt['sbox_smilie10_text'].'" title="'.$txt['sbox_smilie10_text'].'" border="0" onclick="insertSmilie(\''.$txt['sbox_smilie10_code'].'\')" onmouseover="this.style.cursor=\'hand\';" /></td>
								<td align="center"><img src="'.$imgdir.$txt['sbox_smilie11_file'].'" alt="'.$txt['sbox_smilie11_text'].'" title="'.$txt['sbox_smilie11_text'].'" border="0" onclick="insertSmilie(\''.$txt['sbox_smilie11_code'].'\')" onmouseover="this.style.cursor=\'hand\';" /></td>
								<td align="center"><img src="'.$imgdir.$txt['sbox_smilie12_file'].'" alt="'.$txt['sbox_smilie12_text'].'" title="'.$txt['sbox_smilie12_text'].'" border="0" onclick="insertSmilie(\''.$txt['sbox_smilie12_code'].'\')" onmouseover="this.style.cursor=\'hand\';" /></td>
							</tr>
							<tr class="headerbodies">
								<td align="center"><img src="'.$imgdir.$txt['sbox_smilie13_file'].'" alt="'.$txt['sbox_smilie13_text'].'" title="'.$txt['sbox_smilie13_text'].'" border="0" onclick="insertSmilie(\''.$txt['sbox_smilie13_code'].'\')" onmouseover="this.style.cursor=\'hand\';" /></td>
								<td align="center"><img src="'.$imgdir.$txt['sbox_smilie14_file'].'" alt="'.$txt['sbox_smilie14_text'].'" title="'.$txt['sbox_smilie14_text'].'" border="0" onclick="insertSmilie(\''.$txt['sbox_smilie14_code'].'\')" onmouseover="this.style.cursor=\'hand\';" /></td>
								<td align="center"><img src="'.$imgdir.$txt['sbox_smilie15_file'].'" alt="'.$txt['sbox_smilie15_text'].'" title="'.$txt['sbox_smilie15_text'].'" border="0" onclick="insertSmilie(\''.$txt['sbox_smilie15_code'].'\')" onmouseover="this.style.cursor=\'hand\';" /></td>
							</tr>
						</table>
					</td>';
					
	echo '
				</tr>
			</table>
		</div>
	</div>';
}
?>