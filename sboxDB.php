<?
require("../SSI.php");

if (!defined('SMF'))
	die('Hacking attempt...');

// global variables
global $db_connection, $context, $settings, $txt, $user_info, $modSettings, $db_prefix;

// used in test scenario
//@mysql_select_db($db_name, $db_connection);

//display html header
echo '<html xmlns="http://www.w3.org/1999/xhtml"', $context['right_to_left'] ? ' dir="rtl"' : '', '>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=', $context['character_set'], '" />
	<meta name="description" content="Shoutbox" />
	<meta name="keywords" content="Shoutbox" />
	<title>Shoutbox</title>
	<meta http-equiv="refresh" content="'.$modSettings['sbox_RefreshTime'].';URL=sboxDB.php">
	<link rel="stylesheet" type="text/css" href="', $settings['theme_url'], '/style.css?rc2" />
	<script language="JavaScript" type="text/javascript"><!-- // --><![CDATA[
		function killYesNo()
		{
			return confirm("'.$txt['sbox_KillShout'].'");
			
		}
	// ]]></script>

	<style type="text/css"><!-- // --><![CDATA[
	<!--
		.Kill
		{
			color: #ff0000;
		}
		.OddLine
		{
 			font-family: '.$modSettings['sbox_FontFamily1'].';
			font-style: normal;
 			font-size: '.$modSettings['sbox_TextSize1'].';
			font-weight: normal;
			color: '.$modSettings['sbox_TextColor1'].';
		} 
		.EvenLine
		{
 			font-family: '.$modSettings['sbox_FontFamily2'].';
			font-style: normal;
 			font-size: '.$modSettings['sbox_TextSize2'].';
			font-weight: normal;
			color: '.$modSettings['sbox_TextColor2'].';
		} 
		body
		{
			padding: 0px 0px 0px 0px;
			background-color: '.$modSettings['sbox_BackgroundColor'].';
		}
		a:link
		{
			color: #ff0000;
			text-decoration: none;
		}
		//-->
	// ]]></style>';


switch ($_REQUEST['action'])
{
 
 	case "write":
 		if  ((!$context['user']['is_guest']) || ($modSettings['sbox_GuestAllowed'] == "1"))
		{
			// empty messages are not allowed
			$content=$_REQUEST['sboxText'];
			if(chop($content."") != "")
			{
				// get actual weekday
				$days = array($txt['sbox_Sunday'],$txt['sbox_Monday'],$txt['sbox_Tuesday'],$txt['sbox_Wednesday'],$txt['sbox_Thurday'],$txt['sbox_Friday'],$txt['sbox_Saturday']);
				$day=$days[date("w")];			// weekday
				$date=$day." | ". date("G:i");	// time
			
				// handle spacial characters
				$content=addslashes($content);
			
				// insert shout message into database
				$sql = "insert into ".$db_prefix."sbox_content (name,content,time) values ('".$user_info['username']."','".$content."','$date')";
				db_query($sql,__FILE__,__LINE__);
			
				// delete old shout messages (get id of last shouting and delete all shoutings as defined in settings
				$result = db_query("select id from ".$db_prefix."sbox_content where name='".$user_info['username']."' and content='".$content."' and time='$date'",__FILE__,__LINE__);
				$rows = mysql_fetch_assoc($result) ;
				$sql = "delete from ".$db_prefix."sbox_content where id < '".($rows["id"]-$modSettings['sbox_MaxLines'])."'";
				db_query($sql,__FILE__,__LINE__);
			}
		}
		break;
 	case "kill":
 		if  ($context['user']['is_admin'])
 		{
 			$id = "".$_REQUEST['kill'];
 			if ($id != "")
 			{
				$sql = "delete from ".$db_prefix."sbox_content where id=".$id."";
				db_query($sql,__FILE__,__LINE__);
			}
 		}
 		break;
}

// close header and open body
echo '
</head>
<body>';

// get smilie path
$themedir = $settings['default_theme_url'];	// smf theme path
$imgdir = $themedir."/images/";				// smilie path

