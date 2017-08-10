<?php
/* Copyright (C) 2017	Denna Anass	<anass_denna@hotmail.fr>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

/**
 *       \file       htdocs/chat/tpl/message.tpl.php
 *       \brief      Template of message(s)
 */

$mod_path = $GLOBALS['mod_path'];

require_once DOL_DOCUMENT_ROOT.$mod_path.'/chat/lib/chat.lib.php';


global $db, $conf, $user;

$langs = $GLOBALS['langs'];
$object = $GLOBALS['object'];

$currentday = "";
$userstatic = new User($db);

// définition du nombre de message disponible
// $object->messages_count représente le nombre total de message dans la table sans limite
// tandis que count($object->messages) est limité (à 50 message par défaut)
$msgnumber = count($object->messages) > 0 ? $object->messages_count : 0;
print '<input id="msg_number" type="hidden" value="'.$msgnumber.'" />';

// affichage des messages
$messages = array_reverse($object->messages); // on inverse l'ordre du tableau car les messages y sont triés du plus nouveau au plus ancien (DESC), alors qu'on a besoin d'un tri ASC (ascendant)

foreach ($messages as $msg)
{
    $is_private_msg = ! empty($msg->fk_user_to);
    $is_mine = $msg->fk_user == $user->id;
    
    // initialisation des données de l'utilisateur (j'utilise $userstatic car j'ai besoin d'appeler des fonctions de cet objet)
    $userstatic->id = $msg->fk_user;
    $userstatic->firstname = $msg->user->firstname;
    $userstatic->lastname = $msg->user->lastname;
    $userstatic->gender = $msg->user->gender;
    $userstatic->photo = $msg->user->photo;

    // affichage par jour
    $postday = dol_print_date($db->jdate($msg->post_time),"daytextshort");

    if ($postday != $currentday)
    {
        $currentday = $postday;
        ?>
            <div class="alert alert-info msg-date <?php echo isset($show_date) && $show_date == "true" ? "" : "hidden"; ?>">
                <strong><?php echo $currentday; ?></strong>
            </div>
<?php
    }
?>
    <div class="media msg">
        <?php
            if ($user->rights->chat->delete->all || ($is_mine && $user->rights->chat->delete->mine))
            {
        ?>
        <input class="pull-left delete-checkbox hidden" type="checkbox" name="delete_message[]" value="<?php echo $msg->id; ?>" />
        <?php
            } // fin if ($user->rights->chat->delete->all || ($is_mine && $user->rights->chat->delete->mine))
        ?>
        <a class="user-image <?php echo ($is_mine ? "pull-left" : "pull-right").($is_private_msg ? " private" : ""); ?>" href="#" title="<?php echo $userstatic->getFullName($langs).($is_private_msg ? " (".$langs->trans("Private").")" : ""); ?>">
            <?php
                echo Form::showphoto('userphoto', $userstatic, 38, 38, 0, '', 'small', 0, 1);
            ?>
        </a>
        <div class="media-body <?php echo !empty($msg->attachment_name) ? "overflow-visible".($is_mine ? " margin-left" : " margin-right") : "" ?>">
            <small class="pull-right time" title="<?php echo $postday; ?>">
                <img class="btn-icon btn-small-icon" title="" alt="" src="<?php echo DOL_URL_ROOT.$mod_path.'/chat/img/time.png'; ?>" />
                <?php
                    echo dol_print_date($db->jdate($msg->post_time),"hour");
                ?>
            </small>
            <small class="msg-text">
                <?php
                    // On transforme les \r\n en <br/>
                    $message = str_replace(array("\\r\\n", "\\r", "\\n"), "<br/>", dol_escape_htmltag($msg->text)); // note that dol_escape_htmltag() replace \r with \\r & \n with \\n
                    
                    // On transforme les liens en URLs cliquables
                    $message = urllink($message);
                    
                    // On transforme/affiche les émoticones/smilies
                    $message = parseSmiley($message, DOL_URL_ROOT.$mod_path.'/chat/');
                    
                    echo $message;
                ?>
            </small>
            <?php
                // s'il y'a un attachment
                if (! empty($msg->attachment_name))
                {
            ?>
                    <?php
                        $is_image = in_array($msg->attachment_type, array("image/jpeg", "image/png", "image/gif"));

                        // s'il est de type image
                        if ($is_image && $conf->global->CHAT_SHOW_IMAGES_PREVIEW)
                        {
                    ?>
                        <div class="dropdown msg-attachment-dropdown">
                    <?php

                        }
                    ?>
                            <span class="msg-attachment">
                                <img class="btn-icon btn-small-icon" title="<?php echo $msg->attachment_name; ?>" alt="" src="<?php echo DOL_URL_ROOT.$mod_path.'/chat/img/attachment.png'; ?>"/>
                                <?php
                                    // Show attachment file name with link to download
                                    $filename = '/attachments/'.dol_sanitizeFileName($msg->attachment_name);

                                    $attachment = '<a data-ajax="false" href="'.DOL_URL_ROOT . '/document.php?modulepart=chat&amp;file='.urlencode($filename).'"';
                                    $attachment.= '>';
                                    $attachment.= cleanattachmentname($msg->attachment_name);
                                    $attachment.= '</a>'."\n";

                                    echo $attachment;
                                ?>
                            </span>
                    <?php
                        // si image affichage de son aperçu (on hover/au survol de l'image)
                        if ($is_image && $conf->global->CHAT_SHOW_IMAGES_PREVIEW)
                        {
                            $attachment_image = DOL_URL_ROOT . '/viewimage.php?modulepart=chat&entity=1&cache=1&file='.$filename;
                    ?>
                            <div class="dropdown-content dropdown-top">
                                <img class="dropdown-image" src="<?php echo $attachment_image; ?>" alt=""/>
                            </div>
                        </div>
                    <?php
                        }
                    ?>
            <?php
                }
            ?>
        </div> <!-- end div class="media-body" -->
    </div>
<?php

} // fin foreach

// si aucun message trouvé
//if (count($object->messages) == 0)
//{
//    echo $langs->trans("NoMessageFound");
//}
