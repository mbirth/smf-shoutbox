<?php
header('Pragma: no-cache');
header('Expires: 0');
header('Cache-control: none');

require("../SSI.php");

if (!defined('SMF'))
  die('Hacking attempt...');

loadLanguage('sbox');

/***[ BEGIN CONFIGURATION ]***************************************************/

$sbox_HistoryFile = $boarddir . '/sbox.history.html';

$sbox_NickPrefix = '&lt;';       // this won't be linked to the profile page
$sbox_NickInnerPrefix = '<b>';   // this will be linked to the profile page, use formatting tags (<B>) here
$sbox_NickInnerSuffix = '</b>';  // so that they are applied inside the <A>, otherwise they won't work
$sbox_NickSuffix = '&gt;';

$sbox_DatePrefix = '[';
$sbox_DateSeparator = '&nbsp;';    // separates weekday from time
$sbox_DateSuffix = ']';

/***[ END CONFIGURATION ]*****************************************************/

// BEGIN: BORROWED FROM http://de2.php.net/manual/en/function.flock.php
/*
 * I hope this is usefull. 
 * If mkdir() is atomic, 
 * then we do not need to worry about race conditions while trying to make the lockDir,
 * unless of course we're writing to NFS, for which this function will be useless.
 * so thats why i pulled out the usleep(rand()) piece from the last version
 *
 * Again, its important to tailor some of the parameters to ones indivdual usage
 * I set the default $timeLimit to 3/10th's of a second (maximum time allowed to achieve a lock), 
 * but if you're writing some extrememly large files, and/or your server is very slow, you may need to increase it.
 * Obviously, the $staleAge of the lock directory will be important to consider as well if the writing operations might take a while.
 * My defaults are extrememly general and you're encouraged to set your own
 *
 * $timeLimit is in microseconds
 * $staleAge is in seconds
 */

function microtime_float() {
   list($usec, $sec) = explode(' ', microtime());
   return ((float)$usec + (float)$sec);
}

function locked_filewrite($filename, $data, $timeLimit = 300000, $staleAge = 5) {
   ignore_user_abort(1);
   $lockDir = $filename . '.lock';

   if (is_dir($lockDir)) {
     if ((time() - filemtime($lockDir)) > $staleAge) {
       rmdir($lockDir);
     }
   }

   $locked = @mkdir($lockDir);

   if ($locked === false) {
     $timeStart = microtime_float();
     do {
       if ((microtime_float() - $timeStart) > $timeLimit) break;
       $locked = @mkdir($lockDir);
     } while ($locked === false);
   }

   $success = false;

   if ($locked === true) {
     $fp = @fopen($filename, 'at');
     if (@fwrite($fp, $data)) $success = true;
     @fclose($fp);
     rmdir($lockDir);
   }

   ignore_user_abort(0);
   return $success;
}
// END: BORROWED FROM http://de2.php.net/manual/en/function.flock.php

function missinghtmlentities($text) {
  global $context;
  // entitify missing characters, ignore entities already there (Unicode / UTF8) (hopefully in &#123;-notation)
  $split = preg_split('/(&#[\d]+;)/', $text, -1, PREG_SPLIT_DELIM_CAPTURE);
  $result = '';
  foreach ($split as $s) {
    if (substr($s, 0, 2) != '&#' || substr($s, -1, 1) != ';') {
      // filter out "ANSI_X3.4-1968" charset, which just means plain old ASCII ... replace by UTF-8
      if (strpos($context['character_set'], 'ANSI_') !== false) $charset = 'UTF-8'; else $charset = $context['character_set'];
      $result .= @htmlentities($s, ENT_NOQUOTES, $charset);
    } else {
      $result .= $s;
    }
  }
  return $result;
}

//display html header
echo '<html xmlns="http://www.w3.org/1999/xhtml"' . ($context['right_to_left']?' dir="rtl"':'') . '>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=', $context['character_set'], '" />';
  
