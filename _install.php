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

$new_version = dcCore::app()->plugins->moduleInfo('yash', 'version');
$old_version = dcCore::app()->getVersion('YASH');

if (version_compare($old_version, $new_version, '>=')) {
    return;
}

try {
    dcCore::app()->blog->settings->addNamespace('yash');
    dcCore::app()->blog->settings->yash->put('yash_active', false, 'boolean', '', false, true);
    dcCore::app()->blog->settings->yash->put('yash_theme', 'Default', 'string', '', false, true);
    dcCore::app()->blog->settings->yash->put('yash_custom_css', '', 'string', '', false, true);
    dcCore::app()->blog->settings->yash->put('yash_hide_gutter', false, 'boolean', '', false, true);
    dcCore::app()->blog->settings->yash->put('yash_syntaxehl', false, 'boolean', '', false, true);

    dcCore::app()->setVersion('YASH', $new_version);

    return true;
} catch (Exception $e) {
    dcCore::app()->error->add($e->getMessage());
}

return false;
