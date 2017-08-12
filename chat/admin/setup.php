<?php
/* <one line to give the program's name and a brief idea of what it does.>
 * Copyright (C) <year>  <name of author>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * \file    admin/setup.php
 * \ingroup chat
 * \brief   Example module setup page.
 *
 * Put detailed description here.
 */

// Load Dolibarr environment
if (false === (@include '../../main.inc.php')) {  // From htdocs directory
	require '../../../main.inc.php'; // From "custom" directory
}

global $langs, $user;

// Libraries
require_once DOL_DOCUMENT_ROOT . "/core/lib/admin.lib.php";
require_once '../lib/chat.lib.php';

// Translations
$langs->load("admin");
$langs->load("chat@chat");

// Access control
if (! $user->admin) {
	accessforbidden();
}

// Parameters
$action = GETPOST('action','alpha');
$value = GETPOST('value','alpha');

/*
 * Actions
 */

if ($action == 'set_CHAT_AUTO_REFRESH_TIME')
{
        $error = 0;
        
	$auto_refresh_time = GETPOST('value_CHAT_AUTO_REFRESH_TIME', 'int');

        if (! empty($auto_refresh_time) && $auto_refresh_time > 0)
        {
            $res = dolibarr_set_const($db, "CHAT_AUTO_REFRESH_TIME",$auto_refresh_time,'chaine',0,'',$conf->entity);
            if (! $res > 0) $error++;
        }
        else
        {
            $error++;
        }

        if (! $error)
        {
            setEventMessages($langs->trans("SetupSaved"), null, 'mesgs');
        }
        else
        {
            setEventMessages($langs->trans("Error"), null, 'errors');
        }
}

// set max shown messages number
else if ($action == 'set_CHAT_MAX_MSG_NUMBER')
{
        $error = 0;
        
	$max_msg_number = GETPOST('value_CHAT_MAX_MSG_NUMBER', 'int');

        if (! empty($max_msg_number) && $max_msg_number > 0)
        {
            $res = dolibarr_set_const($db, "CHAT_MAX_MSG_NUMBER",$max_msg_number,'chaine',0,'',$conf->entity);
            if (! $res > 0) $error++;
        }
        else
        {
            $error++;
        }

        if (! $error)
        {
            setEventMessages($langs->trans("SetupSaved"), null, 'mesgs');
        }
        else
        {
            setEventMessages($langs->trans("Error"), null, 'errors');
        }
}

// set show images preview constant
else if ($action == 'set_CHAT_SHOW_IMAGES_PREVIEW')
{
    $res = dolibarr_set_const($db, "CHAT_SHOW_IMAGES_PREVIEW",$value,'chaine',0,'',$conf->entity);

    if (! $res > 0) $error++;

    if (! $error)
    {
        setEventMessages($langs->trans("SetupSaved"), null, 'mesgs');
    }
    else
    {
        setEventMessages($langs->trans("Error"), null, 'errors');
    }
}

// set enable chat popup constant
else if ($action == 'set_CHAT_ENABLE_POPUP')
{
    $res = dolibarr_set_const($db, "CHAT_ENABLE_POPUP",$value,'chaine',0,'',$conf->entity);

    if (! $res > 0) $error++;

    if (! $error)
    {
        setEventMessages($langs->trans("SetupSaved"), null, 'mesgs');
    }
    else
    {
        setEventMessages($langs->trans("Error"), null, 'errors');
    }
}

// set chat popup size constant
else if ($action == 'set_CHAT_POPUP_SIZE')
{
    $res = dolibarr_set_const($db, "CHAT_POPUP_SIZE",$value,'chaine',0,'',$conf->entity);

    if (! $res > 0) $error++;

    if (! $error)
    {
        setEventMessages($langs->trans("SetupSaved"), null, 'mesgs');
    }
    else
    {
        setEventMessages($langs->trans("Error"), null, 'errors');
    }
}

