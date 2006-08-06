<?php
header('Pragma: no-cache');
header('Expires: 0');
header('Cache-control: none');

require("../SSI.php");

if (!defined('SMF'))
  die('Hacking attempt...');

// global variables (they are always global since we're here in the main routine)
// global $db_connection, $context, $settings, $txt, $user_info, $modSettings, $db_prefix, $boarddir, $boardurl;

$sbox_HistoryFile = $boarddir . '/sbox.history.html';

// BEGIN: BORROWED FROM http://de2.php.net/manual/en/function.flock.php
/*
 * I hope this is usefull. 
 * If mkdir() is atomic, 
 * then we do not need to worry about race conditions while trying to make the lockDir,
 * unless of course were writing to NFS, for which this function will be useless.
 * so thats why i pulled out the usleep(rand()) peice from the last version
 *
 * Again, its important to tailor some of the parameters to ones indivdual usage
 * I set the default $timeLimit to 3/10th's of a second (maximum time allowed to achieve a lock), 
 * but if your writing some extrememly large files, and/or your server is very slow, you may need to increase it.
 * Obviously, the $staleAge of the lock directory will be important to consider as well if the writing operations might take  a while.
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


//display html header
echo '<html xmlns="http://www.w3.org/1999/xhtml"' . ($context['right_to_left']?' dir="rtl"':'') . '>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=', $context['character_set'], '" />
  <meta name="description" content="Shoutbox" />
  <meta name="keywords" content="Shoutbox" />
  <title>Shoutbox</title>
  <meta http-equiv="refresh" content="' . $modSettings['sbox_RefreshTime'] . ';URL=sboxDB.php?ts=' . time() . '">
  <link rel="stylesheet" type="text/css" href="' . $settings['theme_url'] . '/style.css?rc2" />
  <script language="JavaScript" type="text/javascript"><!-- // --><![CDATA[
    function killYesNo() {
      return confirm("' . $txt['sbox_KillShout'] . '");
    }

    function clearYesNo() {
      return confirm("' . $txt['quickmod_confirm'] . '");
    }

    // get SMF-time including time zone corrections (system+user)
    if (parent && parent.document.sbox.ts) {
      parent.document.sbox.ts.value = ' . forum_time(true) . ';
    }
    // if (parent.document.sbox.ts.value != ' . forum_time(true) . ') alert(\'Time mismatch! (\'+parent.document.sbox.ts.value+\' / ' . forum_time(true) . ')\');
    // ]]></script>

  <style type="text/css">
    .OddLine, A.OddLine {
      font-family: ' . $modSettings['sbox_FontFamily1'] . ';
      font-style: normal;
      font-size: ' . $modSettings['sbox_TextSize1'] . ';
      font-weight: normal;
      color: ' . $modSettings['sbox_TextColor1'] . ';
    } 
    .EvenLine, A.EvenLine {
      font-family: ' . $modSettings['sbox_FontFamily2'] . ';
      font-style: normal;
      font-size: ' . $modSettings['sbox_TextSize2'] . ';
      font-weight: normal;
      color: ' . $modSettings['sbox_TextColor2'] . ';
    }
    
    body {
      padding: 0px 0px 0px 0px;
      background-color: ' . $modSettings['sbox_BackgroundColor'] . ';
    }
    A {
      text-decoration: none;
    }
    A.Kill {
      color: #ff0000;
    }
  </style>';


switch ($_REQUEST['action']) {
 
  case 'write':
    if  (((!$context['user']['is_guest']) || ($modSettings['sbox_GuestAllowed'] == '1')) && !empty($_REQUEST['sboxText'])) {
      $content=$_REQUEST['sboxText'];
      // get current timestamp
      $date = time();
    
      // handle special characters
      $content = addslashes($content);
    
      // insert shout message into database
      $sql = "INSERT INTO " . $db_prefix . "sbox_content (ID_MEMBER, content, time) VALUES ('" . $context['user']['id'] . "', '" . $content . "', '$date')";
      db_query($sql, __FILE__, __LINE__);
    
      // delete old shout messages (get id of last shouting and delete all shoutings as defined in settings
      $result = db_query("SELECT id FROM " . $db_prefix . "sbox_content WHERE ID_MEMBER='" . $context['user']['id'] . "' AND content='" . $content . "' AND time='$date'", __FILE__, __LINE__);
      $rows = mysql_fetch_assoc($result) ;
      $sql = 'DELETE FROM ' . $db_prefix . "sbox_content WHERE id < '" . ($rows["id"]-$modSettings['sbox_MaxLines']) . "'";
      db_query($sql, __FILE__, __LINE__);
      
      // write into history if needed
      if ($modSettings['sbox_DoHistory'] == '1') {
        $ds = date('Y-m-d', $date) . '&nbsp;|&nbsp;' . date('H:i.s', $date);
        
        $content = stripslashes($content); // shouting content
        $content = htmlentities($content);
        if ($modSettings['sbox_AllowBBC'] == '1') {
          $content = parse_bbc($content);
        }
        
        $output = '[&nbsp;' . $ds . '&nbsp;]&nbsp;<b>&lt;<a href="' . $scripturl . '?action=profile;u=' . $context['user']['id'] . '" target="_blank" class="' . $divclass . '">' . ((!empty($context['user']['name']))?$context['user']['name']:$context['user']['username']) . '</a>&gt;</b>&nbsp;' . $content . '</div><br />' . "\n";
        
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
        // TODO: Check for existing lock, wait for lock to be released and delete then.
        @unlink($sbox_HistoryFile);
      }
    }
    break;

  case 'kill':
    if  ($context['user']['is_admin'] && !empty($_REQUEST['kill'])) {
      $sql = 'DELETE FROM ' . $db_prefix . 'sbox_content WHERE id=' . intval($_REQUEST['kill']);
      db_query($sql, __FILE__, __LINE__);
    }
    break;
}

// close header and open body
echo '
</head>
<body>';

echo "\n" . '<div class="OddLine"><b>[ ' . strftime($user_info['time_format'], forum_time(true)) . ' ]</b></div>';

if ($context['user']['is_admin']) {
  echo "\n" . '<div class="OddLine">';
  if ($modSettings['sbox_DoHistory'] == '1') {
    if (file_exists($sbox_HistoryFile)) {
      echo '[<a href="' . str_replace($boarddir, $boardurl, $sbox_HistoryFile) . '" target="_blank">' . $txt['sbox_History'] . '</a>]';
      echo ' [<a href="' . $_SERVER['PHP_SELF'] . '?action=clearhist" class="Kill" onClick="return clearYesNo();">' . $txt['sbox_HistoryClear'] . '</a>]';
    } else {
      echo '[' . $txt['sbox_HistoryNotFound'] . ']';
    }
  }
  // debug output for separator-bar
//  echo ' ( CurTime: ' . forum_time(true) . ' / LastTime: ' . $_REQUEST['ts'] . ' )';
  echo '</div>';
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
    $content = htmlentities($content);
    if ($modSettings['sbox_AllowBBC'] == '1') {
      $content = parse_bbc($content);
    }

    if (!empty($_REQUEST['ts']) && !$div && $date<$_REQUEST['ts']) {
      if ($count > 0) {
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
      $divclass = 'OddLine';
    } else {
      $divclass = 'EvenLine';
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
    
    if ($context['user']['is_admin']) {
      echo '[<a title="' . $txt['sbox_KillShout'] . '" class="Kill" onClick="return killYesNo();" href="' . $_SERVER['PHP_SELF'] . '?action=kill&kill=' . $row['id'] . '">X</a>]';
    }
    
    $wd = $txt['days_short'][date('w', $date)];
    $ts = date('H:i', $date);
    $ds = $wd . '&nbsp;|&nbsp;' . $ts;
    
    // highlight username, realname and make sound
    if (!empty($context['user']['name']) && strpos($content, $context['user']['name']) !== false) {
      if ($div === false) $alert = true;
      $content = str_replace($context['user']['name'], '<b><u>' . $context['user']['name'] . '</u></b>', $content);
    }
    if (!empty($user_info['username']) && $user_info['username'] != $context['user']['name'] && strpos($content, $user_info['username']) !== false) {
      if ($div === false) $alert = true;
      $content = str_replace($user_info['username'], '<b><u>' . $user_info['username'] . '</u></b>', $content);
    }
    
    echo '[&nbsp;' . $ds . '&nbsp;]&nbsp;<b>&lt;<a href="' . $scripturl . '?action=profile;u=' . $name . '" target="_top" class="' . $divclass . '">' . ((!empty($row['realName']))?$row['realName']:$row['memberName']) . '</a>&gt;</b>&nbsp;' . $content . '</div>';
  }
  if ($alert === true && $div === true) {
    echo '<embed src="' . $boardurl . '/chat-inbound_GSM.wav" hidden="true" autostart="true" loop="false"></embed>' . "\n";
  }
}

?>
</body>
</html>