$result = db_query("SELECT time FROM {$db_prefix}sbox_content ORDER BY time DESC LIMIT 1", __FILE__, __LINE__);
$row = mysql_fetch_assoc($result);
$refreshBlocked = false;
$delta = time() - $row['time'];
if ((!empty($_REQUEST['action'])) && ($_REQUEST['action'] == 'write')) $dontblock = true; else $dontblock = false;
if (($delta > $modSettings['lastActive']*60) && ($modSettings['sbox_BlockRefresh'] == '1') && (!$dontblock)) {
  $refreshBlocked = true;
} else {
  echo '
  <meta http-equiv="refresh" content="' . $modSettings['sbox_RefreshTime'] . ';URL=sboxDB.php?ts=' . time() . '">';
}

$sbox_CurTheme = strtolower(substr($settings['theme_url'], strrpos($settings['theme_url'], '/')+1));
$sbox_DarkThemes = explode('|', strtolower($modSettings['sbox_DarkThemes']));
if (in_array($sbox_CurTheme, $sbox_DarkThemes)) {
  $sbox_TextColor2 = $modSettings['sbox_TextColor2'];
} else {
  $sbox_TextColor2 = $modSettings['sbox_TextColor1'];
}

echo '
  <link rel="stylesheet" type="text/css" href="' . $settings['theme_url'] . '/style.css?rc2" />
  <script language="JavaScript" type="text/javascript"><!-- // --><![CDATA[
    function kill() { return confirm("' . $txt['sbox_KillShout'] . '"); }
    function clearHist() { return confirm("' . $txt['quickmod_confirm'] . '"); }

    // get SMF-time including time zone corrections (system+user)
    if (parent && parent.document.sbox.ts) {
      parent.document.sbox.ts.value = ' . forum_time(true) . ';
    }
    // ]]></script>
  <style type="text/css">
  
    .windowbg2 {
      font-family: ' . $modSettings['sbox_FontFamily'] . ';
      font-style: normal;
      font-size: ' . $modSettings['sbox_TextSize'] . ';
      font-weight: normal;
      text-decoration: none;
    }

    .Even {
      color: ' . $sbox_TextColor2 . ';
      font-weight: normal;
      text-decoration: none;
    }
    
    body {
      width: 100%;
      padding: 0;
      margin: 0;
      border: 0;
    }
 
    .Kill, A.Kill {
      color: #ff0000;
    }
  </style>';


if (!empty($_REQUEST['action'])) switch ($_REQUEST['action']) {
 
  case 'write':
    if  (((!$context['user']['is_guest']) || ($modSettings['sbox_GuestAllowed'] == '1')) && !empty($_REQUEST['sboxText'])) {
      is_not_banned(true);  // die with message, if user is banned, let him read everything though
      $content = $_REQUEST['sboxText'];
      // get current timestamp
      $date = time();
    
      $posterip = $user_info['ip'];
      $pip = explode('.', $posterip);
      $piph = sprintf("%02s%02s%02s%02s", dechex($pip[0]), dechex($pip[1]), dechex($pip[2]), dechex($pip[3]));
    
      // handle special characters
      $content = addslashes($piph . $content);
    
      // insert shout message into database
      $sql = "INSERT INTO " . $db_prefix . "sbox_content (ID_MEMBER, content, time) VALUES ('" . $context['user']['id'] . "', '" . $content . "', '$date')";
      db_query($sql, __FILE__, __LINE__);
    
      // delete old shout messages (get id of last shouting and delete all shoutings as defined in settings
      $result = db_query("SELECT id FROM " . $db_prefix . "sbox_content WHERE ID_MEMBER='" . $context['user']['id'] . "' AND content='" . $content . "' AND time='$date'", __FILE__, __LINE__);
      $rows = mysql_fetch_assoc($result);
      $sql = 'DELETE FROM ' . $db_prefix . "sbox_content WHERE id < '" . ($rows["id"]-$modSettings['sbox_MaxLines']) . "'";
      db_query($sql, __FILE__, __LINE__);
      
      // write into history if needed
      if ($modSettings['sbox_DoHistory'] == '1') {
        $ds = $sbox_DatePrefix . date('Y-m-d', $date) . $sbox_DateSeparator . date('H:i.s', $date) . $sbox_DateSuffix;
        
        $content = stripslashes($content); // shouting content
        $content = substr($content, 8);
        $content = missinghtmlentities($content);
        if ($modSettings['sbox_AllowBBC'] == '1' && ($context['user']['id'] > 0 || $modSettings['sbox_GuestBBC'] == '1')) {
          $content = parse_bbc($content);
        }
        
        $output = $ds . '&nbsp;' . $sbox_NickPrefix;
        if ($context['user']['id'] > 0) {
          $output .= '<a href="' . $scripturl . '?action=profile;u=' . $context['user']['id'] . '" target="_blank" class="' . $divclass . '">';
          $output .= $sbox_NickInnerPrefix . ((!empty($context['user']['name']))?$context['user']['name']:$context['user']['username']) . $sbox_NickInnerSuffix;
          $output .= '</a>';
        } else {
          $output .= $sbox_NickInnerPrefix . 'Guest-' . base_convert($piph, 16, 36) . $sbox_NickInnerSuffix;
        }
        $output .= $sbox_NickSuffix . '&nbsp;' . $content . '</div><br />' . "\n";
        
        if (!file_exists($sbox_HistoryFile)) {
          // TODO: Prepare file ... HTML-header, stylesheet, etc.
        }
        
        locked_filewrite($sbox_HistoryFile, $output);
      }
    }
    break;
   
  case 'clearhist':
    if ($context['user']['is_admin']) {
      if (file_exists($sbox_HistoryFile)) {
        $lockDir = $sbox_HistoryFile . '.lock';
        $start = time();
        while ((is_dir($lockDir)) && ((time() - $start) < 5)) {
          usleep(100000);  // sleep 1/10th of a second (for a PC these are ages!)
        }
        if (!is_dir($lockDir)) @unlink($sbox_HistoryFile);
      }
    }
    break;

  case 'kill':
    if  (!empty($_REQUEST['kill']) && ($context['user']['is_admin'] || ($modSettings['sbox_ModsRule'] && count(boardsAllowedTo('moderate_board'))>0))) {
      $sql = 'DELETE FROM ' . $db_prefix . 'sbox_content WHERE id=' . intval($_REQUEST['kill']);
      db_query($sql, __FILE__, __LINE__);
    }
    break;
    
}

