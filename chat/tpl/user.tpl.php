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

$userstatic = new User($db);

// affichage des utilisateurs
foreach ($object->users as $obj)
{
    $userstatic->id=$obj->rowid;
    $userstatic->firstname=$obj->firstname;
    $userstatic->lastname=$obj->lastname;
    $userstatic->gender=$obj->gender;
    $userstatic->photo=$obj->photo;
    // j'ai spécifié juste ces attributs car ce sont les attributs nécessaires pour les fonctions de récupération de nom complet et photo
?>
    <a class="user-anchor" href="<?php echo DOL_URL_ROOT.$mod_path.'/chat/index.php?action=private_msg&user_to_id='.$obj->rowid; ?>" title="<?php echo $langs->trans("SendPrivateMessage"); ?>">
        <div class="media conversation <?php echo ($obj->is_online ? "is_online" : "").($obj->admin ? " is_admin" : ""); ?>">
            <span class="pull-left user-image">
                <?php
                    echo Form::showphoto('userphoto', $userstatic, 64, 64, 0, '', 'small', 0, 1);
                ?>
            </span>
            <div class="media-body">
                <h5 class="media-heading">
                    <span>
                        <?php
                            echo $userstatic->getFullName($langs);
                        ?>
                    </span>
                    <?php
                        if (! empty($conf->multicompany->enabled) && $obj->admin && ! $obj->entity)
                        {
                            print img_picto($langs->trans("SuperAdministrator"),'redstar');
                        }
                        else if ($obj->admin)
                        {
                            print img_picto($langs->trans("Administrator"),'star');
                        }

                        // si utilisateur en ligne
                        if ($obj->is_online)
                        {
                            print ' <img class="online-icon align-middle" title="'.$langs->trans("Online").'" alt="" src="'.DOL_URL_ROOT.$mod_path.'/chat/img/online.png"/>';
                        }
                    ?>
                </h5>
                <small><?php echo $langs->trans("LastLogin").' '.dol_print_date($db->jdate($obj->datelastlogin),"dayhour"); ?></small>
            </div>
        </div>
    </a>
<?php

} // fin foreach

// si aucun utilisateur dolibarr trouvé
//if (count($object->users) == 0)
//{
//    echo $langs->trans("NoUserFound");
//}
