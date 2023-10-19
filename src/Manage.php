<?php
/**
 * @brief yash, a plugin for Dotclear 2
 *
 * @package Dotclear
 * @subpackage Plugins
 *
 * @author Franck Paul and contributors
 *
 * @copyright Franck Paul carnet.franck.paul@gmail.com
 * @copyright GPL-2.0 https://www.gnu.org/licenses/gpl-2.0.html
 */
declare(strict_types=1);

namespace Dotclear\Plugin\yash;

use dcCore;
use dcNamespace;
use Dotclear\App;
use Dotclear\Core\Backend\Notices;
use Dotclear\Core\Backend\Page;
use Dotclear\Core\Process;
use Dotclear\Helper\Html\Form\Checkbox;
use Dotclear\Helper\Html\Form\Fieldset;
use Dotclear\Helper\Html\Form\Form;
use Dotclear\Helper\Html\Form\Input;
use Dotclear\Helper\Html\Form\Label;
use Dotclear\Helper\Html\Form\Legend;
use Dotclear\Helper\Html\Form\Para;
use Dotclear\Helper\Html\Form\Select;
use Dotclear\Helper\Html\Form\Submit;
use Dotclear\Helper\Html\Form\Text;
use Dotclear\Helper\Html\Html;
use Exception;

class Manage extends Process
{
    /**
     * Initializes the page.
     */
    public static function init(): bool
    {
        return self::status(My::checkContext(My::MANAGE));
    }

    /**
     * Processes the request(s).
     */
    public static function process(): bool
    {
        if (!self::status()) {
            return false;
        }

        if (!empty($_POST['saveconfig'])) {
            try {
                $active      = (empty($_POST['active'])) ? false : true;
                $theme       = (empty($_POST['theme'])) ? 'Default' : $_POST['theme'];
                $custom_css  = (empty($_POST['custom_css'])) ? '' : Html::sanitizeURL($_POST['custom_css']);
                $hide_gutter = (empty($_POST['hide_gutter'])) ? false : true;
                $syntaxehl   = (empty($_POST['syntaxehl'])) ? false : true;

                $settings = My::settings();
                $settings->put('active', $active, dcNamespace::NS_BOOL);
                $settings->put('theme', $theme, dcNamespace::NS_STRING);
                $settings->put('custom_css', $custom_css, dcNamespace::NS_STRING);
                $settings->put('hide_gutter', $hide_gutter, dcNamespace::NS_BOOL);
                $settings->put('syntaxehl', $syntaxehl, dcNamespace::NS_BOOL);

                App::blog()->triggerBlog();

                Notices::addSuccessNotice(__('Configuration successfully updated.'));
                dcCore::app()->adminurl->redirect('admin.plugin.' . My::id());
            } catch (Exception $e) {
                dcCore::app()->error->add($e->getMessage());
            }
        }

        return true;
    }

