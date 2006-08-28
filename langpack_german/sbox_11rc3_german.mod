<id>
SMF Shoutbox, German Language Pack
</id>

<version>
1.13
</version>

<mod info>
This is the german language pack for SMF shoutbox.

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
$languagedir/Help.german.php
</edit file>

<search for>
?>
</search for>

<add before>

//SMF Shoutbox
$helptxt['sbox_Visible'] = 'Hier k&ouml;nnen Sie einstellen, ob die Shoutbox sichtbar ist oder nicht. Diese Einstellung gilt f&uuml;r ALLE Benutzer.';
$helptxt['sbox_ModsRule'] = 'Dies erlaubt jedem, der die <i>moderate_board</i>-Berechtigung auf mindestens einem Board hat, Shouts zu l&ouml;schen.';
$helptxt['sbox_DoHistory'] = 'Legt fest, ob alle Shouts auch in eine Verlaufsdatei geschrieben werden sollen, so dass ein Administrator angebliche Vorf&auml;lle nachpr&uuml;fen kann.';

$helptxt['sbox_GuestVisible'] = 'Hiermit k&ouml;nnen Sie festlegen, ob G&auml;ste die Shoutbox &uuml;berhaupt sehen k&ouml;nnen oder nicht.';
$helptxt['sbox_GuestAllowed'] = 'Hier k&ouml;nnen Sie einstellen, ob G&auml;ste die Shoutbox benutzen d&uuml;rfen.';
$helptxt['sbox_GuestBBC'] = 'Hier k&ouml;nnen Sie BBCode f&uuml;r Gast-Shouts ein- oder ausschalten. Beachten Sie bitte, dass dies auch von der Einstellung <i>BBCode erlauben</i> abh&auml;ngig ist.';

$helptxt['sbox_SmiliesVisible'] = 'Hier k&ouml;nnen Sie einstellen, ob die Smilies sichtbar sind oder nicht. Diese Einstellung gilt f&uuml;r ALLE Benutzer.';
$helptxt['sbox_UserLinksVisible'] = 'Legt fest, ob die Namen der Shouter mit deren Profilseite verlinkt werden sollen oder nicht.';
$helptxt['sbox_AllowBBC'] = 'Legt fest, ob Benutzer BBCode in Shouts benutzen k&ouml;nnen. Wenn dies deaktiviert ist, wird nur Klartext angezeigt - ohne Smileys oder Formatierungen. Diese Option beeinflusst auch die <i>BBCode f&uuml;r G&auml;ste erlauben</i>-Option.';
$helptxt['sbox_NewShoutsBar'] = 'Ist diese Option aktiviert, wird eine Linie zwischen neuen Shouts (seit dem letzten Refresh) und &auml;lteren gezeigt.';

$helptxt['sbox_RefreshTime'] = 'Hier k&ouml;nnen Sie das Aktualisierungsintervall einstellen, also die Anzahl der Sekunden, die vergehen m&uuml;ssen, bevor sich die Shoutbox automatisch aktualisiert.';
$helptxt['sbox_BlockRefresh'] = 'Legt fest, ob die automatische Aktualisierung nach eine Weile Inaktivit&auml;t automatisch gestoppt werden soll. Benutzer k&ouml;nnen die Shoutbox weiterhin manuell aktualisieren. Die Zeitspanne wird unter <i>Zeit der Benutzeranzeige</i> in den <i>Standard-Funktionen</i> festgelegt. (Momentan ' . $modSettings['lastActive'] . ' Minuten)';
$helptxt['sbox_EnableSounds'] = 'Aktiviert einen Ton, der gespielt wird, wenn der eigene Nickname in einem neuen Shout auftaucht.';

</add before>