// set chat popup background color constant
else if ($action == 'set_CHAT_POPUP_BACKGROUND_COLOR')
{
    $res = dolibarr_set_const($db, "CHAT_POPUP_BACKGROUND_COLOR",$value,'chaine',0,'',$conf->entity);

    if (! $res > 0) $error++;

    if (! $error)
    {
        setEventMessages($langs->trans("SetupSaved"), null, 'mesgs');
    }
    else
    {
        setEventMessages($langs->trans("Error"), null, 'errors');
    }
}

// set chat popup text color constant
else if ($action == 'set_CHAT_POPUP_TEXT_COLOR')
{
    $res = dolibarr_set_const($db, "CHAT_POPUP_TEXT_COLOR",$value,'chaine',0,'',$conf->entity);

    if (! $res > 0) $error++;

    if (! $error)
    {
        setEventMessages($langs->trans("SetupSaved"), null, 'mesgs');
    }
    else
    {
        setEventMessages($langs->trans("Error"), null, 'errors');
    }
}

// set chat popup counter color constant
else if ($action == 'set_CHAT_POPUP_COUNTER_COLOR')
{
    $res = dolibarr_set_const($db, "CHAT_POPUP_COUNTER_COLOR",$value,'chaine',0,'',$conf->entity);

    if (! $res > 0) $error++;

    if (! $error)
    {
        setEventMessages($langs->trans("SetupSaved"), null, 'mesgs');
    }
    else
    {
        setEventMessages($langs->trans("Error"), null, 'errors');
    }
}

// set chat private message(s) border color constant
else if ($action == 'set_CHAT_PRIVATE_MSG_BORDER_COLOR')
{
    $res = dolibarr_set_const($db, "CHAT_PRIVATE_MSG_BORDER_COLOR",$value,'chaine',0,'',$conf->entity);

    if (! $res > 0) $error++;

    if (! $error)
    {
        setEventMessages($langs->trans("SetupSaved"), null, 'mesgs');
    }
    else
    {
        setEventMessages($langs->trans("Error"), null, 'errors');
    }
}

/*
 * View
 */

$page_name = "ChatSetup";
llxHeader('', $langs->trans($page_name));

// Subheader
$linkback = '<a href="' . DOL_URL_ROOT . '/admin/modules.php">'
	. $langs->trans("BackToModuleList") . '</a>';
print load_fiche_titre($langs->trans($page_name), $linkback);

// Configuration header
$head = chatAdminPrepareHead();
dol_fiche_head(
	$head,
	'settings',
	$langs->trans("Module500001Name"),
	0,
	"chat@chat"
);

// Setup page goes here
print load_fiche_titre($langs->trans("ChatConf"));

$var=true;
print '<table class="noborder" width="100%">';
print '<tr class="liste_titre">';
print '<td>'.$langs->trans("Parameters").'</td>'."\n";
print '<td align="right" width="150">'.$langs->trans("Value").'</td>'."\n";
print '<td width="80">&nbsp;</td></tr>'."\n";

// auto refresh time
$var=!$var;
print '<form action="'.$_SERVER["PHP_SELF"].'" method="POST">';
print '<input type="hidden" name="token" value="'.$_SESSION['newtoken'].'" />';
print '<input type="hidden" name="action" value="set_CHAT_AUTO_REFRESH_TIME" />';
print '<tr '.$bc[$var].'>';
print '<td>'.$langs->trans("ChatAutoRefreshTime").'</td>';
print '<td align="right"><input size="3" type="text" class="flat" name="value_CHAT_AUTO_REFRESH_TIME" value="'.$conf->global->CHAT_AUTO_REFRESH_TIME.'"></td>';
print '<td align="right">';
print '<input type="submit" class="button" value="'.$langs->trans("Modify").'">';
print '</td>';
print '</tr>';
print '</form>';