// get shout messages out of database
$result = db_query("select * from ".$db_prefix."sbox_content order by id desc, time asc limit ".$modSettings['sbox_MaxLines'],__FILE__,__LINE__);
if(mysql_num_rows($result))
{
	$count=0;	// counter to distinguish font color
	while($row = mysql_fetch_assoc($result))
	{
		$count = $count + 1;						// increase counter
		$name = $row["name"];						// user name
		$date = $row["time"];						// shouting date and time
		$content = stripslashes($row['content']);	// shouting content
		
		// replace smilie code with path to smilie image
		$content = str_replace ($txt['sbox_smilie01_code'], '<img src="'.$imgdir.$txt['sbox_smilie01_file'].'" alt="'.$txt['sbox_smilie01_text'].'" title="'.$txt['sbox_smilie01_text'].'" border="0" />', $content);
		$content = str_replace ($txt['sbox_smilie02_code'], '<img src="'.$imgdir.$txt['sbox_smilie02_file'].'" alt="'.$txt['sbox_smilie02_text'].'" title="'.$txt['sbox_smilie02_text'].'" border="0" />', $content);
		$content = str_replace ($txt['sbox_smilie03_code'], '<img src="'.$imgdir.$txt['sbox_smilie03_file'].'" alt="'.$txt['sbox_smilie03_text'].'" title="'.$txt['sbox_smilie03_text'].'" border="0" />', $content);
		$content = str_replace ($txt['sbox_smilie04_code'], '<img src="'.$imgdir.$txt['sbox_smilie04_file'].'" alt="'.$txt['sbox_smilie04_text'].'" title="'.$txt['sbox_smilie04_text'].'" border="0" />', $content);
		$content = str_replace ($txt['sbox_smilie05_code'], '<img src="'.$imgdir.$txt['sbox_smilie05_file'].'" alt="'.$txt['sbox_smilie05_text'].'" title="'.$txt['sbox_smilie05_text'].'" border="0" />', $content);
		$content = str_replace ($txt['sbox_smilie06_code'], '<img src="'.$imgdir.$txt['sbox_smilie06_file'].'" alt="'.$txt['sbox_smilie06_text'].'" title="'.$txt['sbox_smilie06_text'].'" border="0" />', $content);
		$content = str_replace ($txt['sbox_smilie07_code'], '<img src="'.$imgdir.$txt['sbox_smilie07_file'].'" alt="'.$txt['sbox_smilie07_text'].'" title="'.$txt['sbox_smilie07_text'].'" border="0" />', $content);
		$content = str_replace ($txt['sbox_smilie08_code'], '<img src="'.$imgdir.$txt['sbox_smilie08_file'].'" alt="'.$txt['sbox_smilie08_text'].'" title="'.$txt['sbox_smilie08_text'].'" border="0" />', $content);
		$content = str_replace ($txt['sbox_smilie09_code'], '<img src="'.$imgdir.$txt['sbox_smilie09_file'].'" alt="'.$txt['sbox_smilie09_text'].'" title="'.$txt['sbox_smilie09_text'].'" border="0" />', $content);
		$content = str_replace ($txt['sbox_smilie10_code'], '<img src="'.$imgdir.$txt['sbox_smilie10_file'].'" alt="'.$txt['sbox_smilie10_text'].'" title="'.$txt['sbox_smilie10_text'].'" border="0" />', $content);
		$content = str_replace ($txt['sbox_smilie11_code'], '<img src="'.$imgdir.$txt['sbox_smilie11_file'].'" alt="'.$txt['sbox_smilie11_text'].'" title="'.$txt['sbox_smilie11_text'].'" border="0" />', $content);
		$content = str_replace ($txt['sbox_smilie12_code'], '<img src="'.$imgdir.$txt['sbox_smilie12_file'].'" alt="'.$txt['sbox_smilie12_text'].'" title="'.$txt['sbox_smilie12_text'].'" border="0" />', $content);
		$content = str_replace ($txt['sbox_smilie13_code'], '<img src="'.$imgdir.$txt['sbox_smilie13_file'].'" alt="'.$txt['sbox_smilie13_text'].'" title="'.$txt['sbox_smilie13_text'].'" border="0" />', $content);
		$content = str_replace ($txt['sbox_smilie14_code'], '<img src="'.$imgdir.$txt['sbox_smilie14_file'].'" alt="'.$txt['sbox_smilie14_text'].'" title="'.$txt['sbox_smilie14_text'].'" border="0" />', $content);
		$content = str_replace ($txt['sbox_smilie15_code'], '<img src="'.$imgdir.$txt['sbox_smilie15_file'].'" alt="'.$txt['sbox_smilie15_text'].'" title="'.$txt['sbox_smilie15_text'].'" border="0" />', $content);

		// display shouting message and use a different color each second row
		if ($count % 2)
		echo '
	<div class="OddLine">';
		else
		echo '
	<div class="EvenLine">';
		if ($context['user']['is_admin'])
			echo '<a title="'.$txt['sbox_KillShout'].'" class="Kill" onclick="return killYesNo();" href="sboxDB.php?action=kill&kill='.$row['id'].'">[X]</a>';

		echo '[&nbsp;'.$date.'&nbsp;]&nbsp;<b>&lt;'.$name.'&gt;</b>&nbsp;'.$content.'</div>';
	}
	
    echo '
</body>
</html>';
}
?>
                                                                                                                                                                                                                     