    /**
     * Renders the page.
     */
    public static function render(): void
    {
        if (!self::status()) {
            return;
        }

        if (!empty($_REQUEST['popup'])) {
            $brushes = [
                'plain'       => __('Plain Text'),
                'applescript' => __('AppleScript'),
                'as3'         => __('ActionScript3'),
                'bash'        => __('Bash/shell'),
                'cf'          => __('ColdFusion'),
                'csharp'      => __('C#'),
                'cpp'         => __('C/C++'),
                'css'         => __('CSS'),
                'delphi'      => __('Delphi'),
                'diff'        => __('Diff/Patch'),
                'erl'         => __('Erlang'),
                'groovy'      => __('Groovy'),
                'haxe'        => __('Haxe'),
                'js'          => __('Javascript/JSON'),
                'java'        => __('Java'),
                'jfx'         => __('JavaFX'),
                'pl'          => __('Perl'),
                'php'         => __('PHP'),
                'ps'          => __('PowerShell'),
                'python'      => __('Python'),
                'ruby'        => __('Ruby'),
                'sass'        => __('SASS'),
                'scala'       => __('Scala'),
                'sql'         => __('SQL'),
                'tap'         => __('Tap'),
                'ts'          => __('TypeScript'),
                'vb'          => __('Visual Basic'),
                'xml'         => __('XML/XSLT/XHTML/HTML'),
                'yaml'        => __('Yaml'),
            ];

            $head = My::jsLoad('popup.js');

            Page::openModule(My::name() . ' - ' . __('Syntax Selector'), $head);

            echo
            (new Form('yash-form'))
                ->action(dcCore::app()->admin->getPageURL() . '&amp;popup=1')
                ->method('get')
                ->fields([
                    (new Para())
                    ->items([
                        (new Select('syntax'))
                            ->items(array_flip($brushes))
                            ->autofocus(true)
                            ->label((new Label(__('Select the primary syntax of your code snippet.'), Label::INSIDE_TEXT_BEFORE))),
                    ]),
                    (new Para())
                    ->separator(' ')
                    ->items([
                        (new Submit('yash-cancel'))
                            ->value(__('Cancel')),
                        (new Submit('yash-ok'))
                            ->value(__('Ok')),
                        ... My::hiddenFields(),
                    ]),
                ])
            ->render();

            Page::closeModule();

            return;
        }

        // Getting current parameters if any (get global parameters if not)

        $settings = My::settings();

        $active      = (bool) $settings->active;
        $theme       = (string) $settings->theme;
        $custom_css  = (string) $settings->custom_css;
        $hide_gutter = (bool) $settings->hide_gutter;
        $syntaxehl   = (bool) $settings->syntaxehl;

        $combo_theme = [
            __('Default')         => 'Default',
            __('Django')          => 'Django',
            __('Eclipse')         => 'Eclipse',
            __('Emacs')           => 'Emacs',
            __('Fade to gray')    => 'FadeToGrey',
            __('Material')        => 'Material',
            __('MD Ultra')        => 'MDUltra',
            __('Midnight')        => 'Midnight',
            __('RDark')           => 'RDark',
            __('Solarized Dark')  => 'SolarizedDark',
            __('Solarized Light') => 'SolarizedLight',
            __('Tomorrow Night')  => 'TomorrowNight',
        ];

        Page::openModule(My::name());

        echo Page::breadcrumb(
            [
                Html::escapeHTML(App::blog()->name()) => '',
                __('YASH')                            => '',
            ]
        );
        echo Notices::getNotices();

        // Form
        echo
        (new Form('yash_options'))
            ->action(dcCore::app()->admin->getPageURL())
            ->method('post')
            ->fields([
                (new Para())->items([
                    (new Checkbox('active', $active))
                        ->value(1)
                        ->label((new Label(__('Enable YASH'), Label::INSIDE_TEXT_AFTER))),
                ]),
                (new Fieldset())
                ->legend((new Legend(__('Presentation'))))
                ->fields([
                    (new Para())->items([
                        (new Select('theme'))
                            ->items($combo_theme)
                            ->default($theme)
                            ->label((new Label(__('Theme:'), Label::INSIDE_TEXT_BEFORE))),
                    ]),
                    (new Para())->items([
                        (new Input('custom_css'))
                            ->size(40)
                            ->maxlength(256)
                            ->value(Html::escapeHTML($custom_css))
                            ->label((new Label(__('Use custom CSS:'), Label::INSIDE_TEXT_BEFORE))),
                    ]),
                    (new Para())->class('info')->items([
                        (new Text(null, __('You can use a custom CSS by providing its location.') . '<br />' . __('A location beginning with a / is treated as absolute, else it is treated as relative to the blog\'s current theme URL'))),
                    ]),
                    (new Para())->items([
                        (new Checkbox('hide_gutter', $hide_gutter))
                            ->value(1)
                            ->label((new Label(__('Hide gutter with line numbers'), Label::INSIDE_TEXT_AFTER))),
                    ]),
                ]),
                (new Fieldset())
                ->legend((new Legend(__('Options'))))
                ->fields([
                    (new Para())->items([
                        (new Checkbox('syntaxehl', $syntaxehl))
                            ->value(1)
                            ->label((new Label(__('SyntaxeHL compatibility mode'), Label::INSIDE_TEXT_AFTER))),
                    ]),
                    (new Para())->class('info')->items([
                        (new Text(null, __('Will be applied on future edition of posts containing SyntaxeHL macros (///[language]…///).') . '<br />' . __('All SyntaxeHL languages is not supported by Yash (see documentation).'))),
                    ]),
                ]),
                (new Para())->items([
                    (new Submit(['saveconfig'], __('Save configuration')))
                        ->accesskey('s'),
                    ... My::hiddenFields(),
                ]),
            ])
        ->render();

        Page::closeModule();
    }
}
