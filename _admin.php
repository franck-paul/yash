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

dcCore::app()->menu[dcAdmin::MENU_BLOG]->addItem(
    __('YASH'),
    'plugin.php?p=yash',
    urldecode(dcPage::getPF('yash/icon.svg')),
    preg_match('/plugin.php\?p=yash(&.*)?$/', $_SERVER['REQUEST_URI']),
    dcCore::app()->auth->check(dcCore::app()->auth->makePermissions([
        dcAuth::PERMISSION_CONTENT_ADMIN,
    ]), dcCore::app()->blog->id)
);

dcCore::app()->addBehavior('adminPostEditor', [yashBehaviors::class, 'adminPostEditor']);