// close header and open body
echo '
</head>
<body class="windowbg2"><div class="windowbg2">';

echo "\n" . '<b>' . $sbox_DatePrefix . strftime($user_info['time_format'], forum_time(true)) . $sbox_DateSuffix;
if ($refreshBlocked) {
  echo ' ' . $txt['sbox_RefreshBlocked'];
}
echo '</b><br />';

if ($context['user']['is_admin']) {
  if ($modSettings['sbox_DoHistory'] == '1') {
    echo "\n";
    if (file_exists($sbox_HistoryFile)) {
      echo '[<a href="' . str_replace($boarddir, $boardurl, $sbox_HistoryFile) . '" target="_blank">' . $txt['sbox_History'] . '</a>]';
      echo ' [<a href="' . $_SERVER['PHP_SELF'] . '?action=clearhist" class="Kill" onClick="return clearHist();">' . $txt['sbox_HistoryClear'] . '</a>]';
    } else {
      echo '[' . $txt['sbox_HistoryNotFound'] . ']';
    }
    echo '';
  }
}

/*
if (!empty($settings['display_who_viewing'])) {
  echo '<small>';
  if ($settings['display_who_viewing'] == 1)
    echo count($context['view_members']), ' ', count($context['view_members']) == 1 ? $txt['who_member'] : $txt[19];
  else
    echo empty($context['view_members_list']) ? '0 ' . $txt[19] : implode(', ', $context['view_members_list']) . ((empty($context['view_num_hidden']) or $context['can_moderate_forum']) ? '' : ' (+ ' . $context['view_num_hidden'] . ' ' . $txt['hidden'] . ')');
  echo $txt['who_and'], $context['view_num_guests'], ' ', $context['view_num_guests'] == 1 ? $txt['guest'] : $txt['guests'], $txt['who_viewing_board'], '</small>';
}
*/