// max messages number
$var=!$var;
print '<form action="'.$_SERVER["PHP_SELF"].'" method="POST">';
print '<input type="hidden" name="token" value="'.$_SESSION['newtoken'].'" />';
print '<input type="hidden" name="action" value="set_CHAT_MAX_MSG_NUMBER" />';
print '<tr '.$bc[$var].'>';
print '<td>'.$langs->trans("ChatMaxMsgNumber").'</td>';
print '<td align="right"><input size="3" type="text" class="flat" name="value_CHAT_MAX_MSG_NUMBER" value="'.$conf->global->CHAT_MAX_MSG_NUMBER.'"></td>';
print '<td align="right">';
print '<input type="submit" class="button" value="'.$langs->trans("Modify").'">';
print '</td>';
print '</tr>';
print '</form>';

// show images preview
$var=!$var;
print '<tr '.$bc[$var].'><td>';
print $langs->trans("ShowImagesPreview").'</td><td>&nbsp</td><td align="center">';
if (empty($conf->global->CHAT_SHOW_IMAGES_PREVIEW))
{
    print '<a href="'.$_SERVER['PHP_SELF'].'?action=set_CHAT_SHOW_IMAGES_PREVIEW&amp;value=1">'.img_picto($langs->trans("Disabled"),'switch_off').'</a>';
}
else
{
    print '<a href="'.$_SERVER['PHP_SELF'].'?action=set_CHAT_SHOW_IMAGES_PREVIEW&amp;value=0">'.img_picto($langs->trans("Enabled"),'switch_on').'</a>';
}
print '</td></tr>';

// enable chat popup
$var=!$var;
print '<tr '.$bc[$var].'><td>';
print $langs->trans("EnableChatPopup").'</td><td>&nbsp</td><td align="center">';
if (empty($conf->global->CHAT_ENABLE_POPUP))
{
    print '<a href="'.$_SERVER['PHP_SELF'].'?action=set_CHAT_ENABLE_POPUP&amp;value=1">'.img_picto($langs->trans("Disabled"),'switch_off').'</a>';
}
else
{
    print '<a href="'.$_SERVER['PHP_SELF'].'?action=set_CHAT_ENABLE_POPUP&amp;value=0">'.img_picto($langs->trans("Enabled"),'switch_on').'</a>';
}
print '</td></tr>';

// popup size
$var=!$var;
print '<form action="'.$_SERVER["PHP_SELF"].'" method="POST">';
print '<input type="hidden" name="token" value="'.$_SESSION['newtoken'].'" />';
print '<input type="hidden" name="action" value="set_CHAT_POPUP_SIZE" />';
print '<tr '.$bc[$var].'>';
print '<td>'.$langs->trans("ChatPopupSize").'</td>';
print '<td align="right">';
print '<select class="flat" name="value">';
print '<option value="30%"'.($conf->global->CHAT_POPUP_SIZE == '30%' ? ' selected' : '').'>'.$langs->trans("Small").'</option>';
print '<option value="40%"'.($conf->global->CHAT_POPUP_SIZE == '40%' ? ' selected' : '').'>'.$langs->trans("Medium").'</option>';
print '<option value="50%"'.($conf->global->CHAT_POPUP_SIZE == '50%' ? ' selected' : '').'>'.$langs->trans("Large").'</option>';
print '</select>';
print '</td>';
print '<td align="right">';
print '<input type="submit" class="button" value="'.$langs->trans("Modify").'">';
print '</td>';
print '</tr>';
print '</form>';

