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
 *       \file       htdocs/chat/ajax/ajax.php
 *       \brief      File to do ajax actions
 */

// Load Dolibarr environment
global $mod_path;
$mod_path = "";
if (false === (@include '../../main.inc.php')) {  // From htdocs directory
	require '../../../main.inc.php'; // From "custom" directory
        $mod_path = "/custom";
}

global $db, $langs, $user;

require_once DOL_DOCUMENT_ROOT."/core/lib/admin.lib.php";

dol_include_once($mod_path.'/chat/class/chat.class.php');

// Get parameters
$action	= GETPOST('action','alpha');
$filter_user = GETPOST('filter_user','alpha');
$show_date = GETPOST('show_date','alpha');
$user_to_id = ! empty(GETPOST('user_to_id','int')) ? GETPOST('user_to_id','int') : GETPOST('filter_by_user','int');
$only_online = GETPOST('only_online','alpha');
$state	= GETPOST('state','int');

// Access control
if ($user->socid > 0 || !$user->rights->chat->lire) {
	// External user
	accessforbidden();
}

/*
 * View
 */

top_httphead();

//print '<!-- Ajax page called with url '.$_SERVER["PHP_SELF"].'?'.$_SERVER["QUERY_STRING"].' -->'."\n";

// Actions
if (isset($action) && ! empty($action))
{
	if ($action == 'fetch_msgs')
	{
            $object = new Chat($db);
            
            // récupération des messages
            $result = $object->fetch_messages($user, $user_to_id);

            if ($result)
            {
                include_once DOL_DOCUMENT_ROOT.$mod_path.'/chat/tpl/message.tpl.php';
            }
        } // fin if ($action == 'fetch_msgs')
        else if ($action == 'fetch_users')
	{
            $object = new Chat($db);
            
            // récupération des utilisateurs
            $result = $object->fetch_users($user, 1, $filter_user, 1);
            
            if ($only_online == 'true') {
                // filter online users
                foreach ($object->users as $user_rowid => $f_user) {
                    if (! $f_user->is_online) {
                        unset($object->users[$user_rowid]);
                    }
                }
            }

            if ($result)
            {
                include_once DOL_DOCUMENT_ROOT.$mod_path.'/chat/tpl/user.tpl.php';
            }
        } // fin if ($action == 'fetch_users')
        else if ($action == 'get_popup_html')
	{
            $object = new Chat($db);
            
            // récupération des messages (to populate popup)
            $result = $object->fetch_messages($user);
            // PS: fetch_messages() get users without checking if online (so we can't use that..)
            
            if ($result)
            {
                // free users array
                unset($object->users);
                $object->users = array();
                
                // fetch users
                $result = $object->fetch_users($user, 1, $filter_user, 1);
                
                // filter online users
                foreach ($object->users as $user_rowid => $f_user) {
                    if (! $f_user->is_online) {
                        unset($object->users[$user_rowid]);
                    }
                }
                
                if ($result)
                {
                    include_once DOL_DOCUMENT_ROOT.$mod_path.'/chat/tpl/popup.tpl.php';
                }
            }
        } // fin if ($action == 'get_popup_html')
        else if ($action == 'set_popup_state')
	{
            $result = dolibarr_set_const($db, "CHAT_POPUP_OPENED",$state,'chaine',0,'',$conf->entity);
            
            //if ($result > 0)
            //{
                //print 'saved';
            //}
            //else
            //{
                //print 'error';
            //}
        } // fin if ($action == 'set_popup_state')
        else if ($action == 'send_msg')
	{
            $msg = GETPOST('msg', 'alpha');
            
            if (! empty($msg))
            {
                $_POST['action'] = 'send';
                $_POST['text'] = $msg;
                $_POST['user_to_id'] = $user_to_id;
                
                ob_start();
                
                include_once DOL_DOCUMENT_ROOT.$mod_path.'/chat/index.php';
                
                $output = ob_get_clean();
                
                //print $output;
            }
            //else
            //{
                //print 'empty msg';
            //}
        } // fin if ($action == 'send_msg')
}