// get shout messages out of database
$result = db_query("
  SELECT *
  FROM {$db_prefix}sbox_content AS sb 
    LEFT JOIN {$db_prefix}members AS mem ON (mem.ID_MEMBER = sb.ID_MEMBER)
  ORDER BY id DESC, time ASC LIMIT " . $modSettings['sbox_MaxLines'], __FILE__, __LINE__);
if(mysql_num_rows($result)) {
  $lname = '';
  $count = 0;
  $div = false;
  $alert = false;
  while($row = mysql_fetch_assoc($result)) {
    $name = $row['ID_MEMBER'];           // user name
    $date = forum_time(true, $row['time']);           // shouting date and time
    $content = stripslashes($row['content']); // shouting content
    $piph = substr($content, 0, 8);
    $content = substr($content, 8);
    censorText($content);
    $content = missinghtmlentities($content);
    if ($modSettings['sbox_AllowBBC'] == '1' && ($name > 0 || $modSettings['sbox_GuestBBC'] == '1')) {
      $content = parse_bbc($content);
    }

    if (!empty($_REQUEST['ts']) && !$div && $date<$_REQUEST['ts']) {
      if ($count > 0 && $modSettings['sbox_NewShoutsBar'] == '1') {
        echo '<hr>' . "\n";
      }
      $div = true;
    }
    
    if ($name != $lname) {
      $count++;           // increase counter
    }
    $lname = $name;

    // display shouting message and use a different color each second row
    if ($count % 2 == 0) {
      $divclass = 'windowbg2';
    } else {
      $divclass = 'Even';
    }

/*    $r = $g = $b = 0;
    for ($i=0;$i<strlen($name);$i++) {
      $x = ord(substr($name, $i, 1));
      switch ($i % 3) {
        case 0: $r += $x; break;
        case 1: $g += $x; break;
        case 2: $b += $x; break;
      }
    }
    $r = dechex($r % 192);
    $g = dechex($g % 192);
    $b = dechex($b % 192);
    if (strlen($r)<2) $r = '0' . $r;
    if (strlen($g)<2) $g = '0' . $g;
    if (strlen($b)<2) $b = '0' . $b;
    $colh = $r . $g . $b;

    echo "\n" . '<div class="' . $divclass . '" style="color: #' . $colh . '">'; */
    echo "\n" . '<div class="' . $divclass . '">';
    
    if ($context['user']['is_admin'] || ($modSettings['sbox_ModsRule'] && count(boardsAllowedTo('moderate_board'))>0)) {
      echo '[<a title="' . $txt['sbox_KillShout'] . '" class="Kill" onClick="return kill();" href="' . $_SERVER['PHP_SELF'] . '?action=kill&kill=' . $row['id'] . '">X</a>]';
    }
    
    $wd = $txt['days_short'][date('w', $date)];
    $ts = date('H:i', $date);
    $ds = $sbox_DatePrefix . $wd . $sbox_DateSeparator . $ts . $sbox_DateSuffix;
    
    // highlight username, realname and make sound
    if (!empty($context['user']['name']) && strpos($content, $context['user']['name']) !== false) {
      if ($div === false) $alert = true;
      $content = str_replace($context['user']['name'], '<b><u>' . $context['user']['name'] . '</u></b>', $content);
    }
    if (!empty($user_info['username']) && $user_info['username'] != $context['user']['name'] && strpos($content, $user_info['username']) !== false) {
      if ($div === false) $alert = true;
      $content = str_replace($user_info['username'], '<b><u>' . $user_info['username'] . '</u></b>', $content);
    }
    
    echo $ds . '&nbsp;' . $sbox_NickPrefix;
    if ($name > 0) {
      if ($modSettings['sbox_UserLinksVisible'] == '1') echo '<a href="' . $scripturl . '?action=profile;u=' . $name . '" target="_top" style="text-decoration: none;"><span class="' . $divclass . '">';
      echo $sbox_NickInnerPrefix . ((!empty($row['realName']))?$row['realName']:$row['memberName']) . $sbox_NickInnerSuffix;
      if ($modSettings['sbox_UserLinksVisible'] == '1') echo '</span></a>';
    } else {
      echo $sbox_NickInnerPrefix . $txt['sbox_Guest'] . '-' . base_convert($piph, 16, 36) . $sbox_NickInnerSuffix;
    }
    echo $sbox_NickSuffix . '&nbsp;' . $content . '</div>';
  }
  if (($modSettings['sbox_EnableSounds']) && ($alert === true) && ($div === true)) {
    echo '<embed src="' . $boardurl . '/chat-inbound_GSM.wav" hidden="true" autostart="true" loop="false"></embed>' . "\n";
  }
}

?>
</div>
</body>
</html>