// popup background color
$var=!$var;
print '<form action="'.$_SERVER["PHP_SELF"].'" method="POST">';
print '<input type="hidden" name="token" value="'.$_SESSION['newtoken'].'" />';
print '<input type="hidden" name="action" value="set_CHAT_POPUP_BACKGROUND_COLOR" />';
print '<tr '.$bc[$var].'>';
print '<td>'.$langs->trans("ChatPopupBackgroundColor").'</td>';
print '<td align="right">';
print '<span id="popup-background-color-preview" style="display: inline-block; padding: 10px; border: 2px solid #ddd; border-radius: 50%; vertical-align: middle; margin-right: 10px; background: '.$conf->global->CHAT_POPUP_BACKGROUND_COLOR.';"></span>';
print '<select class="flat" name="value" onchange="$(\'#popup-background-color-preview\').css(\'background\', $(this).val());">';
print '<option value="#e8e6e7"'.($conf->global->CHAT_POPUP_BACKGROUND_COLOR == '#e8e6e7' ? ' selected' : '').'>'.$langs->trans("LightGrey").'</option>';
print '<option value="#777"'.($conf->global->CHAT_POPUP_BACKGROUND_COLOR == '#777' ? ' selected' : '').'>'.$langs->trans("Grey").'</option>';
print '<option value="#428bca"'.($conf->global->CHAT_POPUP_BACKGROUND_COLOR == '#428bca' ? ' selected' : '').'>'.$langs->trans("Blue").'</option>';
print '<option value="#5cb85c"'.($conf->global->CHAT_POPUP_BACKGROUND_COLOR == '#5cb85c' ? ' selected' : '').'>'.$langs->trans("Green").'</option>';
print '<option value="#5bc0de"'.($conf->global->CHAT_POPUP_BACKGROUND_COLOR == '#5bc0de' ? ' selected' : '').'>'.$langs->trans("SkyBlue").'</option>';
print '<option value="#f0ad4e"'.($conf->global->CHAT_POPUP_BACKGROUND_COLOR == '#f0ad4e' ? ' selected' : '').'>'.$langs->trans("Orange").'</option>';
print '<option value="#d9534f"'.($conf->global->CHAT_POPUP_BACKGROUND_COLOR == '#d9534f' ? ' selected' : '').'>'.$langs->trans("Red").'</option>';
print '</select>';
print '</td>';
print '<td align="right">';
print '<input type="submit" class="button" value="'.$langs->trans("Modify").'">';
print '</td>';
print '</tr>';
print '</form>';

// popup text color
$var=!$var;
print '<form action="'.$_SERVER["PHP_SELF"].'" method="POST">';
print '<input type="hidden" name="token" value="'.$_SESSION['newtoken'].'" />';
print '<input type="hidden" name="action" value="set_CHAT_POPUP_TEXT_COLOR" />';
print '<tr '.$bc[$var].'>';
print '<td>'.$langs->trans("ChatPopupTextColor").'</td>';
print '<td align="right">';
print '<span id="popup-text-color-preview" style="display: inline-block; padding: 10px; border: 2px solid #ddd; border-radius: 50%; vertical-align: middle; margin-right: 10px; background: '.$conf->global->CHAT_POPUP_TEXT_COLOR.';"></span>';
print '<select class="flat" name="value" onchange="$(\'#popup-text-color-preview\').css(\'background\', $(this).val());">';
print '<option value="#fff"'.($conf->global->CHAT_POPUP_TEXT_COLOR == '#fff' ? ' selected' : '').'>'.$langs->trans("White").'</option>';
print '<option value="#333"'.($conf->global->CHAT_POPUP_TEXT_COLOR == '#333' ? ' selected' : '').'>'.$langs->trans("Black").'</option>';
print '</select>';
print '</td>';
print '<td align="right">';
print '<input type="submit" class="button" value="'.$langs->trans("Modify").'">';
print '</td>';
print '</tr>';
print '</form>';

