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

use Dotclear\Helper\Clearbricks;

Clearbricks::lib()->autoload(['yashBehaviors' => __DIR__ . '/inc/yash.behaviors.php']);

dcCore::app()->addBehavior('coreInitWikiPost', [yashBehaviors::class, 'coreInitWikiPost']);
