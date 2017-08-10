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
 *       \file       htdocs/chat/tpl/popup.tpl.php
 *       \brief      Template of chat popup
 */

$mod_path= $GLOBALS['mod_path'];
$langs = $GLOBALS['langs'];
$conf = $GLOBALS['conf'];

?>
<div id="chat_popup">
    <div class="panel panel-default">
        <div class="panel-heading" id="accordion">
            <span id="chat_popup_counter" class="label label-danger hidden">&nbsp;</span>
            <img class="align-middle" title="" alt="" src="<?php echo DOL_URL_ROOT.$mod_path.'/chat/img/'.($conf->global->CHAT_POPUP_TEXT_COLOR == '#fff' ? 'chat-16-white.png' : 'chat-16.png'); ?>" />
            <span id="chat_popup_title" class="align-middle"><?php echo $langs->trans("Module500001Name"); ?></span>
        </div>
    <div class="panel-collapse collapse" id="collapseOne">
        <div id="chat_popup_toolbox">
            <label id="chat-popup-back-btn" class="popup-option align-middle cursor-pointer hidden"><img class="btn-icon" title="" alt="" src="<?php echo DOL_URL_ROOT.$mod_path.'/chat/img/arrow-back.png'; ?>" /><?php echo ' '.$langs->trans("Back"); ?></label>
            <div id="online-users-switch" class="dropdown-click popup-option">
                <label class="drop-btn cursor-pointer">
                    <img class="btn-icon" title="" alt="" src="<?php echo DOL_URL_ROOT.$mod_path.'/chat/img/online.png'; ?>" />
                    <?php echo ' '.$langs->trans("OnlineUsers"); ?>
                    <span id="online-users-counter">(<?php echo count($object->users); ?>)</span>
                    <img class="btn-icon caret" title="" alt="" src="<?php echo DOL_URL_ROOT.$mod_path.'/chat/img/arrow-down.png'; ?>" />
                </label>
                <div class="dropdown-content dropdown-bottom">
                    <div id="users_container">
                        <?php
                            include_once DOL_DOCUMENT_ROOT.$mod_path.'/chat/tpl/user.tpl.php';
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div id="chat_container" class="panel-body msg-wrap">
            <?php
                include_once DOL_DOCUMENT_ROOT.$mod_path.'/chat/tpl/message.tpl.php';
            ?>
        </div>
        <div class="panel-footer">
            <div class="input-group">
                <input id="msg_input" type="text" class="form-control input-sm" placeholder="<?php echo $langs->trans("TypeAMessagePlaceHolder"); ?>" />
                <span class="input-group-btn">
                    <!-- Smiley -->
                    <div class="dropdown-click">
                        <label id="smiley-btn" class="drop-btn btn btn-default btn-sm"><img class="btn-icon" title="" alt="" src="<?php echo DOL_URL_ROOT.$mod_path.'/chat/img/smiley.png'; ?>" /></label>
                        <div id="smiley-dropdown" class="dropdown-content dropdown-top">
                            <?php echo printSmileyList(DOL_URL_ROOT.$mod_path.'/chat/'); ?>
                        </div>
                    </div>
                    <!-- Send -->
                    <button class="btn btn-default btn-sm" id="send_btn">
                        <img class="align-middle" title="" alt="" src="<?php echo DOL_URL_ROOT.$mod_path.'/chat/img/send.png'; ?>" />
                    </button>
                </span>
            </div>
        </div>
    </div>
    </div>
</div>
<?php
