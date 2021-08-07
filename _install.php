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

$new_version = $core->plugins->moduleInfo('yash', 'version');
$old_version = $core->getVersion('YASH');

if (version_compare($old_version, $new_version, '>=')) {
    return;
}

try {
    $core->blog->settings->addNamespace('yash');
    $core->blog->settings->yash->put('yash_active', false, 'boolean', '', false, true);
    $core->blog->settings->yash->put('yash_theme', 'Default', 'string', '', false, true);
    $core->blog->settings->yash->put('yash_custom_css', '', 'string', '', false, true);
    $core->blog->settings->yash->put('yash_hide_gutter', false, 'boolean', '', false, true);
    $core->blog->settings->yash->put('yash_syntaxehl', false, 'boolean', '', false, true);

    $core->setVersion('YASH', $new_version);

    return true;
} catch (Exception $e) {
    $core->error->add($e->getMessage());
}

return false;
