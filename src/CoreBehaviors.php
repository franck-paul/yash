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

use Dotclear\Helper\Html\WikiToHtml;

class CoreBehaviors
{
    /**
     * @var array<string, string>
     */
    private static array $syntaxehl_brushes = [
        '4cs'           => '',
        'abap'          => '',
        'actionscript'  => 'as3',
        'ada'           => '',
        'apache'        => '',
        'applescript'   => 'applescript',
        'apt_sources'   => '',
        'asm'           => '',
        'asp'           => '',
        'autoconf'      => '',
        'autohotkey'    => '',
        'autoit'        => '',
        'avisynth'      => '',
        'awk'           => '',
        'bash'          => 'bash',
        'basic4gl'      => '',
        'bf'            => '',
        'bibtex'        => '',
        'blitzbasic'    => '',
        'bnf'           => '',
        'boo'           => '',
        'c'             => 'cpp',
        'c_mac'         => 'cpp',
        'caddcl'        => '',
        'cadlisp'       => '',
        'cfdg'          => '',
        'cfm'           => 'cf',
        'chaiscript'    => '',
        'cil'           => '',
        'clojure'       => '',
        'cmake'         => '',
        'cobol'         => '',
        'cpp-qt'        => 'cpp',
        'cpp'           => 'cpp',
        'csharp'        => 'csharp',
        'css'           => 'css',
        'cuesheet'      => '',
        'd'             => '',
        'dcs'           => '',
        'delphi'        => 'delphi',
        'diff'          => 'diff',
        'div'           => '',
        'dos'           => '',
        'dot'           => '',
        'ecmascript'    => 'js',
        'eiffel'        => '',
        'email'         => '',
        'erlang'        => 'erlang',
        'fo'            => '',
        'fortran'       => '',
        'freebasic'     => '',
        'fsharp'        => '',
        'gambas'        => '',
        'gdb'           => '',
        'genero'        => '',
        'genie'         => '',
        'gettext'       => '',
        'glsl'          => '',
        'gml'           => '',
        'gnuplot'       => '',
        'groovy'        => 'groovy',
        'gwbasic'       => '',
        'haskell'       => '',
        'hicest'        => '',
        'hq9plus'       => '',
        'html4strict'   => 'xml',
        'icon'          => '',
        'idl'           => '',
        'ini'           => '',
        'inno'          => 'delphi',
        'intercal'      => '',
        'io'            => '',
        'j'             => '',
        'java'          => 'java',
        'java5'         => 'java',
        'javascript'    => 'js',
        'jquery'        => 'js',
        'kixtart'       => '',
        'klonec'        => 'cpp',
        'klonecpp'      => 'cpp',
        'latex'         => '',
        'lisp'          => '',
        'locobasic'     => '',
        'logtalk'       => '',
        'lolcode'       => '',
        'lotusformulas' => '',
        'lotusscript'   => '',
        'lscript'       => '',
        'lsl2'          => '',
        'lua'           => '',
        'm68k'          => '',
        'magiksf'       => '',
        'make'          => '',
        'mapbasic'      => '',
        'matlab'        => '',
        'mirc'          => '',
        'mmix'          => '',
        'modula2'       => '',
        'modula3'       => '',
        'mpasm'         => '',
        'mxml'          => 'xml',
        'mysql'         => 'sql',
        'newlisp'       => '',
        'nsis'          => '',
        'oberon2'       => '',
        'objc'          => '',
        'ocaml-brief'   => '',
        'ocaml'         => '',
        'oobas'         => '',
        'oracle11'      => 'sql',
        'oracle8'       => 'sql',
        'oxygene'       => 'delphi',
        'oz'            => '',
        'pascal'        => '',
        'pcre'          => '',
        'per'           => '',
        'perl'          => 'pl',
        'perl6'         => 'pl',
        'pf'            => '',
        'php-brief'     => 'php',
        'php'           => 'php',
        'pic16'         => '',
        'pike'          => '',
        'pixelbender'   => '',
        'plsql'         => 'sql',
        'postgresql'    => 'sql',
        'povray'        => '',
        'powerbuilder'  => '',
        'powershell'    => 'ps',
        'progress'      => '',
        'prolog'        => '',
        'properties'    => '',
        'providex'      => '',
        'purebasic'     => '',
        'python'        => 'python',
        'q'             => '',
        'qbasic'        => '',
        'rails'         => 'ruby',
        'rebol'         => '',
        'reg'           => '',
        'robots'        => '',
        'rpmspec'       => '',
        'rsplus'        => '',
        'ruby'          => 'ruby',
        'sas'           => '',
        'scala'         => 'scala',
        'scheme'        => '',
        'scilab'        => '',
        'sdlbasic'      => '',
        'smalltalk'     => '',
        'smarty'        => '',
        'sql'           => 'sql',
        'systemverilog' => '',
        'tcl'           => '',
        'teraterm'      => '',
        'text'          => '',
        'thinbasic'     => '',
        'tsql'          => 'sql',
        'typoscript'    => '',
        'unicon'        => '',
        'vala'          => '',
        'vb'            => 'vb',
        'vbnet'         => 'vb',
        'verilog'       => '',
        'vhdl'          => '',
        'vim'           => '',
        'visualfoxpro'  => '',
        'visualprolog'  => '',
        'whitespace'    => '',
        'whois'         => '',
        'winbatch'      => '',
        'xbasic'        => '',
        'xml'           => 'xml',
        'xorg_conf'     => '',
        'xpp'           => '',
        'z80'           => '',
    ];

    public static function coreInitWikiPost(WikiToHtml $wiki): string
    {
        $wiki->registerFunction('macro:yash', static::transform(...));

        if ((bool) My::settings()->yash_syntaxehl) {
            // Add syntaxehl compatibility macros
            foreach (array_keys(self::$syntaxehl_brushes) as $brush) {
                $wiki->registerFunction('macro:[' . $brush . ']', static::transformSyntaxehl(...));
            }
        }

        return '';
    }

    /**
     * Transform macro
     *
     * @param      string       $text   The text
     * @param      string       $args   The arguments
     *
     * @return     string
     */
    public static function transform(string $text, string $args): string
    {
        $text      = trim((string) $text);
        $real_args = explode(' ', $args);
        $class     = empty($real_args[1]) ? 'plain' : $real_args[1];

        return '<pre class="brush: ' . $class . '">' . htmlspecialchars($text) . '</pre>';
    }

    /**
     * Transform macro (SyntaxeHL compliance)
     *
     * @param      string       $text   The text
     * @param      string       $args   The arguments
     *
     * @return     string
     */
    public static function transformSyntaxehl(string $text, string $args): string
    {
        $text      = trim((string) $text);
        $real_args = (string) preg_replace('/^(\[(.*)\]$)/', '$2', (string) $args);
        $class     = array_key_exists($real_args, self::$syntaxehl_brushes) && self::$syntaxehl_brushes[$real_args] != ''
        ? self::$syntaxehl_brushes[$real_args]
        : 'plain';

        return '<pre class="brush: ' . $class . '">' . htmlspecialchars($text) . '</pre>';
    }
}