// popup counter color
$var=!$var;
print '<form action="'.$_SERVER["PHP_SELF"].'" method="POST">';
print '<input type="hidden" name="token" value="'.$_SESSION['newtoken'].'" />';
print '<input type="hidden" name="action" value="set_CHAT_POPUP_COUNTER_COLOR" />';
print '<tr '.$bc[$var].'>';
print '<td>'.$langs->trans("ChatPopupCounterColor").'</td>';
print '<td align="right">';
print '<span id="popup-counter-color-preview" style="display: inline-block; padding: 10px; border: 2px solid #ddd; border-radius: 50%; vertical-align: middle; margin-right: 10px; background: '.$conf->global->CHAT_POPUP_COUNTER_COLOR.';"></span>';
print '<select class="flat" name="value" onchange="$(\'#popup-counter-color-preview\').css(\'background\', $(this).val());">';
print '<option value="#777"'.($conf->global->CHAT_POPUP_COUNTER_COLOR == '#777' ? ' selected' : '').'>'.$langs->trans("Grey").'</option>';
print '<option value="#428bca"'.($conf->global->CHAT_POPUP_COUNTER_COLOR == '#428bca' ? ' selected' : '').'>'.$langs->trans("Blue").'</option>';
print '<option value="#5cb85c"'.($conf->global->CHAT_POPUP_COUNTER_COLOR == '#5cb85c' ? ' selected' : '').'>'.$langs->trans("Green").'</option>';
print '<option value="#5bc0de"'.($conf->global->CHAT_POPUP_COUNTER_COLOR == '#5bc0de' ? ' selected' : '').'>'.$langs->trans("SkyBlue").'</option>';
print '<option value="#f0ad4e"'.($conf->global->CHAT_POPUP_COUNTER_COLOR == '#f0ad4e' ? ' selected' : '').'>'.$langs->trans("Orange").'</option>';
print '<option value="#d9534f"'.($conf->global->CHAT_POPUP_COUNTER_COLOR == '#d9534f' ? ' selected' : '').'>'.$langs->trans("Red").'</option>';
print '</select>';
print '</td>';
print '<td align="right">';
print '<input type="submit" class="button" value="'.$langs->trans("Modify").'">';
print '</td>';
print '</tr>';
print '</form>';

// private message border color
$var=!$var;
print '<form action="'.$_SERVER["PHP_SELF"].'" method="POST">';
print '<input type="hidden" name="token" value="'.$_SESSION['newtoken'].'" />';
print '<input type="hidden" name="action" value="set_CHAT_PRIVATE_MSG_BORDER_COLOR" />';
print '<tr '.$bc[$var].'>';
print '<td>'.$langs->trans("ChatPrivateMessageBorderColor").'</td>';
print '<td align="right">';
print '<span id="private-msg-border-color-preview" style="display: inline-block; padding: 10px; border: 2px solid #ddd; border-radius: 50%; vertical-align: middle; margin-right: 10px; background: '.$conf->global->CHAT_PRIVATE_MSG_BORDER_COLOR.';"></span>';
print '<select class="flat" name="value" onchange="$(\'#private-msg-border-color-preview\').css(\'background\', $(this).val());">';
print '<option value="#fff"'.($conf->global->CHAT_PRIVATE_MSG_BORDER_COLOR == '#fff' ? ' selected' : '').'>'.$langs->trans("White").'</option>';
print '<option value="#777"'.($conf->global->CHAT_PRIVATE_MSG_BORDER_COLOR == '#777' ? ' selected' : '').'>'.$langs->trans("Grey").'</option>';
print '<option value="#428bca"'.($conf->global->CHAT_PRIVATE_MSG_BORDER_COLOR == '#428bca' ? ' selected' : '').'>'.$langs->trans("Blue").'</option>';
print '<option value="#5cb85c"'.($conf->global->CHAT_PRIVATE_MSG_BORDER_COLOR == '#5cb85c' ? ' selected' : '').'>'.$langs->trans("Green").'</option>';
print '<option value="#5bc0de"'.($conf->global->CHAT_PRIVATE_MSG_BORDER_COLOR == '#5bc0de' ? ' selected' : '').'>'.$langs->trans("SkyBlue").'</option>';
print '<option value="#f0ad4e"'.($conf->global->CHAT_PRIVATE_MSG_BORDER_COLOR == '#f0ad4e' ? ' selected' : '').'>'.$langs->trans("Orange").'</option>';
print '<option value="#d9534f"'.($conf->global->CHAT_PRIVATE_MSG_BORDER_COLOR == '#d9534f' ? ' selected' : '').'>'.$langs->trans("Red").'</option>';
print '</select>';
print '</td>';
print '<td align="right">';
print '<input type="submit" class="button" value="'.$langs->trans("Modify").'">';
print '</td>';
print '</tr>';
print '</form>';

print '</table>';

// Page end
dol_fiche_end();
llxFooter();

$db->close();
