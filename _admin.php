<?php
/**
 * @brief YASH, a plugin for Dotclear 2
 *
 * @package Dotclear
 * @subpackage Plugins
 *
 * @author Pep
 * @author Franck Paul
 *
 * @copyright Pep
 * @copyright GPL-2.0 https://www.gnu.org/licenses/gpl-2.0.html
 */
if (!defined('DC_CONTEXT_ADMIN')) {
    return;
}

// dead but useful code, in order to have translations
__('YASH') . __('Yet Another Syntax Highlighter');

$_menu['Blog']->addItem(__('YASH'),
    'plugin.php?p=yash',
    urldecode(dcPage::getPF('yash/icon.png')),
    preg_match('/plugin.php\?p=yash(&.*)?$/', $_SERVER['REQUEST_URI']),
    $core->auth->check('contentadmin', $core->blog->id));

$core->addBehavior('adminPostEditor', ['yashBehaviors', 'adminPostEditor']);
