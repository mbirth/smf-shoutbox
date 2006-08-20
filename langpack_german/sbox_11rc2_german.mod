<id>
SMF Shoutbox , German Language Pack
</id>

<version>
1.11
</version>

<mod info>
This is the german language pack for SMF shoutbox 1.10.

Instructions:
1. Install SMF shoutbox
2. Install SMF shoutbox german language pack

Author:
The SMF shoutbox language pack was originally written by Deep, some code ist "stolen" from Matthew Wolf (a.k.a Grudge).
Thanks a lot, Grudge!
Current development is done by Markus Birth

Please direct any questions regarding this version by posting
in the appropriate place at www.simplemachines.org (the preferred option!)
</mod info>

<author>
Deep and Markus Birth
</author>

<homepage>
http://mods.simplemachines.org/index.php?mod=412
</homepage>



<edit file>
$languagedir/Modifications.german.php
</edit file>

<search for>
?>
</search for>

<add before>
//SMF Shoutbox
$txt['sbox_ModTitle'] = 'SMF Shoutbox';
$txt['sbox_Visible'] = 'Shoutbox ist sichtbar';
$txt['sbox_GuestAllowed'] = 'G&auml;ste d&uuml;rfen shouten';
$txt['sbox_GuestVisible'] = 'Shoutbox ist f&uuml;r G&auml;ste sichtbar';
$txt['sbox_MaxLines'] = 'Anzahl der angezeigten Zeilen';
$txt['sbox_Height'] = 'Shoutbox-H&ouml;he (px)';
$txt['sbox_SmiliesVisible'] = 'Smiley-Zeile ist sichtbar';
$txt['sbox_UserLinksVisible'] = 'Shouter-Namen mit Profil verlinken';
$txt['sbox_KillShout'] = 'Diesen Shout löschen?';
$txt['sbox_TextSize1'] = '1. Schriftgr&ouml;&szlig;e';
$txt['sbox_TextColor1'] = '1. Schriftfarbe';
$txt['sbox_TextSize2'] = '2. Schriftgr&ouml;&szlig;e';
$txt['sbox_TextColor2'] = '2. Schriftfarbe';
$txt['sbox_RefreshTime'] = 'Aktualisierungsintervall';
$txt['sbox_BlockRefresh'] = 'Aktualisierung nach Inaktivit&auml;t stoppen (' . $modSettings['lastActive'] . ' min)';
$txt['sbox_BackgroundColor'] = 'Hintergrundfarbe';
$txt['sbox_FontFamily1'] = '1. Schriftart';
$txt['sbox_FontFamily2'] = '2. Schriftart';
$txt['sbox_DoHistory'] = 'Shout-Verlauf anlegen';
$txt['sbox_AllowBBC'] = 'BBCode erlauben';
$txt['sbox_Refresh'] = 'Neu laden';
$txt['sbox_RefreshBlocked'] = 'Automatische Aktualisierung wegen Inaktivit&auml;t ausgeschaltet';
$txt['sbox_History'] = 'Verlauf';
$txt['sbox_HistoryClear'] = 'Verlauf l&ouml;schen';
$txt['sbox_HistoryNotFound'] = 'Kein Verlauf gefunden.';
$txt['sbox_EnableSounds'] = 'Kl&auml;nge abspielen';

</add before>


<edit file>
$languagedir/Help.german.php
</edit file>

<search for>
?>
</search for>

<add before>
//SMF Shoutbox
$helptxt['sbox_Visible'] = 'Hier k&ouml;nnen Sie einstellen, ob die Shoutbox sichtbar ist oder nicht. Diese Einstellung gilt f&uuml;r ALLE Benutzer.';
$helptxt['sbox_GuestAllowed'] = 'Hier k&ouml;nnen Sie einstellen, ob G&auml;ste die Shoutbox benutzen d&uuml;rfen.';
$helptxt['sbox_GuestVisible'] = 'Hiermit k&ouml;nnen Sie festlegen, ob G&auml;ste die Shoutbox &uuml;berhaupt sehen k&ouml;nnen oder nicht.';
$helptxt['sbox_MaxLines'] = 'Geben Sie hier die Anzahl der Zeilen ein, die in der Shoutbox angezeigt werden sollen.';
$helptxt['sbox_Height'] = 'Bestimmen Sie hier die H&ouml;he der Shoutbox (Anzahl der Pixel).';
$helptxt['sbox_SmiliesVisible'] = 'Hier k&ouml;nnen Sie einstellen, ob die Smilies sichtbar sind oder nicht. Diese Einstellung gilt f&uuml;r ALLE Benutzer.';
$helptxt['sbox_UserLinksVisible'] = 'Legt fest, ob die Namen der Shouter mit deren Profilseite verlinkt werden sollen oder nicht.';
$helptxt['sbox_RefreshTime'] = 'Hier k&ouml;nnen Sie das Aktualisierungsintervall einstellen, also die Anzahl der Sekunden, die vergehen m&uuml;ssen, bevor sich die Shoutbox automatisch aktualisiert.';
$helptxt['sbox_BlockRefresh'] = 'Legt fest, ob die automatische Aktualisierung nach eine Weile Inaktivit&auml;t automatisch gestoppt werden soll. Benutzer k&ouml;nnen die Shoutbox weiterhin manuell aktualisieren. Die Zeitspanne wird unter <i>Zeit der Benutzeranzeige</i> in den <i>Standard-Funktionen</i> festgelegt. (Momentan ' . $modSettings['lastActive'] . ' Minuten)';
$helptxt['sbox_DoHistory'] = 'Legt fest, ob alle Shouts auch in eine Verlaufsdatei geschrieben werden sollen, so dass ein Administrator angebliche Vorf&auml;lle nachpr&uuml;fen kann.';
$helptxt['sbox_AllowBBC'] = 'Legt fest, ob Benutzer BBCode in Shouts benutzen k&ouml;nnen. Wenn dies deaktiviert ist, wird nur Klartext angezeigt - ohne Smileys oder Formatierungen.';
$helptxt['sbox_EnableSounds'] = 'Aktiviert einen Ton, der gespielt wird, wenn der eigene Nickname in einem neuen Shout auftaucht.';

</add before>
